<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Member as memberSQL;
use App\Mail\MailSent as Email;
use View;
class ForgetPwdController extends Controller
{
    //
    public function ForgetPwdCheck(Request $Request, Email $mailer){
    	$member_account = $Request->input('member_account');
    	$member_Email = $Request->input('member_Email');
    	$result = memberSQL::ForgetPwdCheck(
			$member_account,
			$member_Email
    	)->count();
        $member = memberSQL::ForgetPwdCheck(
            $member_account,
            $member_Email
        )->first();
        //return $member;
    	if ($result == 1){
            $new_password=substr(md5(rand()),0,8);
            $member->memberPassword = bcrypt($new_password);
            $member->save();
            
    		$mailer->SentMailForgetPwd(
    			$new_password,
    			$member_account.'先生/小姐 新密碼',
    			$member_Email
    		);
    		$message_text = '已寄出臨時密碼至會員信箱';
    	}else{
    		$message_text = '密碼或是信箱不符合';
    	}
         return View::make('ForgetPwd',[
                'message_text'=>$message_text
        ]);
    }
}
