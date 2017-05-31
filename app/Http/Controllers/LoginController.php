<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Member as memberSQL;
use App\Login\Login as Login;
use View;

class LoginController extends Controller
{
    //
    public function LoginCheck(Request $Request, Login $LoginFunction){
        //return $Request->all();
    	$member_account = $Request->input('member_account');
    	$member_password = $Request->input('member_password');
        $message_text ="帳號或是密碼錯誤，請重新輸入";
        //return $LoginFunction->LoginCheckDataBase($member_account,$member_password);
        if(
            $LoginFunction->LoginCheckDataBase(
                $member_account,
                $member_password
            ) == true
        ){
            if(
                $LoginFunction->IsBlacklistCheck(
                    $member_account,
                    $member_password
                ) == true
            )
            {
                $message_text="此帳號無法登入，請聯絡管理員。";
            }
            else if(
                $LoginFunction->IsRegisteredCheck(
                    $member_account,
                    $member_password
                ) == true
            ){
                return  redirect()->route('HomeGet');
            }
            else
            $message_text = "帳號權限尚未開通";
        }
        
        return View::make('Login',[
                'isRegistered'=>1,
				'message_text'=>$message_text
		]);
    }

    public function LogOut(Login $LoginFunction){
        $LoginFunction->Logout();
        return View::make('Login',[
                'isRegistered'=>1,
                'message_text'=>null
        ]);
    }
}
