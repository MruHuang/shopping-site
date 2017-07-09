<?php

namespace App\CreaditCard;

use App\CreaditCard\CreaditCardTransactionComplete as CCTC;

class CreaditCardBackData
{
    private $cctc;
    public function __construct(CCTC $cctc){
        $this->cctc = $cctc;
    }
/*
DATA: "RC=00,MID=8089021965,ONO=B0005,LTD=20170709,LTT=232722,RRN=027190000001,AIR=282680,AN=552199******1856",
MACD: "834241244300b0990c0c07aad4c587d14bb3d21cf3973936d3bc52366277b48c"
*/
    public function BackData(Request $Request){
    	$data = $Request->input('DATA');
        $MACD = $Request->input('MACD');
    	$data_json = json_decode($data);
        //回覆碼
        $RC = $data_json['RC'];
        //訂單編號
        $ONO = $data_json['ONO'];
        //收單交易日期
        $LTD = $data_json['LTD'];
        //收單交易時間
        $LTT = $data_json['LTT'];
        //簽帳單序號
        $RNN = $data_json['RNN'];
        //受權碼
        $AIR = $data_json['AIR'];
        //卡號
        $AN = $data_json['AN'];

        //分期付款資料欄位(若有值才會回傳)
        //分期總金額
        $ITA = $data_json['ITA'];
        //分期期數
        $IP = $data_json['IP'];
        //每期金額
        $IPA = $data_json['IPA'];
        //頭期款金額
        $IFPA = $data_json['IFPA'];

        //銀行紅利(若有值才會回傳)
        //剩餘點數
        $BB = $data_json['BB'];
        //折抵點數
        $BRP = $data_json['BRP'];
        //折抵金額
        $BRA = $data_json['BRA'];

        $RC_Success = '00';
        $RC_Error_User = ['01','14','54','62'];
        $RC_Error_System = ['G1','G6','G9'];

        foreach($RC_Error_User as $errorCode){
            if($errorCode == $RC){
                //GO TO ShowToUser
            }
        }

        foreach($RC_Error_System as $errorCode){
            if($errorCode == $RC){
                //GO TO SystemErrorCheck
            }
        }

        if($RC_Success == $RC){
            //GO TO Finish(TransactionComplete)
            $this->cctc->TransactionComplete(
                $ONO,
                $LTD,
                $LTT,
                $RNN,
                $AIR,
                $AN
            );
        }
       
    }

}
