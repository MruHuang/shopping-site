<?php

namespace App\Subpage;

use App\Subpage\ProductInformation as PI;

class Subpage
{
    private $pi;

    public function __construct(PI $pi){
        $this->pi = $pi;
    }
    //

    // public function Home22(PI $this->pi){
    public function Subpage(
        $area,
        $start,
        $end,
        $type=null,
        $order_type
    ){
    	$OrderByType = $area;
        $AllInformation = null;
        if($OrderByType != null){
            if($OrderByType == 'commodity'){
            	$AllInformation = $this->pi->GetGeneral(
            		$start,
                    $end,
                    $type,
                    $order_type
            	);
            }else if($OrderByType == 'groupbuy'){
        	    $AllInformation = $this->pi->GetGroupBuy(
            		$start,
                    $end,
                    $type,
                    $order_type
        	    );
            }else if($OrderByType == 'timelimit'){
            	$AllInformation = $this->pi->GetTimeLimit(
            		$start,
                    $end,
                    $type,
                    $order_type
            	);
            }
            return $AllInformation;
        }else{
            return null;
        }
    	
    }

    public function SpeciesInformation($area){
        if($area == 'commodity')
             $result = $this->pi->GetSpeciesInformation();
        else if($area == 'groupbuy')
             $result = $this->pi->GetGroupSpeciesInformation();
        else if($area == 'timelimit')
             $result = $this->pi->GetLimitSpeciesInformation();
        return $result;
        
    }

    public function CountInformation($area, $type){
        if($area == 'commodity')
            $result = $this->pi->GetGeneralCount($area, $type);
        else if($area == 'groupbuy')
             $result = $this->pi->GetGroupBuyCount($area, $type);
        else if($area == 'timelimit')
             $result = $this->pi->GetLimitCount($area, $type);
        return $result;
    }

}
