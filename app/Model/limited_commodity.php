<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

use App\Model\commodity as cmSQL;

use DateTime;

class limited_commodity extends Model
{
    //
    protected $table = 'limited_commodity';
	protected $guarded = [];
    public $timestamps = true;

    public function scopeProduct($query){
        return $query
        ->where('limited_commodity.isShelves',true)
        ;
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
        $limited_ID
    ){
        return $query
        ->where('limitedID',$limited_ID);
    }

    public function scopeDuringShelves($query){
        $Nowtime = new DateTime();
        return $query->where('offtime','>=',$Nowtime->format('Y-m-d'));
    }
    

    public function commodity(){
        return $this->
        belongsTo(cmSQL::class, 'commodityID', 'commodityID');
    }

    public function MemberCommodity(){
        return $this->
        hasOne(mcSQL::class, 'limitedID', 'commodityID');
    }



}
