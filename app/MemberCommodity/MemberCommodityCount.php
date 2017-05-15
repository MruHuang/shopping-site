<?php

namespace App\MemberCommodity;

use App\MemberCommodity\MemberCommodityInformation as MCI;

class MemberCommodityCount
{
    private $mci;
   
    public function __construct(MCI $mci){
        $this->mci = $mci;
    }

    public function MemberCommodityCount(
        $ID,
        $speciestype
    ){
        $result = $this->mci->GetCommodityCount(
            $ID,
            $speciestype
        );
        return $result;
    }

    public function MemberGroupbuyCount(
        $ID,
        $speciestype
    ){
        $result = $this->mci->GetGroupbuyCount(
            $ID,
            $speciestype
        );
        return $result;
    }

    public function MemberGroupbuyNowPrice(
        $ID,
        $speciestype,
        $amount = 0
    ){
        $NowAmount = $this->MemberGroupbuyCount(
            $ID,
            $speciestype
        );
        $NowAmount = $NowAmount + $amount;
        $groupbuyCommodity = $this->mci->GetGroupbuyCommodity($ID);
        if($NowAmount >= $groupbuyCommodity[0]['groupbuyAmountD'] && $groupbuyCommodity[0]['groupbuyAmountD']!=null)
            return $groupbuyCommodity[0]['groupbuyPriceD'];   
        else if($NowAmount >= $groupbuyCommodity[0]['groupbuyAmountC'] && $groupbuyCommodity[0]['groupbuyAmountC']!=null)
            return $groupbuyCommodity[0]['groupbuyPriceC'];   
        else if($NowAmount >= $groupbuyCommodity[0]['groupbuyAmountB'] && $groupbuyCommodity[0]['groupbuyAmountB']!=null)
            return $groupbuyCommodity[0]['groupbuyPriceB'];   
        else if($NowAmount >= $groupbuyCommodity[0]['groupbuyAmountA'] && $groupbuyCommodity[0]['groupbuyAmountA']!=null)
            return $groupbuyCommodity[0]['groupbuyPriceA'];   
        else
            return $groupbuyCommodity[0]['groupbuyPrice'];
    }

}
