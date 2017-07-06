<?php

namespace App\MemberCommodity;

use App\Model\commodity as cmSQL;
use App\Model\groupbuy_commodity as gcSQL;
use App\Model\limited_commodity as lcSQL;
use App\Model\Member as mbSQL;
use App\Model\Member_commodity as mcSQL;
use App\Model\order_detailed as oddSQL;
use App\Model\merchandise_order as odSQL;
use App\Model\promotion as ptSQL;


class MemberCommodityInsertOrder
{
    public function SelectCommodity($ID){
        return cmSQL::FindProduct($ID)
        ->select('commodityPrice as Price', 'commodityAmount as Amount', 'IsShelves as isShelves')
        ->get();
    }

    public function SelectTimelimit($ID){
        return lcSQL::FindProduct($ID)
        ->select('limitedPrice as Price', 'limitedAmount as Amount', 'offTime as Offtime' ,'isShelves as isShelves')
        ->get();
    }

    public function SelectGroupbuy($ID){
        return gcSQL::FindProduct($ID)
        ->select('groupbuyPrice as Price', 'isShelves as isShelves')
        ->get();
    }

    public function SelectMemberMemberIntegral($ID){
        return mbSQL::MemberIDCheck($ID)
        ->select('memberIntegral')
        ->get();
    }

    public function UpdateMemberIntegral($ID,$overIntegral){
        return mbSQL::MemberIDCheck($ID)
        ->update(['memberIntegral'=>$overIntegral]);
    }

    public function SelectMemberMemberUseIntegral($ID){
        return mbSQL::MemberIDCheck($ID)
        ->select('memberUseIntegral')
        ->get();
    }

    public function UpdateMemberUseIntegral($ID,$UseIntegral){
        return mbSQL::MemberIDCheck($ID)
        ->update(['memberUseIntegral'=>$UseIntegral]);
    }

    public function SelectPromotion(){
        return ptSQL::get();
    }

    public function InsertOrder(
        $memberID,
        $randomNum,
        $is_ordered,
        $totalPrice,
        $orderState,
        $recipient,
        $deliveryAdd,
        $checkoutMethod,
        $freight,
        $useIntegral,
        $moneyTransferFN,
        $orderClass
    ){
        $inset_order = new odSQL();
        $inset_order->memberID=$memberID;
        $inset_order->randomNum=$randomNum;
        $inset_order->is_ordered=$is_ordered;
        $inset_order->totalPrice=$totalPrice;
        $inset_order->orderState=$orderState;
        $inset_order->recipient=$recipient;
        $inset_order->deliveryAdd=$deliveryAdd;
        $inset_order->checkoutMethod=$checkoutMethod;
        $inset_order->freight=$freight;
        $inset_order->useIntegral=$useIntegral;
        $inset_order->moneyTransferFN=$moneyTransferFN;
        $inset_order->orderClass=$orderClass;
        $inset_order->save();
        return $result = 1;
      
    }

    public function SelectOrderID(
        $memberID,
        $random_number,
        $totalPrice,
        $orderState,
        $recipient,
        $deliveryAdd,
        $checkoutMethod,
        $freight,
        $useIntegral,
        $moneyTransferFN,
        $orderClass
    ){
        try{
            $result = odSQL::where('memberID',$memberID)
            ->where('randomNum',$random_number)
            ->where('totalPrice',$totalPrice)
            ->where('orderState',$orderState)
            ->where('recipient',$recipient)
            ->where('deliveryAdd',$deliveryAdd)
            ->where('checkoutMethod',$checkoutMethod)
            ->where('freight',$freight)
            ->where('useIntegral',$useIntegral)
            ->where('moneyTransferFN',$moneyTransferFN)
            ->where('orderClass',$orderClass)
            ->get();
        }catch(Exception $e){
            $result = "";
        }finally{
            return $result;
        }
    }

    public function InsertOrder_detailed(
        $orderID,
        $commodityID,
        $originalID,
        $commodityArea,
        $commodityAmount,
        $commodityBuyPrice
    ){
        try{
            $inset_order_detailed = new oddSQL();  
            $inset_order_detailed->orderID = $orderID;
            $inset_order_detailed->commodityID = $commodityID;
            $inset_order_detailed->originalID = $originalID;
            $inset_order_detailed->commodityArea = $commodityArea;
            $inset_order_detailed->commodityAmount = $commodityAmount;
            $inset_order_detailed->buyPrice = $commodityBuyPrice;
            $inset_order_detailed->save();
            $result = 1;
        }catch(Exception $e){
            $result = 0;
        }finally{
            return $result;
        }
    }

    public function updateCommodityAmount(
        $Area,
        $ID,
        $final_Amount
    ){
        if($Area == 'commodity'){
            cmSQL::FindProduct($ID)
            ->update(['commodityAmount'=>$final_Amount]);
        }elseif($Area =='timelimit'){
            lcSQL::FindProduct($ID)
            ->update(['limitedAmount'=>$final_Amount]);
        }
    }

}
