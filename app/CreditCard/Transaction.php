<?php

namespace App\CreditCard;

use App\MemberCommodity\MemberCommodity as MC;
use View;
use Log;
class Transaction
{
    private $mc;
    public function __construct(MC $mc){
        $this->mc = $mc;
    }

    public function Transaction($random_number){
        Log::info('CCT');
        $OrderData = $this->mc->GetOrder($random_number);
        if($OrderData[0]['checkoutMethod']=='CreditCard'){
            $url = env('CreadCardURL', false);
            $ONO = $random_number;
            $MID = env('MID', null);
            $MAC_KEY = env('MAC_KEY',null);
            $U = route('GetCreditCard');
            $TA = $OrderData[0]['totalPrice'];
            $TID = env('TID', null);
            $data = array(
                "ONO"=>$ONO,
                "U"=>$U,
                "MID"=>$MID,
                "TA"=>$TA,
                "TID"=>$TID,
            );
            $data_json = json_encode($data);
            $mac = hash('sha256', $data_json+$MAC_KEY);
            $ksn = 1;
            $postdata = array('data'=>$data_json,'mac'=>$mac,'ksn'=>$ksn,'url'=>$url);
            return View::make('POSTCreditCard',$postdata);
        }else{
            return  redirect()->route('TrackOrder',['state'=>'Unpaid']);
        }
    }
}