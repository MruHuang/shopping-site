<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Home\Home as HM;
use View;

class HomeController extends Controller
{
    public function Home(HM $hm){
    	$AllInformation = $hm->Home();
    	$AllInformation = array_filter($AllInformation);
    	//return $AllInformation;
    	return view::make('Home',['AllInformation'=>$AllInformation]);
	}
}
