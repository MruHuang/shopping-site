<?php

namespace App\SingleCommodity;

use App\SingleCommodity\ProductInformation as PI;
use App\Promotion\Promotion as PT;

class SingleCommodity
{
    private $pi;
    private $pt;
    public function __construct(PI $pi, PT $pt){
        $this->pi = $pi;
        $this->pt = $pt;
    }
    //

    // public function Home22(PI $this->pi){
    public function Commodity(
        $type = null,
        $ID = null
    ){
    	$OrderByType = $type;
        $AllInformation = null;
        if($OrderByType != null){
            if($OrderByType == 'commodity'){
            	$AllInformation = $this->pi->GetGeneral($ID);
            }else if($OrderByType == 'groupbuy'){
        	    $AllInformation = $this->pi->GetGroupBuy($ID
        	    );
            }else if($OrderByType == 'timelimit'){
            	$AllInformation = $this->pi->GetTimeLimit($ID);
            }
            $AllInformation[0]['freight']=$this->pt->GetFreight()[0]['freight'];
            $AllInformation[0]['Freefreight']=$this->pt->GetFreefreight()[0]['freeFreight'];
            return $AllInformation;
        }else{
            return null;
        }
    	
    }

}
