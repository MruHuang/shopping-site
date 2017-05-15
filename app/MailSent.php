<?php

namespace App\Mail;

use Mail;

class MailSent 
{
    //
    public function SentMailForgetPwd(
    	$email_text,
    	$email_title,
    	$email_addresse
    ){
		Mail::send('email.ForgetPwd',['mail_text'=>$email_text],function ($message) use ($email_title, $email_addresse){
	    	$message->subject($email_title);
	    	$message->to($email_addresse);
	    });
    }


}
