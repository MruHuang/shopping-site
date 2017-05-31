<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\commodity as cmSQL;
use App\Model\Member as mbSQL;

class Member_commodity extends Model
{
    //
    protected $table = 'member_commodity';
	protected $guarded = [];
    public $timestamps = true;

    public function scopeJoinCommodity($query){
    	return $query
    	->join('commodity', function ($join) {
        	$join->on('commodity.commodityID', '=', 'member_commodity.commodityID')
            ->where('member_commodity.commodityClass',  'commodity'
         	)
         	;
        })
        ->select(
     		'member_commodity.ID as user_ID',
            'member_commodity.commodityClass as user_class',
            'member_commodity.commodityAmount as user_amount',
            'member_commodity.commodityArea as user_area',
            'member_commodity.isOrder as user_isOrder',
            'member_commodity.created_at as user_time',

            'commodity.commodityName as Name',
     		'commodity.commodityPhotoA as Photo',
     		'commodity.speciseID as speciseID',
     		'commodity.commodityIntroduction as Introduction',

     		'commodity.commodityID as ID',
     		'commodity.commodityAmount as amount',
     		'commodity.commodityPrice as price'
 		);
    }

    public function scopeJoinGroupbuy($query){
		return $query
    	->join('groupbuy_commodity', function ($join) {
        	$join->on('groupbuy_commodity.groupbuyID', '=', 'member_commodity.commodityID')
            ->where('member_commodity.commodityClass',  'groupbuy'
         	)
         	
         	;
        })
        ->select(
        	'member_commodity.ID as user_ID',
            'member_commodity.commodityClass as user_class',
            'member_commodity.commodityAmount as user_amount',
            'member_commodity.commodityArea as user_area',
            'member_commodity.isOrder as user_isOrder',
            'member_commodity.created_at as user_time',

            'commodity.commodityName as Name',
     		'commodity.commodityPhotoA as Photo',
     		'commodity.speciseID as speciseID',
     		'commodity.commodityIntroduction as Introduction',

     		'groupbuy_commodity.groupbuyID as ID',
        	'groupbuy_commodity.groupbuyPrice as price',
        	'groupbuy_commodity.groupbuyPriceA as priceA',
        	'groupbuy_commodity.groupbuyAmountA as amountA',
        	'groupbuy_commodity.groupbuyPriceB as priceB',
        	'groupbuy_commodity.groupbuyAmountB as amountB',
        	'groupbuy_commodity.groupbuyPriceC as priceC',
        	'groupbuy_commodity.groupbuyAmountC as amountC',
        	'groupbuy_commodity.groupbuyPriceD as priceD',
        	'groupbuy_commodity.groupbuyAmountD as amountD'
    	)
    	;
    }

    public function scopeJoinTimelimit($query){
    	return $query
    	->join('limited_commodity', function ($join) {
        	$join->on('limited_commodity.limitedID', '=', 'member_commodity.commodityID')
            ->where('member_commodity.commodityClass',  'timelimit'
         	)
         	
         	;
        })
        ->select(
        	'member_commodity.ID as user_ID',
            'member_commodity.commodityClass as user_class',
            'member_commodity.commodityAmount as user_amount',
            'member_commodity.commodityArea as user_area',
            'member_commodity.isOrder as user_isOrder',
            'member_commodity.created_at as user_time',

            'commodity.commodityName as Name',
     		'commodity.commodityPhotoA as Photo',
     		'commodity.speciseID as speciseID',
     		'commodity.commodityIntroduction as Introduction',

     		
     		'limited_commodity.limitedID as ID',
     		'limited_commodity.limitedPrice as price',
     		'limited_commodity.limitedAmount as amount',
     		'limited_commodity.offTime as offTime'


        )
        ;
    }

    public function scopeMemberID(
    	$query,
    	$member_id,
    	$commodityArea
	){
    	return $query
    	->where('member_commodity.memberID', $member_id)
		->where('member_commodity.commodityArea', $commodityArea)
	
		;
    }

    public function scopeClassCheck(
    	$query,
    	$speciestype
	){
    	$query->where('member_commodity.commodityClass',$speciestype);
    }

    public function scopeCommodityID(
    	$query,
    	$id
	){
    	$query->where('member_commodity.commodityID',$id);
    }

    public function scopeGetAllData(
        $query,
        $ID
    ){
        return $query->where('member_commodity.ID',$ID);
    }

    public function commodity(){
        return $this->
        belongsTo(cmSQL::class, 'commodityID', 'commodityID');
    }

    public function member(){
    	return $this->
    	belongsTo(mbSQL::class, 'memberID', 'memberID');
    }
}
