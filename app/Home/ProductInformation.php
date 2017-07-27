<?php

namespace App\Home;

use App\Model\commodity as cmSQL;
use App\Model\groupbuy_commodity as gcSQL;
use App\Model\limited_commodity as lcSQL;
use App\Model\promotion as ptSQL;


class ProductInformation
{
    //
    public function GetAll(){
    	return array(
    		"commodity" => cmSQL::Product()->count(),
    		"groupbuy" => gcSQL::Product()->count(),
    		"timelimit" => lcSQL::Product()->count()
    	);
    }

    public function GetGeneral(
    	$Type = null,
    	$StartNumber = null,
    	$EndNumber = null
    ){
        if(null ==  $EndNumber)
            return null;
    	return cmSQL::Product()
        ->select('commodityName', 'commodityPrice', 'commodityPhotoA', 'commodityID as ID')
        ->get();
    }

    public function GetGroupBuy(
    	$Type = null,
    	$StartNumber = null,
    	$EndNumber = null
    ){
    	if(null ==  $EndNumber)
    	 	return null;
    	// $result = gcSQL::with(['commodity' => function ($query){
    	// 	return $query->select('commodityID', 'commodityName', 'commodityPhotoA');
    	// }])->Product()->select('groupbuyPrice', 'commodityID')->get()->toArray();
		$result = gcSQL::with('commodity')->Product()->get()->toArray();
    	return  array_map(function($element) {
    		$temp = array_dot($element);
    		return array(
    			'commodityName' => $temp['commodity.commodityName'],
    			'commodityPrice' => $temp['groupbuyPrice'],
    			'commodityPhotoA' => $temp['commodity.commodityPhotoA'],
    			'ID' => $temp['groupbuyID']
    		);
    	},$result);
    }

    public function GetTimeLimit(
    	$Type = null,
    	$StartNumber = null,
    	$EndNumber = null
    ){
    	if(null ==  $EndNumber)
    	 	return null;
		$result = lcSQL::with('commodity')->Product()->DuringShelves()->get()->toArray();
		//return $result;
    	return  array_map(function($element) {
    		$temp = array_dot($element);
    		return array(
    			'commodityName' => $temp['commodity.commodityName'],
    			'commodityPrice' => $temp['limitedPrice'],
    			'commodityPhotoA' => $temp['commodity.commodityPhotoA'],
    			'ID' => $temp['limitedID']

    		);
    	},$result);
    }

	public function GetLatestNews(){
		$result = ptSQL::get();
		return $result;
	}

}
