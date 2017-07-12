<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CreditCard\CreditCardTransactionComplete as CCTC;
use App\CreditCard\CreditCardSystemError as CCSE;
use App\CreditCard\CreditCardUserError as CCUE;
use App\CreditCard\CreditCardSQL as CCSQL;
use App\Http\Controllers\Member_commodityController as MCC;

class CreditCardController extends Controller
{
    //
    private $cctc, $ccse, $ccue, $ccSQL, $mcc;
    public $data_json = null;
    public function __construct(CCTC $cctc, CCSE $ccse, CCUE $ccue, CCSQL $ccSQL, MCC $mcc){
        $this->cctc = $cctc;
        $this->ccse = $ccse;
        $this->ccue = $ccue;
        $this->ccSQL = $ccSQL;
        $this->mcc = $mcc;
    }
    /*
    DATA=RC=00,MID=8089021965,ONO=C1001,LTD=20170710,LTT=225436,RRN=017191000033,AIR=882825,AN=552199******1856
    &
    MACD=5b2cb57b7a62daf79fab42fd2fc38deff36e32836a282722f281ae71fdab46bf
    */
    public function BackData(Request $Request){
        try{
            $message = '信用卡交易失敗';
            $MAC_KEY = env('MAC_KEY',null);
            $data = $Request->input('DATA');
            $MACD = $Request->input('MACD');
            
            
            $data_replace = preg_split('/,/',$data);
            $data_array = [];
            foreach($data_replace as $keyvalue){
                $keyvalue = preg_split('/=/',$keyvalue);
                $key = $keyvalue[0];
                $value = $keyvalue[1];
                $data_array = array_add($data_array, $key, $value);
            }

            $mac = hash('sha256', $data.','.$MAC_KEY);

            //回覆碼
            $RC = $data_array['RC'];
            //特約店代號
            $MID = $data_array['MID'];
            //訂單編號
            $ONO = $data_array['ONO'];
            //收單交易日期
            $LTD = $data_array['LTD'];
            //收單交易時間
            $LTT = $data_array['LTT'];
            //簽帳單序號
            $RRN = $data_array['RRN'];
            //受權碼
            $AIR = $data_array['AIR'];
            //卡號
            $AN = $data_array['AN'];
            //分期付款資料欄位(若有值才會回傳)
            //分期總金額
            // $ITA = $data_json['ITA'];
            // //分期期數
            // $IP = $data_json['IP'];
            // //每期金額
            // $IPA = $data_json['IPA'];
            // //頭期款金額
            // $IFPA = $data_json['IFPA'];

            // //銀行紅利(若有值才會回傳)
            // //剩餘點數
            // $BB = $data_json['BB'];
            // //折抵點數
            // $BRP = $data_json['BRP'];
            // //折抵金額
            // $BRA = $data_json['BRA'];
            $RC_Success = '00';
            $RC_Error_User = ['01','02','05','06',//請查詢銀行
                '07','08','09','10','11','12','13',//拒絕交易
                '14','54','62','X8','L1','L2','L3','L4','L5','L6'];
            $RC_Error_System = ['G0','G1','G2','G5','G6','G9'];

            //檢查資料是否被串改
            if ($MACD != $mac){
                //資料錯誤
                Log::info('信用卡-資料錯誤');
                $message = '傳送訊息被串改';
            }
            //檢查是否為使用者錯誤
            foreach($RC_Error_User as $errorCode){
                if($errorCode == $RC){
                    //GO TO ShowToUser(userError)
                    Log::info('信用卡-使用者錯誤');
                    $message = $this->ccue->UserErrorData(
                        $RC,
                        $MID,
                        $ONO
                    );
                }
            }
            //檢查是否為系統錯誤
            foreach($RC_Error_System as $errorCode){
                if($errorCode == $RC){
                    //GO TO SystemErrorCheck(SystemErrorCheck)
                    Log::info('信用卡-系統錯誤');
                    $message = $this->ccse->SystemErrorData(
                        $RC,
                        $MID,
                        $ONO
                    );
                }
            }
            

            //交易成功
            if($RC_Success == $RC){
                //GO TO Finish(TransactionComplete)
                $message = $this->cctc->TransactionComplete(
                    $RC,
                    $MID,
                    $ONO,
                    $LTD,
                    $LTT,
                    $RRN,
                    $AIR,
                    $AN
                );
            }
            
        }catch(\Exception $e){
            $result_message = $e;
        }finally{
           // return $message;
            return $this->mcc->Member_commodity('Car', $message);
            // return redirect()->route('Member_commodityController@Member_commodity',['Car', $message]);
        }
    }
}
