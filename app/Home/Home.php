<?php

namespace App\Home;

use App\Home\ProductInformation as PI;


class Home
{
    private $pi;

    public function __construct(PI $pi){
        $this->pi = $pi;
    }
    //

    // public function Home22(PI $this->pi){
    public function Home(){
    	$ProductNumber = $this->pi->GetALL();//三個陣列代表三個商品種類的數量
    	$OrderByType = '';
    	$GeneralInformation = $this->pi->GetGeneral(
    		$OrderByType,
    		0,
    		$ProductNumber["commodity"]
    	);
    	$GroupBuyInformation = $this->pi->GetGroupBuy(
    		$OrderByType,
    		0,
    		$ProductNumber["groupbuy"]
    	);
    	$TimeLimitInformation = $this->pi->GetTimeLimit(
    		$OrderByType,
    		0,
    		$ProductNumber["timelimit"]
    	);
		
    	$AllInformation = array(
    		"commodity"=>$GeneralInformation,
    		"groupbuy"=>$GroupBuyInformation,
    		"timelimit"=>$TimeLimitInformation,
			
    	);
    	return $AllInformation;
    }

	public function LatestNews(){
		$Promotion = $this->pi->GetLatestNews();
		$result = $Promotion[0]['latest_news'];
		return $result;
	}

}
