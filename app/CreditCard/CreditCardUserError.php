<?php

namespace App\CreditCard;

use App\CreditCard\CreditCardSQL as CCSQL;

class CreditCardUserError
{
    private $ccSQL;
    public function __construct(CCSQL $ccSQL){
        $this->ccSQL = $ccSQL;
    }

    public function UserErrorData(
        $RC,
        $MID,
        $ONO
    ){
        $resultMessage = '信用卡交易失敗，請洽詢銀行(';
    	$this->ccSQL->CreditCardDataInsert(
            $RC,
            $MID,
            $ONO
        );
        if($RC == '01'){
            $resultMessage += '請查詢銀行';
        }else if($RC == '14'){
            $resultMessage += '卡號錯誤';
        }else if($RC == '54'){
            $resultMessage += '卡片過期';
        }else if($RC == '62'){
            $resultMessage += '尚未開卡';
        }else if($RC == 'L1'){
            $resultMessage += '產品代碼錯誤';
        }else if($RC == 'L2'){
            $resultMessage += '期數錯誤';
        }else if($RC == 'L3'){
            $resultMessage += '不支援分期(他行卡)';
        }else if($RC == 'L4'){
            $resultMessage += '產品代碼過期';
        }else if($RC == 'L5'){
            $resultMessage += '金額無效';
        }else if($RC == 'L6'){
            $resultMessage += '不支援分期';
        }else{
            $resultMessage += '拒絕交易';
        }
        $resultMessage +=  $resultMessage.")";
        return $resultMessage;
    }
}
