<?php

namespace App\CreditCard;

use App\MemberCommodity\MemberCommodity as MC;
use App\CreditCard\CreditCardSQL as CCS;
use View;
use Log;
class Transaction
{
    private $mc;
    private $ccs;
    public function __construct(MC $mc,CCS $ccs){
        $this->mc = $mc;
        $this->ccs = $ccs;
    }

    public function Transaction($random_number){
        $OrderData = $this->mc->GetOrder($random_number);
        if($OrderData[0]['checkoutMethod']=='CreditCard'){
            $url = env('CreadCardURL', false);
            $ONO = $random_number;
            $MID = env('MID', null);
            $MAC_KEY = env('MAC_KEY',null);
            $U = route('getCreditCard');
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
            $mac = hash('sha256', $data_json.$MAC_KEY);
            $ksn = 1;
            $postdata = array('data'=>$data_json,'mac'=>$mac,'ksn'=>$ksn,'url'=>$url);
            return View::make('POSTCreditCard',$postdata);
        }else{
            return  redirect()->route('TrackOrder',['state'=>'Unpaid']);
        }
    }

    public function checkOrder($random_number){
        $ONO = $random_number;
        $message_text = null;
        $MID = env('MID', null);
        $MAC_KEY = env('MAC_KEY',null);
        $checkONO_url = env('InquireOrderURL', false);
        $data = array(
            "MID"=>$MID,
            "ONO"=>$ONO,
        );
        $data_json = json_encode($data);
		$mac = hash('sha256', $data_json.$MAC_KEY);
		$ksn = 1;
        $postdata = array('data'=>$data_json,'mac'=>$mac,'ksn'=>$ksn);
        
        $result =  $this->curl_post($checkONO_url,$postdata);
		// Log::info('checkOrder:'.$result);
        // return $result;
		$data_replace = preg_split('/=/',$result);
        if(count($data_replace)==2){
            $data_array = (array)json_decode($data_replace[1]);
            if($data_array['returnCode'] =="00"){
                if($data_array['txnData']->RC=="00"){
                    $this->ccs->OrderUpdateToReady($ONO);
                    $message_text = "已結帳完畢";
                    return  redirect()->route('TrackOrder',['state'=>'Unpaid','message_text'=>$message_text]);
                }else if($data_array['txnData']->RC=="GD"){
                    return $this->Transaction($ONO);
                }else{
                    //之前刷卡失敗 重新給randomNUm
                    $random_number = strval(time()).str_random(5);
                    $this->ccs->ChangeOrderONO($ONO,$random_number);
                    return $this->checkOrder($random_number);
                }
            }else{
                $message_text = "維修中，請聯絡管理員";
                return  redirect()->route('TrackOrder',['state'=>'Unpaid','message_text'=>$message_text]);
            }
        }else{
            return $message_text = "維修中，請聯絡管理員";
            return  redirect()->route('TrackOrder',['state'=>'Unpaid','message_text'=>$message_text]);
        }
    }

    public function curl_post($url,$data){
    	$ch = curl_init();
    	$options = array(
		  CURLOPT_URL=>$url,
		  CURLOPT_REFERER=>$url,
		  CURLOPT_FOLLOWLOCATION =>true,
		  CURLOPT_ENCODING=>"Big5",
		  CURLOPT_RETURNTRANSFER=>true,
		  CURLOPT_AUTOREFERER=>0,
		  CURLOPT_POST=>true,
		  CURLOPT_POSTFIELDS=>http_build_query($data), // 直接給array
		  CURLOPT_CONNECTTIMEOUT=>10,
		  CURLOPT_TIMEOUT=>30,
		  CURLOPT_HEADER=>0,
		);
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);
        return $result;
        // echo $result;
    }
}