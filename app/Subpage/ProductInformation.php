<?php

namespace App\Subpage;

use App\Model\commodity as cmSQL;
use App\Model\groupbuy_commodity as gcSQL;
use App\Model\limited_commodity as lcSQL;
use App\Model\Species as spSQL;
use DB;

class ProductInformation
{
    public function GetGeneral(
        $start,
        $end,
        $type,
        $order_type
    ){
        if($type=='All'){
         $result = cmSQL::Product()
            ->Getrange(
                $start,
                $end,
                $order_type
            )
            ->select(
                'commodityName',
                'commodityPrice',
                'commodityPhotoA',
                'commodityID as ID'
            )
            ->get();
        }else{
            $result = cmSQL::SpeciesID($type)
            ->Product()
            ->Getrange(
                $start,
                $end,
                $order_type
            )
            ->select(
                'commodityName',
                'commodityPrice',
                'commodityPhotoA',
                'commodityID as ID'
            )
            ->get();
        }
               //->toArray();
    return $result;
    }

    public function GetGroupBuy(
        $start,
        $end,
        $type,
        $order_type
    ){
        if($type=='All'){
            $result = cmSQL::join('groupbuy_commodity', 'groupbuy_commodity.commodityID','=', 'commodity.commodityID')
            ->orderBy('groupbuy_commodity.'.$order_type)
            ->offset($start - 1)
            ->limit($end - $start + 1)
            ->where('groupbuy_commodity.isShelves',1)
            ->select(
                'commodity.commodityName',
                'groupbuy_commodity.groupbuyPrice as commodityPrice',
                'commodity.commodityPhotoA',
                'groupbuy_commodity.groupbuyID as ID'
            )->get()->toArray();
        }else{
            $result = cmSQL::join('groupbuy_commodity', 'groupbuy_commodity.commodityID','=', 'commodity.commodityID')
            ->orderBy('groupbuy_commodity.'.$order_type)
            ->offset($start - 1)
            ->limit($end - $start + 1)
            ->SpeciesID($type)
            ->where('groupbuy_commodity.isShelves',1)
            ->select(
                'commodity.commodityName',
                'groupbuy_commodity.groupbuyPrice as commodityPrice',
                'commodity.commodityPhotoA',
                'groupbuy_commodity.groupbuyID as ID'
            )->get()->toArray();
        }
		
       return $result;
    }

    public function GetTimeLimit(
        $start,
        $end,
        $type,
        $order_type
    ){
    	if($type=='All'){
            $result = cmSQL::join('limited_commodity', 'limited_commodity.commodityID','=', 'commodity.commodityID')
            ->orderBy('limited_commodity.'.$order_type)
            ->offset($start - 1)
            ->limit($end - $start + 1)
            ->where('limited_commodity.isShelves',1)
            ->select(
                'commodity.commodityName',
                'limited_commodity.limitedPrice as commodityPrice',
                'commodity.commodityPhotoA',
                'limited_commodity.limitedID  as ID'
            )->get();
        }else{
            $result = cmSQL::join('limited_commodity', 'limited_commodity.commodityID','=', 'commodity.commodityID')
            ->orderBy('limited_commodity.'.$order_type)
            ->offset($start - 1)
            ->limit($end - $start + 1) 
            ->SpeciesID($type)
            ->where('limited_commodity.isShelves',1)
            ->select(
                'commodity.commodityName',
                'limited_commodity.limitedPrice as commodityPrice',
                'commodity.commodityPhotoA',
                'limited_commodity.limitedID  as ID'
            )->get();
        }
        
       return $result;
        // return  array_map(function($element) {
        //     $temp = array_dot($element);
        //     return array(
        //         'commodityName' => $temp['commodity.commodityName'],
        //         'commodityPrice' => $temp['limitedPrice'],
        //         'commodityPhotoA' => $temp['commodity.commodityPhotoA'],
        //         'ID' => $temp['limitedID']

        //     );
        // },$result);
    }

    public function GetSpeciesInformation(){
        return spSQL::join('commodity',function($join){
            $join->on('commodity.speciseID','species.speciseID')
            ->where('commodity.IsShelves',1);
        })
        ->select('species.speciseID','species.speciseName')
        ->distinct()
        ->get();
    }

    public function GetGroupSpeciesInformation(){
        return gcSQL::join('commodity','groupbuy_commodity.commodityID','commodity.commodityID')
        ->where('groupbuy_commodity.isShelves',1)
        ->join('species','species.speciseID','commodity.speciseID')
        ->select('species.speciseID','species.speciseName')
        ->distinct()
        ->get();
    }

    public function GetLimitSpeciesInformation(){
        return lcSQL::join('commodity','limited_commodity.commodityID','commodity.commodityID')
        ->where('limited_commodity.isShelves',1)
        ->join('species','species.speciseID','commodity.speciseID')
        ->select('species.speciseID','species.speciseName')
        ->distinct()
        ->get();
    }

    public function GetGeneralCount($area, $type){
        if($type=='All'){
            $result = cmSQL::
            Product()
            ->select('commodityID ')
            ->count();
        }else{
            $result = cmSQL::
            CountNumber($type)
            ->Product()
            ->select('commodityID ')
            ->count();
        }
    return $result;
    }

    public function GetGroupBuyCount($area, $type){
        if($type=='All'){
            $result = gcSQL::join('commodity' ,'groupbuy_commodity.commodityID','commodity.commodityID')
            ->count();
        }else{
            $result = gcSQL::join('commodity' ,'groupbuy_commodity.commodityID','commodity.commodityID')
            ->CountNumber($type)
            ->count();
        }
        return $result;
    }

    public function GetLimitCount($area, $type){
        if($type=='All'){
            $result = lcSQL::join('commodity' ,'limited_commodity.commodityID','commodity.commodityID')
            ->count();
        }else{
            $result = lcSQL::join('commodity' ,'limited_commodity.commodityID','commodity.commodityID')
            ->CountNumber($type)
            ->count();
        }
        return $result;
    }
}