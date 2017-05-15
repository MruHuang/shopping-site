<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;




use App\Http\Requests\RegisterRequest;
use View;
use Validator;
use \App\Model\Member as memberSQL;
class RegisterController extends Controller
{
    //
    public function RegisterPost(RegisterRequest $Request){
	    	$member_name = $Request->input('member_name');
	    	$member_account = $Request->input('member_account');
	    	$member_password = $Request->input('member_password');
	    	$member_password_again = $Request->input('member_password_again');
	    	$member_phone = $Request->input('member_phone');
	    	$member_add = $Request->input('member_add');
	    	$member_Email = $Request->input('member_Email');
	    	$member_birthday = $Request->input('member_birthday');
	    	$member_lineid = $Request->input('member_lineid');
	    	$recommender_name = $Request->input('recommender_name');
	    	$recommender_phone = $Request->input('recommender_phone');

            
	    	if($this->UserCheck(
					$member_account,
			    	$member_phone,
			    	$member_lineid
    		)){
				$recommender = $this->RecommenderCheck(
			    	$recommender_name,
			    	$recommender_phone
		    	);
				if($recommender){
					$message_text = $this->InsertMember(
						$Request,
						$recommender
					);
					$message_text = '會員資格審核中，審核成功後會以e-mail方式通知。';
                    return  redirect()->route("Login",['isRegistered'=>"true",'message_text'=>$message_text]);
					// return View::make('Login',[
					// 	'message_text'=>$message_text,
     //                    'isRegistered'=>"true"
					// ]);
				}else
				$message_text = '無推薦人';
    		}else{
				$message_text = '已有人使用過帳號、電話、LINE';
    		}
    	       
            return  redirect()->route("Register",['message_text'=>$message_text]);
			// return View::make('Register',[
			// 	'message_text'=>$message_text
			// ]);
    }

    /**
     * 功能說明
     * @param $recommender_name 推薦人名
     * @param $recommender_phone 推薦電話
     * @return boolean 是否存在推薦人
     */
    private function RecommenderCheck(
    	$recommender_name,
    	$recommender_phone
    ){
    	$result2 = memberSQL::recommenderCheck(
    		$recommender_name, 
    		$recommender_phone
    	)->first();
    	return $result2;
    }

    private function UserCheck(
		$member_account,
    	$member_phone,
    	$member_lineid
    ){
    	$result = memberSQL::userCheck(
    		$member_account,
	    	$member_phone,
	    	$member_lineid
    	)->count();
    	if ($result == 0)
	    	return true;
	    else
	    	return false;
    }

    public function InsertMember(
    	$Request,
    	$recommender_ID
    ){
    	
    	// $menberData = $Request->all();
    	// $memberData['memberIntegral'] = 0;
    	// $memberData['memberCancel'] = 0;
    	// $memberData['isRegistered'] = 0;
    	// $memberData['isBlacklist'] = 0;
    	// $memberData['recommender'] = $recommender_ID->memberID;
    	// $newMember = memberSQL::create($memberData);

    	// if ($newMember) {
    	// 	return '申請成功';
    	// }
    	// return '申請失敗';
        $member = new memberSQL;
        $member->memberAccount = $Request->member_account;
        $member->memberPassword = $Request->member_password;
        $member->memberName = $Request->member_name;
        $member->memberEmail = $Request->member_Email;
        $member->memberBirthday = $Request->member_birthday;
        $member->memberAdd = $Request->member_add;
        $member->memberLineid = $Request->member_lineid;
        $member->memberPhone = $Request->member_phone;
        $member->memberIntegral = 0;
        $member->memberCancel = 0;
        $member->recommender = $recommender_ID->memberID;
        $member->isRegistered = 0;
        $member->isBlacklist = 0;
        $member->save();
        return '會員資格審核中，審核成功後會以e-mail方式通知。';
    }

    
}
