<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    //
    protected $table = 'manager';
	protected $guarded = [];
    public $timestamps = true;

    public function scopeGetManagerEmail($query){
    	return $query->select('managerEmail');
    }
}
