<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Home\Home as HM;
use View;
use App\Login\Login as LG;
use Log;

class HomeController extends Controller
{
	private $lg;

    public function __construct(LG $lg){
        $this->lg = $lg;
    }

    public function Home(HM $hm){
		if(!$this->lg->LoginSessionCheck()){
	            return View::make('Login',[
	            	'isRegistered'=>null,
	                'message_text'=>"請重新登入"
	            ]);
	    }
		else{
			Log::info('進入');
			$AllInformation = $hm->Home();
			$LatestNews= $hm->LatestNews();
			$LatestNews = str_replace(chr(13).chr(10), "<br />",$LatestNews);
			$AllInformation = array_filter($AllInformation);
			return view::make('Home',['AllInformation'=>$AllInformation,'LatestNews'=>$LatestNews]);
		}
    	
	}
}