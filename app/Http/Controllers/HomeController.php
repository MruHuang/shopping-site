<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Home\Home as HM;
use View;

class HomeController extends Controller
{
    public function Home(HM $hm){
    	$AllInformation = $hm->Home();
		$LatestNews= $hm->LatestNews();
		$LatestNews = str_replace(chr(13).chr(10), "<br />",$LatestNews);
    	$AllInformation = array_filter($AllInformation);
    	return view::make('Home',['AllInformation'=>$AllInformation,'LatestNews'=>$LatestNews]);
	}
}