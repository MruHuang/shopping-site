<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

use App\Model\commodity as cmSQL;
use App\Model\groupbuy_commodity as gcSQL;
use App\Model\limited_commodity as lcSQL;
use App\Model\Member_commodity as mcSQL;

class groupbuy_commodity extends Model
{
    //
    protected $table = 'groupbuy_commodity';
	protected $guarded = [];
    public $timestamps = true;

     public function scopeProduct($query){
        return $query
        ->where('groupbuy_commodity.isShelves',true);
    }

    public function scopeCountNumber(
        $query,
        $type
    ){
        return $query
        ->where('speciseID', $type);
    }

    public function scopeFindProduct(
        $query,
        $groupbuy_ID
    ){
        return $query
        ->where('groupbuyID',$groupbuy_ID);
    }

    public function commodity(){
        return $this->
        belongsTo(cmSQL::class, 'commodityID', 'commodityID');
    }

    public function GroupBuy(){
        return $this->
        belongsTo(gcSQL::class, 'commodityID', 'commodityID');
    }

    public function Limited(){
        return $this->
        belongsTo(lcSQL::class, 'commodityID', 'commodityID');
    }

    public function MemberCommodity(){
        return $this->
        hasOne(mcSQL::class, 'groupbuyID', 'commodityID');
    }

}
