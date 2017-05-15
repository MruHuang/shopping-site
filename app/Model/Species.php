<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\commodity as cmSQL;

class Species extends Model
{
    //
    protected $table = 'species';
	protected $guarded = [];
    public $timestamps = true;


 	public function scopeTypeCheck(
        $query,
        $type
    ){
        return $query
        ->where('speciseID', $type);
    }


    public function commodity(){
        return $this->
        hasOne(cmSQL::class, 'speciseID', 'speciseID');
    }
}
