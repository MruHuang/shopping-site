<?php

namespace App\Order;

use App\Model\merchandise_order as odSQL;
use App\Model\order_detailed as oddSQL;
use App\Model\Member as mbSQL;
use App\Model\commodity as cmSQL;
use App\Model\limited_commodity as lcSQL;
use App\Model\promotion as ptSQL;
use App\Model\Manager as mgSQL;

class ProductInformation
{
    public function GetSingle($order){
        $result = odSQL::
        GetOrderID($order)
        ->get();
        return $result;
    }

    public function GetUnpaid($memberID){
        $result = odSQL::
        CheckID($memberID)
        ->GetUnpaid()
        ->CheckoutMethod()
        ->get();
        return $result;
    }

    public function GetCheck($memberID){
        $result = odSQL::
        CheckID($memberID)
        ->GetCheck()
        ->get();
        return $result;
    }

    public function GetReady($memberID){
		$result = odSQL::CheckID($memberID)
        ->GetReady()
        ->get();
        return $result;
    }

    public function GetDelivery($memberID){
    	$result = odSQL::CheckID($memberID)
        ->GetDelivery()
        ->get();
        return $result;
    }

    public function GetCarryout($memberID){
        $result = odSQL::CheckID($memberID)
        ->GetCarryout()
        ->get();
        return $result;
    }

    public function GetOrderInformation($orderID){
        return $result = oddSQL::JoinCommodity()
        ->GetOrderID($orderID)
        ->get();
    }

    public function UpdateFiveNumber(
        $orderID,
        $fiveNumber
    ){
        return $result = odSQL::GetOrderID($orderID)
        ->update([
            'moneyTransferFN'=> $fiveNumber,
            'orderState'=>'Check'
        ]);
    }

    public function CancelOrder(
        $orderID
    ){
        return $result = odSQL::GetOrderID($orderID)
        ->update([
            'orderState'=>'Cancel'
        ]);
    }

    public function OrderDetailDel($orderID){
        $result = oddSQL::GetOrderID($orderID)->get();
        try{
            for($i =0;$i< count($result); $i++){
                $OrderDetailArray = oddSQL::GetID($result[$i]['ID'])->get();
                if($OrderDetailArray[0]['commodityArea']=='commodity'){
                    $commodityArray = cmSQL::FindProduct($OrderDetailArray[0]['commodityID'])
                    ->select('commodityAmount')->get();
                    $commodityAmount = $OrderDetailArray[0]['commodityAmount']+$commodityArray[0]['commodityAmount'];
                    cmSQL::FindProduct($OrderDetailArray[0]['commodityID'])->update(['commodityAmount'=>$commodityAmount]);
                }elseif($OrderDetailArray[0]['commodityArea']=='timelimit'){
                    $timelimitArray = lcSQL::FindProduct($OrderDetailArray[0]['commodityID'])
                    ->select('limitedAmount')->get();
                    $commodityAmount = $OrderDetailArray[0]['commodityAmount']+$timelimitArray[0]['limitedAmount'];
                    lcSQL::FindProduct($OrderDetailArray[0]['commodityID'])->update(['limitedAmount'=>$commodityAmount]);
                }
                oddSQL::OrderDetailID($result[$i]['ID']);
            }
            $result = '成功';
        }catch(\Exception $e){
            $result = '失敗';
            //$result = $e;
        }finally{
            return $result;
        }
    }

    // public function OrderDetailDel($orderID){
    //     $ID = 100;
    //     $OrderDetailArray = oddSQL::GetID($ID)->get();
        
    // }

    

    // public function OrderDel($orderID){
    //     $result = null;
    //     try{
    //         odSQL::GetOrderID($orderID)->delete();
    //         $result = '成功';
    //     }catch(\Exception $e){
    //         $result = '失敗';
    //         //$result = $e;
    //     }finally{
    //         return $result;
    //     }
    // }

    public function AddCancel($memberID){
        $result = mbSQL::MemberIDCheck($memberID)->get();
        $memberCancel = $result[0]['memberCancel']+1;
        mbSQL::MemberIDCheck($memberID)
        ->update(['memberCancel'=>$memberCancel]);
        return true;
    }

    public function AddIntegral(
        $memberID,
        $orderID
    ){
        $orderData = odSQL::GetOrderID($orderID)->get();
        $integral = $orderData[0]['useIntegral'];
        $memberData = mbSQL::MemberIDCheck($memberID)->get();
        $memberIntegral = $memberData[0]['memberIntegral'];
        $memberIntegral = $memberIntegral+ $integral;
        mbSQL::MemberIDCheck($memberID)
        ->update(['memberIntegral'=>$memberIntegral]);
        return true;
    }

    public function GetPromotionData(){
        $result = ptSQL::get();
        return $result;
    }

    public function GetMemberData($ID){
        $result = mbSQL::MemberIDCheck($ID)->get();
        return $result;
    }

    public function GetmanagerEmail(){
        $M_Email = mgSQL::GetManagerEmail()
        ->get();
        return $M_Email;
    }

}