<?php

namespace App\CreditCard;

use App\CreditCard\CreditCardSQL as CCSQL;
use View;

class CreditCardCancel
{
    private $ccSQL;
    public function __construct(CCSQL $ccSQL){
        $this->ccSQL = $ccSQL;
    }

    public function OrderCancel(
        $RC,
        $ONO
    ){
        
        if($RC == "00"){
            $this->ccSQL->OrderUpdateToCancel($ONO);
            $message = '取消交易成功';
        }else{
            $message = '取消交易失敗';
        }
        return $message;
    }

    public function PostDataToBank($url,$data){
    	$ch = curl_init();;
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
        return   $result;
    }
}
