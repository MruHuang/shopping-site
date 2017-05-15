<?php

namespace App\Order;

use App\Order\ProductInformation as PI;
use App\Login\Login as LG;
use App\MemberCommodity\MemberCommodityCount as MCC;
use App\Mail\MailSent as MailS;

class Order
{
    private $pi;
    private $lg;
    private $mcc;

    public function __construct(PI $pi,LG $lg,MCC $mcc, MailS $MailSent){
        $this->pi = $pi;
        $this->lg = $lg;
        $this->mcc = $mcc;
        $this->MailSent = $MailSent;
    }
    //

    public function Order($state){
        $result = null;
        $memberID = $this->lg->LoginSessionID();
        if($memberID != null){
            if($state == 'Unpaid'){
                $result = $this->pi->GetUnpaid($memberID);
                for($i=0;$i<count($result);$i++){
                    $result[$i]['OrderCommodityName'] = $this->GetOrderCommodityName($result[$i]['orderID']);
                }
            }
            else if($state == 'Check'){
                $result = $this->pi->GetCheck($memberID);
                for($i=0;$i<count($result);$i++){
                    $result[$i]['OrderCommodityName'] = $this->GetOrderCommodityName($result[$i]['orderID']);
                }
            }
            else if($state == 'Ready'){
                $result = $this->pi->GetReady($memberID);
                for($i=0;$i<count($result);$i++){
                    $result[$i]['OrderCommodityName'] = $this->GetOrderCommodityName($result[$i]['orderID']);
                }
            }
            else if($state == 'Delivery'){
                $result = $this->pi->GetDelivery($memberID);
                for($i=0;$i<count($result);$i++){
                    $result[$i]['OrderCommodityName'] = $this->GetOrderCommodityName($result[$i]['orderID']);
                }
            }
            else if($state == 'Carryout'){
                $result = $this->pi->GetCarryout($memberID);
                for($i=0;$i<count($result);$i++){
                    $result[$i]['OrderCommodityName'] = $this->GetOrderCommodityName($result[$i]['orderID']);
                }
            }
        }
        return $result;
    }

    public function GetOrderCommodityName($orderID){
        $OrderDetailData = $this->pi->GetOrderInformation($orderID);
        $OrderCommodityName = "";
        for ($j=0; $j < count($OrderDetailData); $j++) {
            if($j == count($OrderDetailData)-1){
                $OrderCommodityName = $OrderCommodityName.$OrderDetailData[$j]['commodityName'];
            }else{
                $OrderCommodityName = $OrderCommodityName.$OrderDetailData[$j]['commodityName']."、";
            }
        }
        if(mb_strlen($OrderCommodityName)>10){
            $OrderCommodityName = mb_substr($OrderCommodityName, 0, 12, 'UTF-8');
            $OrderCommodityName = $OrderCommodityName."...";
        }
        return $OrderCommodityName;
    }

    // public function ReviseOrder($OrderData){
    //     for($i=0;$i<count($OrderData);$i++){
    //         if($OrderData[$i]['orderClass']=='groupbuy'&&$OrderData[$i]['totalPrice']==0){
    //             $OrderDetailData = $this->pi->GetOrderInformation($OrderData[$i]['orderID']);
    //             $nowPrice = $this->mcc->MemberGroupbuyNowPrice($OrderDetailData[0]['groupbuyID'],'groupbuy');
    //             $OrderData[$i]['totalPrice'] = $nowPrice*$OrderDetailData[0]['commodityAmount'];
    //             $PromotionData = $this->pi->GetPromotionData();
    //             $MemberData = $this->pi->GetMemberData($OrderData[$i]['memberID']);
    //             $OrderData[$i]['orderData'] = $OrderDetailData;
    //             $OrderData[$i]['MemberData'] = $MemberData;
    //         }
    //     }
    //     return $OrderData;
    // }
    public function SingleOrder($orderID){
        $result = $this->pi->GetSingle($orderID);
        return $result;
    }

    public function UpdateFiveNumber(
        $orderID,
        $fiveNumber
    ){
        $this->pi->UpdateFiveNumber(
            $orderID,
            $fiveNumber
        );
        $M_Email = $this->pi->GetmanagerEmail();
        foreach($M_Email as $One_Email){
            $this->MailSent->SentMailGetManager(
                $orderID,
                $fiveNumber,
                $One_Email['managerEmail']
            );
        }
    }
    public function CancelOrder($orderID){
        return $this->pi->CancelOrder($orderID);
    }

    public function OrderDel($orderID){
        return $this->pi->OrderDel($orderID);
    }

    public function AddCancel(){
        $memberID = $this->lg->LoginSessionID();
        return $this->pi->AddCancel($memberID);
    }

    public function AddIntegral($orderID){
        $memberID = $this->lg->LoginSessionID();
        return $this->pi->AddIntegral($memberID,$orderID);
    }
}
