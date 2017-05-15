<?php

namespace App\Promotion;

use App\Model\promotion as pSQL;

class PromotionSQL
{
    public function GetFreeFreight(){
        $result = pSQL::select('freeFreight')
        ->get();
        return $result;
    }

    public function GetFreight(){
		$result = pSQL::select('freight')
        ->get();
        return $result;
    }

    public function GetIntergralPropotrion(){
    	$result = pSQL::select('integralProportion')
        ->get();
        return $result;
    }
}