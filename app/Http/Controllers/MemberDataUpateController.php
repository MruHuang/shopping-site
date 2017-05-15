<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests\MemberDataUpateRequest as MDU;

use View;
use Validator;
use App\Model\Member as memberSQL;
use App\Login\Login as LG;

class MemberDataUpateController extends Controller
{
    //
    private $lg;

    public function __construct(LG $lg){
        $this->lg = $lg;
    }

    public function MemberDataUpate(MDU $Request){
    	//	
	    	if(!$this->lg->LoginSessionCheck()){
	            return View::make('Login',[
	                'message_text'=>"請重新登入"
	            ]);
	        }
    		$message_text = "成功";
    		$member_account = $Request->input('member_account');
    		if($Request->input('member_password')==null){
    			$member_password = $this->lg->GetUserPassword();
    			$new_member_password = null;
    			$new_member_password_again = null;
    		}else{
    			$member_password = $Request->input('member_password');
				$new_member_password = $Request->input('new_member_password');
				$new_member_password_again = $Request->input('new_member_password_again');
    		}
	    	$member_phone = $Request->input('member_phone');
	    	$member_add = $Request->input('member_add');
	    	$member_Email = $Request->input('member_Email');
	    	$member_birthday = $Request->input('member_birthday');
	    	$member_lineid = $Request->input('member_lineid');

	    	$member =  memberSQL::LoginCheck(
	    		$member_account,
				$member_password
	    	)->first();
	    	
	    	if($new_member_password != null && $new_member_password == $new_member_password_again){
				$member->memberPassword = $new_member_password; 
	    	}
	    	else if($new_member_password != $new_member_password_again){
	    		$message_text = "密碼輸入錯誤";
	    		$user_Data = $this->lg->GetSessionData();
	    		return View::make('MemberCenter',['message_text'=>$message_text,'user_Data'=>$user_Data]);
	    	}
			$member->memberPhone = $member_phone;
			$member->memberAdd = $member_add;
			$member->memberEmail = $member_Email;
			$member->memberBirthday = $member_birthday;
	    	$member->memberLineid = $member_lineid;

	    	$member->save();
	    	$this->lg->LoginCheckDataBase(
	    		$member_account,
				$member_password
			);
	    	$user_Data = $this->lg->GetSessionData();
	    	return View::make('MemberCenter',['message_text'=>$message_text,'user_Data'=>$user_Data]);
    }

    public function MemberCenter(){
    	if(!$this->lg->LoginSessionCheck()){
            return View::make('Login',[
                'message_text'=>"請重新登入"
            ]);
        }
        $this->lg->UpdateSessionData();
        $user_Data = $this->lg->GetSessionData();
    	// $user_Data = $this->lg->GetSessionData();
    	//return $user_Data;
    	return View::make('MemberCenter',['message_text'=>null,'user_Data'=>$user_Data]);
    }
}
