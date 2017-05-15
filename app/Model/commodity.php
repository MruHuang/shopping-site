<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

use App\Model\groupbuy_commodity as gcSQL;
use App\Model\limited_commodity as lcSQL;
use App\Model\Species as spSQL;
use App\Model\Member_commodity as mcSQL;
class commodity extends Model
{
    //
    protected $table = 'commodity';
	protected $guarded = [];
    public $timestamps = true;



    public function scopeCountNumber(
        $query,
        $type
    ){
    	return $query
    	->where('speciseID', $type);
    }
    public function scopeProduct($query){
        return $query
        ->where('commodity.IsShelves',1)
        ;
    }
    public function scopeFindProduct(
        $query,
        $commodity_ID
    ){
        return $query
        ->where('commodityID',$commodity_ID);
    }

    public function scopeSpeciesID(
        $query,
        $SpeciesID
    ){
        return $query
        ->where('speciseID',$SpeciesID);
    }

    public function scopeGetrange(
        $query,
        $StartNumber,
        $EndNumber,
        $species
    ){
        return $query
        ->orderBy($species)
        ->offset($StartNumber - 1)
        ->limit($EndNumber - $StartNumber + 1) 
        ;
    }

    public function scopeJoinGroupbuy($query){
        return $query
        ->join('groupbuy_commodity', function ($join) {
            $join->on('groupbuy_commodity.commodityID', 'commodity.commodityID')
             ->where('groupbuy_commodity.isShelves',1);
        });
    }

    public function scopeJoinLimited($query){
        return $query
        ->join('limited_commodity', function ($join) {
            $join->on('limited_commodity.commodityID', 'commodity.commodityID')
             ->where('limited_commodity.isShelves',1);
        });
    }

    public function scopeLikeSelect(
        $query,
        $search_text
    ){
        return $query
        ->where('commodity.commodityName', 'like',$search_text )
        ->orwhere('commodity.commodityIntroduction', 'like',$search_text )
        ->orwhere('commodity.commodityPrice', 'like',$search_text )
        ->orwhere('commodity.commodityPrice', 'like',$search_text );
    }

    public function GroupBuy(){
        return $this->
        hasOne(gcSQL::class, 'commodityID', 'commodityID');
    }

    public function Species(){
        return $this->
        belongsTo(spSQL::class, 'speciseID', 'speciseID');
    }

    public function Limited(){
        return $this->
        hasOne(lcSQL::class, 'commodityID', 'commodityID');
    }

    public function MemberCommodity(){
        return $this->
        hasOne(mcSQL::class, 'commodityID', 'commodityID');
    }



}
