<?php

namespace App\Promotion;

use App\Promotion\PromotionSQL as PTS;

class Promotion
{
    private $psql;

    public function __construct(PTS $psql){
        $this->psql = $psql;
    }
    //

    public function GetFreeFreight(){
        return $this->psql->GetFreeFreight();
    }
    public function GetFreight(){
        return $this->psql->GetFreight();
    }
    public function GetIntergralPropotrion(){
        return $this->psql->GetIntergralPropotrion();
    }
}
