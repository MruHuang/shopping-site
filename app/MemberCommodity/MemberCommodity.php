<?php

namespace App\MemberCommodity;

use App\MemberCommodity\MemberCommodityInformation as MCI;

use App\MemberCommodity\MemberCommodityInsertOrder as MCIO;

use App\Login\Login as LG;
use DateTime;
class MemberCommodity
{
    private $lg;
    private $mci;
    private $mcio;
   
    public function __construct(LG $lg,MCI $mci, MCIO $mcio){
        $this->lg = $lg;
        $this->mci = $mci;
        $this->mcio = $mcio;
    }

    public function MemberCommodity(
        $ID,
        $speciestype
    ){
        $commodity_information = $this->mci->GetMemberCommodity(
            $ID,
            $speciestype
        );
        $result = array();
        foreach ($commodity_information as $key => $value) {
            foreach ($value as $key2 => $value2) {
                array_push($result, $value2);
            }
        }

        return  array_values(array_sort($result, function($value){
            return $value['user_time'];
        }));
    }
    public function UpdateMemberCommodity($json_data){
        foreach ($json_data as $key => $value) {
            $this->mci->UpdateMemberCommodity($json_data[$key]->userID,$json_data[$key]->Amount);
        }
    }
    
    public function InsertToOrder($data_array){
        $totalPrice = 0;
        $is_ordered = 0;
        foreach ($data_array['jsondata'] as $key => $value) {
            $result_array = null;
            if($value['Area'] != 'groupbuy'){
	            if($value['Area'] == 'commodity'){
	                $result_array = $this->mcio->SelectCommodity($value['ID']);
	            }
	            else if($value['Area'] == 'timelimit'){
	                $result_array = $this->mcio->SelectTimelimit($value['ID']);
                    //判別限時商品下架時間
                    $Nowtime = new DateTime();
                    if($result_array[0]['Offtime'] < $Nowtime->format('Y-m-d')){
                        return "限量商品已過時，請刪除限量商品";
                    }
	            }

                //判別上架情況
                if($result_array[0]['isShelves'] != 1){
                    //return $result_array[0]['isShelves'];
                    return "物品已下架，請刪除下架商品";
                }

                //判別物品剩於數量
	            if($result_array[0]['Amount'] >= $value['Amount'] && $result_array[0]['Amount']  != 0){
	                $totalPrice += ($result_array[0]['Price']*$value['Amount']);
                    $final_Amount = $result_array[0]['Amount'] - $value['Amount'];
                    $this->mcio->updateCommodityAmount($value['Area'],$value['ID'],$final_Amount);
	            }
	            else{
	                return "物品數量不夠";//物品數量不夠
	            } 
                $is_ordered = 1;
			}else{
                $result_array = $this->mcio->SelectGroupbuy($value['ID']);
                if($result_array[0]['isShelves'] != 1){
                   // return $result_array[0]['isShelves'];
                    return "物品已下架，請刪除下架商品";
                }
            }
        }

        $orderState = 'Unpaid';
        if($data_array['checkoutMethod'] == 'ATM'){
            $orderState = 'Unpaid';
        }
        else if($data_array['checkoutMethod'] == 'CASH'){
            $orderState = 'Ready';
        }
        else if($data_array['checkoutMethod'] == '貨到付款'){
            $orderState = 'Ready';
        }

        //判別積分
        $useIntegral = "0";
        if($data_array['orderclass'] == 'groupbuy'){
            if($data_array['is_useIntegral'] == 'on'){
                $useIntegral = "1";//團購訂單有使用積分
            }
        }else{
            if($data_array['is_useIntegral'] == 'on'){
                $tempMemberIntegral = $this->mcio->SelectMemberMemberIntegral($data_array['memberID']);
                $useIntegral = $tempMemberIntegral[0]['memberIntegral'];
                $tempUseIntegral = $this->mcio->SelectMemberMemberUseIntegral($data_array['memberID']);
                $memberUseIntegral = $tempUseIntegral[0]['memberUseIntegral'];
                if($totalPrice>$useIntegral){
                    $totalPrice = $totalPrice - $useIntegral;
                    $overIntegral = 0;
                }else{
                    $overIntegral = $useIntegral - $totalPrice;
                    $useIntegral = $totalPrice;
                    $totalPrice = 0;
                }
                try{
                    $this->mcio->UpdateMemberIntegral($data_array['memberID'], $overIntegral);
                    $this->mcio->UpdateMemberUseIntegral($data_array['memberID'], $memberUseIntegral + $useIntegral);
                    $this->lg->UpdateSessionData();
                }catch(\Exception $e){
                    return "程序錯誤";
                }
            }
        }
        //判別運費
        $promotion_data = $this->mcio->SelectPromotion();
        if($data_array['orderclass'] != 'groupbuy'){
            $freight = $promotion_data[0]['freight'];
            if($promotion_data[0]['freeFreight'] < $totalPrice){
                $freight = "0";
            }else{
                $totalPrice = $totalPrice + $freight;
            }
        }else{
            $freight = "0";
        }

        $orderclass = 'nogroupbuy';
        if($data_array['orderclass'] == 'groupbuy'){
            $orderclass = 'groupbuy';
        }
        //新增訂單
        // $random_number = strval(time()).str_random(5);
        $this->mcio->InsertOrder(
            $data_array['memberID'],
            $data_array['random_number'],
            $is_ordered,
            $totalPrice,
            $orderState,
            $data_array['recipient'],
            $data_array['deliveryAdd'],
            $data_array['checkoutMethod'],
            $freight,
            $useIntegral,
            "00000",
            $orderclass
        );
        //新增訂單詳細資訊
        $order_array = $this->mcio->SelectOrderID(
            $data_array['memberID'],
            $data_array['random_number'],
            $totalPrice,
            $orderState,
            $data_array['recipient'],
            $data_array['deliveryAdd'],
            $data_array['checkoutMethod'],
            $freight,
            $useIntegral,
            "00000",
            $orderclass
        );
        $orderID = $order_array[0]['orderID'];
        foreach ($data_array['jsondata'] as $key => $value) {
            if($value['Area'] == 'commodity'){
                $commodity_data = $this->mci->GetCommodity($value['ID']);
                $buyPrice = $commodity_data[0]['commodityPrice'];
                $originalID = $commodity_data[0]['commodityID'];
            }else if($value['Area'] == 'timelimit'){
                $commodity_data = $this->mci->GetTimelimitCommodity($value['ID']);
                $buyPrice = $commodity_data[0]['limitedPrice'];
                $originalID = $commodity_data[0]['commodityID'];
            }else{
                $commodity_data = $this->mci->GetGroupbuyCommodity($value['ID']);
                $buyPrice = 0;
                $originalID = $commodity_data[0]['commodityID'];
            }
            $this->mcio->InsertOrder_detailed(
                $orderID,
                $value['ID'],
                $originalID,
                $value['Area'],
                $value['Amount'],
                $buyPrice
            );
        }
        return 1;
    }
    
    public function Getpromotion(){
        $result = $this->mci->Getpromotion();
        return $result;
    }

    public function GetOrder($random_number){
        $result = $this->mci->GetOrder($random_number);
        return $result;
    }

    public function GetOrderDetailed($ID){
        $result = $this->mci->GetOrderDetailed($ID);
        return $result;
    }

    public function getClassIfication($commodity_information){

    }

}
