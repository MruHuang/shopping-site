<?php

namespace App\MemberCommodity;

use App\Model\commodity as cmSQL;
use App\Model\groupbuy_commodity as gcSQL;
use App\Model\limited_commodity as lcSQL;
use App\Model\Member as mbSQL;
use App\Model\Member_commodity as mcSQL;
use App\Model\merchandise_order as odSQL;
use App\Model\order_detailed as oddSQL;
use App\Model\promotion as ptSQL;
use DB;

class MemberCommodityInformation
{
    public function GetMemberCommodity(
        $member_ID,
        $speciestype
    ){
    	return array(
            mcSQL::MemberID(
                $member_ID,
                $speciestype
            )
            ->JoinTimelimit()
            ->join('commodity', 'limited_commodity.commodityID', 'commodity.commodityID')
            ->get(),
            mcSQL::MemberID(
                $member_ID,
                $speciestype
            )
            ->JoinCommodity()
            ->get(),
            mcSQL::MemberID(
                $member_ID,
                $speciestype
            )
            ->JoinGroupbuy()
            ->join('commodity', 'groupbuy_commodity.commodityID', 'commodity.commodityID')
            ->get()
        );
    }

    public function GetCommodityCount(
        $ID,
        $speciestype
    ){
        $result = mcSQL::ClassCheck($speciestype)
        ->CommodityID($ID)
        ->get();
        $count_number = 0;
        foreach ($result as $key => $value) {
            $count_number += $value['commodityAmount'];
        }
        return $count_number;
    }

    public function GetGroupbuyCount(
        $ID,
        $speciestype
    ){
        $result = odSQL::GroupBy()
        ->join('order_detailed',function($query) use ($ID, $speciestype){
            $query
            ->on('merchandise_order.orderID','order_detailed.orderID')
            ->where('merchandise_order.orderState','Unpaid')
            ->where('order_detailed.commodityArea', $speciestype)
            ->where('order_detailed.commodityID',$ID);
        })
        ->get();
        $count_number = 0;
        foreach ($result as $key => $value) {
            $count_number += $value['commodityAmount'];
        }
        return $count_number;
    }

    public function GetGroupbuyCommodity($ID){
        $result = gcSQL::FindProduct($ID)->get();
        return $result;
    }

    public function GetCommodity($ID){
        $result = cmSQL::FindProduct($ID)->get();
        return $result;
    }

    public function GetTimelimitCommodity($ID){
        $result = lcSQL::FindProduct($ID)->get();
        return $result;
    }

    public function Getpromotion(){
        $result = ptSQL::get();
        return $result;
    }

    public function UpdateMemberCommodity($ID,$Amount){
        mcSQL::GetAllData($ID)->update(['commodityAmount'=>$Amount]);
    }

    public function GetOrder($random_number){
        $result = odSQL::FindRandomNumber($random_number)->get();
        return $result;
    }

    public function GetOrderDetailed($orderID){
        $result = oddSQL::GetOrderID($orderID)
        ->join('commodity','commodity.commodityID','order_detailed.originalID')
        ->select(DB::raw("
            order_detailed.ID,
            order_detailed.originalID,
            commodity.commodityName,
            order_detailed.buyPrice,
            order_detailed.commodityArea,
            order_detailed.commodityAmount"))
        ->get();
        return $result;
    }

}
