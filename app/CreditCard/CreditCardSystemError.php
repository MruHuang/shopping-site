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
        $resultMessage = '系統錯誤(';
        
        if($RC == 'G6')
            $resultMessage+="訂單編號重複";
        else if($RC == 'G0')
             $resultMessage+="系統功能有誤";
        else if($RC == 'G1')
             $resultMessage+="交易逾時";
        else if($RC == 'G2')
             $resultMessage+="資料格式錯誤";
        else if($RC == 'G5')
             $resultMessage+="非使用中特定店";
        else if($RC == 'G9')
             $resultMessage+="Session檢查有誤";
        $random_number = strval(time()).str_random(5);
        $this->ccSQL->ChangeOrderONO($ONO,$random_number);
        return $resultMessage.')';
    }
}
