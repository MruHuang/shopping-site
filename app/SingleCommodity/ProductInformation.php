<?php

namespace App\SingleCommodity;

use App\Model\commodity as cmSQL;
use App\Model\groupbuy_commodity as gcSQL;
use App\Model\limited_commodity as lcSQL;


class ProductInformation
{
    public function GetGeneral($commodity_ID){
    	return cmSQL::Product()->FindProduct($commodity_ID)->select(
            'commodityID as ID',
            'commodityName',
            'commodityPrice',
            'originalPrice',
            'commodityPhotoA',
            'commodityAmount',
            'commodityIntroduction',
            'commodityPhotoB',
            'commodityPhotoC',
            'commodityPhotoD',
            'commodityPhotoE',
            'commodityVideo'
        )->get();
    }

    public function GetGroupBuy($groupbuy_ID){

    	// $result = gcSQL::with(['commodity' => function ($query){
    	// 	return $query->select('commodityID', 'commodityName', 'commodityPhotoA');
    	// }])->Product()->select('groupbuyPrice', 'commodityID')->get()->toArray();
		$result = gcSQL::with('commodity')->Product()->FindProduct($groupbuy_ID)->get()->toArray();
    	return  array_map(function($element) {
    		$temp = array_dot($element);
    		return array(

                'commodityName' => $temp['commodity.commodityName'],
                'originalPrice'=> $temp['commodity.originalPrice'],
                'commodityPhotoA' => $temp['commodity.commodityPhotoA'],
                'commodityIntroduction' => $temp['commodity.commodityIntroduction'],
                'commodityPhotoB' => $temp['commodity.commodityPhotoB'],
                'commodityPhotoC' => $temp['commodity.commodityPhotoC'],
                'commodityPhotoD' => $temp['commodity.commodityPhotoD'],
                'commodityPhotoE' => $temp['commodity.commodityPhotoE'],
                'commodityVideo' => $temp['commodity.commodityVideo'],

                'ID' => $temp['groupbuyID'],
                'GroupbuyPrice' => $temp['groupbuyPrice'],
                'GroupbuyAmountA' => $temp['groupbuyAmountA'],
                'GroupbuyPriceA' => $temp['groupbuyPriceA'],
                'GroupbuyAmountB' => $temp['groupbuyAmountB'],
                'GroupbuyPriceB' => $temp['groupbuyPriceB'],
                'GroupbuyAmountC' => $temp['groupbuyAmountC'],
                'GroupbuyPriceC' => $temp['groupbuyPriceC'],
                'GroupbuyAmountD' => $temp['groupbuyAmountD'],
                'GroupbuyPriceD' => $temp['groupbuyPriceD'],
                'OffTime' => $temp['offTime']

    		);
    	},$result);
    }

    public function GetTimeLimit($limited_ID){

		$result = lcSQL::with('commodity')->Product()->FindProduct($limited_ID)->get()->toArray();
		//return $result;
    	return  array_map(function($element) {
    		$temp = array_dot($element);
    		return array(
    			'commodityName' => $temp['commodity.commodityName'],
                'originalPrice'=> $temp['commodity.originalPrice'],
                'commodityPhotoA' => $temp['commodity.commodityPhotoA'],
                'commodityIntroduction' => $temp['commodity.commodityIntroduction'],
                'commodityPhotoB' => $temp['commodity.commodityPhotoB'],
                'commodityPhotoC' => $temp['commodity.commodityPhotoC'],
                'commodityPhotoD' => $temp['commodity.commodityPhotoD'],
                'commodityPhotoE' => $temp['commodity.commodityPhotoE'],
                'commodityVideo' => $temp['commodity.commodityVideo'],

                'ID' => $temp['limitedID'],
                'LimitedPrice' => $temp['limitedPrice'],
                'LimitedAmount' => $temp['limitedAmount'],
                'OffTime' => $temp['offTime']
    		);
    	},$result);
    }



}
