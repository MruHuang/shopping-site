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
        $orderID,
        $RC,
        $MID,
        $ONO
    ){
        $resultMessage = '信用卡交易失敗(';
    	$this->ccSQL->CreditCardDataInsert(
            $orderID,
            $RC,
            $MID,
            $ONO
        );
        if($RC == '01'){
            $resultMessage = $resultMessage.'請查詢銀行';
        }else if($RC == '14'){
            $resultMessage = $resultMessage.'卡號錯誤';
        }else if($RC == '54'){
            $resultMessage = $resultMessage.'卡片過期';
        }else if($RC == '62'){
            $resultMessage = $resultMessage.'尚未開卡';
        }else if($RC == 'L1'){
            $resultMessage = $resultMessage.'產品代碼錯誤';
        }else if($RC == 'L2'){
            $resultMessage = $resultMessage.'期數錯誤';
        }else if($RC == 'L3'){
            $resultMessage = $resultMessage.'不支援分期(他行卡)';
        }else if($RC == 'L4'){
            $resultMessage = $resultMessage.'產品代碼過期';
        }else if($RC == 'L5'){
            $resultMessage = $resultMessage.'金額無效';
        }else if($RC == 'L6'){
            $resultMessage = $resultMessage.'不支援分期';
        }else{
            $resultMessage = $resultMessage.'拒絕交易';
        }
        $resultMessage = $resultMessage.")";
        //之前刷卡失敗 重新給randomNUm
        $random_number = strval(time()).str_random(5);
        $this->ccSQL->ChangeOrderONO($ONO,$random_number);
        return $resultMessage;
    }
}
