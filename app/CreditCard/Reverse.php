<?php

namespace App\CreditCard;

use App\MemberCommodity\MemberCommodity as MC;
use App\CreditCard\CreditCardSQL as CCSQL;
use View;
use Log;
class Reverse
{
    private $mc, $ccsql;
    public function __construct(MC $mc,CCSQL $ccsql){
        $this->mc = $mc;
        $this->ccsql = $ccsql;
    }
    //沖正交易(反向交易)
    public function Reverse(
        $TYP,
        $RC,
        $MID,
        $ONO,
        $LTD,
        $LTT,
        $RRN,
        $AIR,
        $AN
    ){
        if($TYP == '05'){//受權(變回未交易)
            $this->ccsql->OrderUpdateToUnpaid($ONO);
        }else if($TYP == '51'){//取消授權(變回交易成功)
             $this->ccsql->OrderUpdateToReady($ONO);
        }else if($TYP == '71'){//退貨受權(ㄟ~目前無此功能，站實跟取消授權一樣)
             $this->ccsql->OrderUpdateToReady($ONO);
        }
    }
}