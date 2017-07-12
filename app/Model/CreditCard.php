<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    //
    protected $table = 'CreditCard';
	protected $guarded = [];
    public $timestamps = true;

    public function scopeCheckONO(
    	$query,
    	$ONO
	){
    	$query->where('ONO', $ONO);
    }

    public function scopeCheckTransactionComplete(
    	$query
	){
    	$query->where('RC', '00');
    }
}
