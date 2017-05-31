<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\Member_commodity as mcSQL;

class Member extends Model
{
    //
    protected $table = 'member';
	protected $primaryKey = 'memberID';
	protected $guarded = [];
    public $timestamps = true;//Eloquent 來自動維護這兩個欄位created_at 和 updated_at

    public function scopeMemberCheck(
        $query,
        $member_account
    ){
        return $query
        ->where('memberAccount', $member_account);
    }

    public function scopeRecommenderCheck(
    	$query,
    	$recommender_name,
    	$recommender_phone
    ){
		return $query->select('memberID')->where('memberName', $recommender_name)
		->where('memberPhone', $recommender_phone);
    }

    public function scopeUserCheck(
    	$query,
    	$member_account,
    	$member_phone,
    	$member_lineid
    ){
		return $query->where('memberAccount', $member_account)
		->orwhere('memberPhone', $member_phone)
		->orwhere('memberLineid', $member_lineid);
    }

    public function scopeLoginCheck(
    	$query,
    	$member_account,
    	$member_password
    ){
		return $query->where('memberAccount', $member_account)
		->where('memberPassword', $member_password);
    }

    public function scopeIsBlackCheck($query){
        return $query
        ->where('isBlacklist',1);
    }

    public function scopeIsRegisteredCheck($query){
        return $query
        ->where('isRegistered',1);
    }

    public function scopeMemberIDCheck(
        $query,
        $ID
    ){
        return $query
        ->where('memberID',$ID);
    }

    public function scopeForgetPwdCheck(
    	$query,
    	$member_account,
    	$member_Email
    ){
		return $query->where('memberAccount', $member_account)
		->where('memberEmail', $member_Email);
    }

    public function Member_commodity(){
        return $this
        ->hasOne(mcSQL::class, 'memberID', 'memberID');
    }


}
