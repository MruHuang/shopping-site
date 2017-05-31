<?php

namespace App\Login;

use App\Model\Member as memberSQL;
use Session;
use View;
use Hash;
class Login
{
    //
   //  public function LoginCheckDataBase(
   //      $member_account = null,
   //      $member_password = null
   //  ){

   //  	$result = memberSQL::LoginCheck(
			// $member_account,
			// $member_password
   //  	)
   //      ->count();
   //  	if ($result == 1){
   //          Session::forget('user');
   //          $result_id = memberSQL::LoginCheck(
   //              $member_account,
   //              $member_password
   //          )
   //          ->get();
   //          Session::put('user.login', 'login');
   //          Session::put('user.member_id', $result_id[0]['memberID']);
   //          Session::put('user.memberName', $result_id[0]['memberName']);
   //          Session::put('user.memberEmail', $result_id[0]['memberEmail']);
   //          Session::put('user.memberBirthday', $result_id[0]['memberBirthday']);
   //          Session::put('user.memberAdd', $result_id[0]['memberAdd']);
   //          Session::put('user.memberLineid', $result_id[0]['memberLineid']);
   //          Session::put('user.memberPhone', $result_id[0]['memberPhone']);
   //          Session::put('user.memberIntegral', $result_id[0]['memberIntegral']);
   //          Session::put('user.recommender', $result_id[0]['recommender']);
   //          Session::put('user.member_account', $member_account);
   //          Session::put('user.member_password', $member_password);
   //  		return true;
   //  	}else{
   //  		return false;
   //  	}
   //  }

    public function LoginCheckDataBase(
        $member_account = null,
        $member_password = null
    ){

        $result = memberSQL::MemberCheck($member_account)->get();
        if(count($result)!=0){
            $result = Hash::check($member_password,$result[0]['memberPassword']);
            if($result){
                Session::forget('user');
                $result_id = memberSQL::MemberCheck($member_account)->get();
                Session::put('user.login', 'login');
                Session::put('user.member_id', $result_id[0]['memberID']);
                Session::put('user.memberName', $result_id[0]['memberName']);
                Session::put('user.memberEmail', $result_id[0]['memberEmail']);
                Session::put('user.memberBirthday', $result_id[0]['memberBirthday']);
                Session::put('user.memberAdd', $result_id[0]['memberAdd']);
                Session::put('user.memberLineid', $result_id[0]['memberLineid']);
                Session::put('user.memberPhone', $result_id[0]['memberPhone']);
                Session::put('user.memberIntegral', $result_id[0]['memberIntegral']);
                Session::put('user.recommender', $result_id[0]['recommender']);
                Session::put('user.member_account', $member_account);
                Session::put('user.member_password', $member_password);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    // public function IsRegisteredCheck(
    //     $member_account = null,
    //     $member_password = null
    // ){
    //     $result = memberSQL::LoginCheck(
    //         $member_account,
    //         $member_password
    //     )
    //     ->IsRegisteredCheck()
    //     ->count();
    //     if ($result == 1)
    //         return true;
    //     else
    //         return false;
    // }

    public function IsRegisteredCheck(
        $member_account = null,
        $member_password = null
    ){
        $result = memberSQL::MemberCheck($member_account)->get();
        if(count($result)!=0){
            $result = Hash::check($member_password,$result[0]['memberPassword']);
            if($result){
                $result = memberSQL::MemberCheck($member_account)
                ->IsRegisteredCheck()
                ->count();
                if ($result)
                    return true;
                else
                    return false;
            }else{
                return false;
            }
        }else{
            return false;
        }
        
    }

    // public function IsBlacklistCheck(
    //     $member_account = null,
    //     $member_password = null
    // ){
    //     $result = memberSQL::LoginCheck(
    //         $member_account,
    //         $member_password
    //     )
    //     ->IsBlackCheck()
    //     ->count();
    //     if ($result == 1)
    //         return true;
    //     else
    //         return false;
    // }

    public function IsBlacklistCheck(
        $member_account = null,
        $member_password = null
    ){
        $result = memberSQL::MemberCheck($member_account)->get();
        if(count($result)!=0){
            $result = Hash::check($member_password,$result[0]['memberPassword']);
            if($result){
                $result = memberSQL::MemberCheck($member_account)
                ->IsBlackCheck()
                ->count();
                if ($result)
                    return true;
                else
                    return false;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function LoginSessionID(){
        $result = Session::get('user.member_id', null);
        return $result;
    }

    public function LoginIntegral(){
        $result = Session::get('user.memberIntegral', null);
        return $result;
    }

    public function GetUserPassword(){
        $result = Session::get('user.member_password', null);
        return $result;
    }

    public function GetUserAccount(){
        $result = Session::get('user.member_account', null);
        return $result;
    }

    public function GetSessionData(){
        $result = array(
            'Name'=>Session::get('user.memberName', null),
            'Account'=>Session::get('user.member_account', null),
            'Phone'=>Session::get('user.memberPhone', null),
            'Add'=>Session::get('user.memberAdd', null),
            'Email'=>Session::get('user.memberEmail', null),
            'Birthday'=>Session::get('user.memberBirthday', null),
            'Lineid'=>Session::get('user.memberLineid', null)
        );
        return $result;
    }

    public function Logout(){
        Session::forget('user.login');
        Session::forget('user.member_id');
        Session::forget('user.member_account');
        Session::forget('user.member_password');
    }
    public function UpdateSessionData(){
        $member_password = Session::get('user.member_password', null);
        $member_account = Session::get('user.member_account', null);
        $this->LoginCheckDataBase(
            $member_account,
            $member_password
        );
    }

    public function LoginSessionCheck(){
        $result = Session::get('user.login', null);
        if($result == 'login')
            return true;
        else
            return false;
    }

}
