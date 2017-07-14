<?php

namespace App\CreditCard;
use App\CreditCard\CreditCardSQL as CCSQL;

class CreditCardTransactionComplete
{
    private $ccSQL;
    public function __construct(CCSQL $ccSQL){
        $this->ccSQL = $ccSQL;
    }

    public function TransactionComplete(
        $RC,
        $MID,
        $ONO,
        $LTD,
        $LTT,
        $RRN,
        $AIR,
        $AN
    ){
        $resultMessage = '信用卡以交易成功，訂單發生例外情況請聯絡相關人員';
        //新增資料
        $this->ccSQL->CreditCardDataInsert(
            $RC,
            $MID,
            $ONO,
            $LTD,
            $LTT,
            $RRN,
            $AIR,
            $AN
        );
        $resultMessage = '信用卡以交易成功，發生例外情況請聯絡相關人員，訂單並不唯一，您的訂單編號為('.$ONO.")";
        //檢查訂單是否唯一
        if($this->ccSQL->CheckCreditCardTransactionComplete($ONO) == 1){
            //更新訂單狀態
            if($this->ccSQL->OrderUpdateToReady($ONO)){
                $resultMessage = '信用卡以交易成功';//
            }else{
                // Log::info('修改資訊失敗');
              
           
                $resultMessage =  '信用卡以交易成功，發生例外情況請聯絡相關人員，訂單並未更新，請聯絡服務人員，更改訂單狀態，您的訂單編號為('.$ONO.")";//
            }
        }
        return $resultMessage;
    }
}
