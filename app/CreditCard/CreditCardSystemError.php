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
        $orderID,
        $RC,
        $MID,
        $ONO
    ){
    	$this->ccSQL->CreditCardDataInsert(
            $orderID,
            $RC,
            $MID,
            $ONO
        );
        $resultMessage = '系統錯誤(';
        
        if($RC == 'G6')
            $resultMessage= $resultMessage."訂單編號重複";
        else if($RC == 'G0')
             $resultMessage= $resultMessage."系統功能有誤";
        else if($RC == 'G1')
             $resultMessage= $resultMessage."交易逾時";
        else if($RC == 'G2')
             $resultMessage= $resultMessage."資料格式錯誤";
        else if($RC == 'G5')
             $resultMessage= $resultMessage."非使用中特定店";
        else if($RC == 'G9')
             $resultMessage= $resultMessage."Session檢查有誤";
        $random_number = strval(time()).str_random(5);
        $this->ccSQL->ChangeOrderONO($ONO,$random_number);
        
        $resultMessage = $resultMessage.")，請再次點選'前往刷卡結帳'";
        return $resultMessage;
    }
}
