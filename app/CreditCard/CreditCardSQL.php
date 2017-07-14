<?php

namespace App\CreditCard;

use App\Model\commodity as cmSQL;
use App\Model\groupbuy_commodity as gcSQL;
use App\Model\limited_commodity as lcSQL;
use App\Model\Member as mbSQL;
use App\Model\Member_commodity as mcSQL;
use App\Model\merchandise_order as odSQL;
use App\Model\promotion as ptSQL;
use App\Model\CreditCard as ccSQL;

class CreditCardSQL
{
    //儲存信用卡資訊
    public function CreditCardDataInsert(
        $RC,
        $MID,
        $ONO,
        $LTD = null,
        $LTT = null,
        $RRN = null,
        $AIR = null,
        $AN = null,
        $ITA = null,
        $IP = null,
        $IPA = null,
        $IFPA = null,
        $BB = null,
        $BRA = null
    ){
    	$inset_data = new ccSQL();
        $inset_data->RC = $RC;
        $inset_data->MID = $MID;
        $inset_data->ONO = $ONO;
        $inset_data->LTD = $LTD;
        $inset_data->LTT = $LTT;
        $inset_data->RRN = $RRN;
        $inset_data->AIR = $AIR;
        $inset_data->AN = $AN;
        $inset_data->ITA = $ITA;
        $inset_data->IP = $IP;
        $inset_data->IPA = $IPA;
        $inset_data->IFPA = $IFPA;
        $inset_data->BB = $BB;
        $inset_data->BRA = $BRA;
        $inset_data->save();
        return $inset_data;
    }
    //檢查訂單為信用卡付款，並修改訂單情況至以付款(代出貨)
    public function OrderUpdateToReady($ONO){
        odSQL::CheckoutMethodCreditCard()
        ->CheckONO($ONO)
        ->update(['orderState'=>'Ready']);
        return true;
    }
    //計算該筆訂單的數量(正常一筆)
    public function CheckCreditCardTransactionComplete($ONO){
        $result = ccSQL::CheckTransactionComplete()
        ->CheckONO($ONO)
        ->get();
        return $result->count();
    }

    public function ChangeOrderONO(
        $ONO,
        $random_number
    ){
        odSQL::CheckoutMethodCreditCard()
        ->CheckONO($ONO)
        ->update(['randomNum'=>$random_number]);
        return true;
    }
}
