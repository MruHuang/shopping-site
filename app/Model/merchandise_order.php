<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\order_detailed as oddSQL;

class merchandise_order extends Model
{
    //
    protected $table = 'merchandise_order';
	protected $guarded = [];
    public $timestamps = true;

    public function scopeCheckID(
    	$query,
    	$member_id
	){
    	$query->where('memberID', $member_id);
    }

    public function scopeCheckoutMethod($query){
    	$query->where('checkoutMethod','ATM');
    }

    public function scopeNotGroupBy($query){
    	$query->where('orderClass','<>','groupbuy');
    }

    public function scopeGroupBy($query){
    	$query->where('orderClass','groupbuy');
    }

    public function scopeCommodity($query){
    	$query->where('orderClass','commodity');
    }

     public function scopeTimelimit($query){
    	$query->where('orderClass','timelimit');
    }

    public function scopeGetUnpaid($query){
    	$query->where('orderState','Unpaid');
    }

    public function scopeGetCheck($query){
        $query->where('orderState','Check');
    }

    public function scopeGetReady($query){
    	$query->where('orderState','Ready');
    }

    public function scopeGetDelivery($query){
    	$query->where('orderState','Delivery');
    }

    public function scopeGetCarryout($query){
    	$query->where('orderState','Carryout');
    }

    public function scopeGetOrderID(
    	$query,
    	$orderID
	){
    	$query->where('orderID',$orderID);
    }

    public function order_detailed(){
    	return $this->
    	hasOne(oddSQL::class, 'orderID','orderID');
    }
}
