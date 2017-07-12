<?php

namespace App\CreditCard;

use App\CreditCard\CreditCardSQL as CCSQL;

class CreditCardSystemError
{
    private $ccSQL;
    public function __construct(CCSQL $ccSQL){
        $this->ccSQL = $ccSQL;
    }
    
    public function SystemErrorData(
        $RC,
        $MID,
        $ONO
    ){
    	$this->ccSQL->CreditCardDataInsert(
            $RC,
            $MID,
            $ONO
        );
        $resultMessage = '系統錯誤';
        return $resultMessage;
    }
}
