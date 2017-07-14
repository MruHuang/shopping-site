<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MemberCommodity\MemberCommodity as MC;
use App\MemberCommodity\MemberCommodityCount as MCC;
use App\Login\Login as LG;
use App\Model\Member_commodity as mcSQL;
use App\CreditCard\Transaction as CCT;
use View;
use DB;
use Log;

class Member_commodityController extends Controller
{
    //
    private $lg;
    private $mc;
    private $mcc;
    private $cct;
    public function __construct(LG $lg,MC $mc, MCC $mcc,CCT $cct){
        $this->lg = $lg;
        $this->mc = $mc;
        $this->mcc = $mcc;
        $this->cct = $cct;
    }

    public function Member_commodity($speciestype = null,$message_text = null
	){
       if(!$this->lg->LoginSessionCheck()){
            return View::make('Login',[
                'isRegistered'=>null,
                'message_text'=>"請重新登入"
            ]);
        }
		$user_ID = $this->lg->LoginSessionID();
    	$AllInformation = $this->mc->MemberCommodity(
    		$user_ID,
    		$speciestype
		);
        $promotionData = $this->mc->Getpromotion();
        if($speciestype=='Car'){
            $userData = $this->lg->GetSessionData();
            $userIntegral = $this->lg->LoginIntegral();
            $userData['Integral'] = $userIntegral;
            //return $AllInformation;
            return View::make('ShoppingCar',['AllInformation'=>$AllInformation,'message_text'=>$message_text,'user_data'=>$userData,'freightInformation'=>$promotionData[0]]);
        }else if($speciestype=='Collection'){
            //return $AllInformation;
            return View::make('CollectionArea',['AllInformation'=>$AllInformation,'message_text'=>$message_text,'freightInformation'=>$promotionData[0]]);
        }else{
            //return $AllInformation;
            $userData = $this->lg->GetSessionData();
            $userIntegral = $this->lg->LoginIntegral();
            $userData['Integral'] = $userIntegral;
            return View::make('GroupbuyShoppingCar',['AllInformation'=>$AllInformation,'message_text'=>$message_text,'user_data'=>$userData,'freightInformation'=>$promotionData[0]]);
        }
    	
    }

    public function thisDelMemberCommodity($ID,$speciestype){
        if(!$this->lg->LoginSessionCheck()){
            return View::make('Login',[
                'isRegistered'=>null,
                'message_text'=>"請重新登入"
            ]);
        }
        $user_ID = $this->lg->LoginSessionID();
        try{
            $del_member_commodity = mcSQL::GetAllData(
                $ID
            )->delete();
            $message_text="刪除成功";
        }catch(Exception $e){
            //return $e;
            $message_text="刪除失敗，請try again。";
        }finally{
            //$message_text = "123";
            return $this->Member_commodity($speciestype,$message_text);
        }
    }

    public function DelMemberCommodity(Request $Request){
        //return $Request->all();
        $ID = $Request->input('commodity_id');
        $speciestype = $Request->input('commodity_speciestype');
        if(!$this->lg->LoginSessionCheck()){
            return View::make('Login',[
                'isRegistered'=>null,
                'message_text'=>"請重新登入"
            ]);
        }
        $user_ID = $this->lg->LoginSessionID();
        try{
            $del_member_commodity = mcSQL::GetAllData(
                $ID
            )->delete();
            $message_text="刪除成功";
        }catch(Exception $e){
            //return $e;
            $message_text="刪除失敗，請try again。";
        }finally{
            //$message_text = "123";
            return $this->Member_commodity($speciestype,$message_text);
        }
    } 

    public function GetCount(
        $ID,
        $type
    ){
        $result = $this->mcc->MemberCommodityCount(
            $ID,
            $type
        );
        return $result;
    }
   
    public function Checkout(Request $Request){
    	//return $Request->all();
        $random_number = $Request->input('randomNum');
        $message_text=null;
        $OrderData = $this->mc->GetOrder($random_number);
        if($OrderData[0]['checkoutMethod']=='CreditCard'){
            return $this->cct->checkOrder($random_number);
        }else if($OrderData[0]['checkoutMethod']=='ATM') {
            $message_text = 'ATM付完款後，請輸入匯款後五碼';
            return  redirect()->route('TrackOrder',['state'=>'Unpaid','message_text'=>$message_text]);
        }
    }

    public function GetCreditCard(Request $Request){
    	return $Request->all();

    }

    public function OrderShoppingCar(Request $Request){
        //return $Request->all();
        $result_message = "請購買商品";
        if(!$this->lg->LoginSessionCheck()){
            return View::make('Login',[
                'isRegistered'=>null,
                'message_text'=>"請重新登入"
            ]);
        }
        $user_data = $this->lg->LoginSessionID();
        $random_number = strval(time()).str_random(5);
        $checkoutMethod = $Request->checkoutMethod;
        try{
            $result_message = DB::transaction(function() use(
                $Request,
                $user_data,
                $random_number,
                $result_message
            ){
                $jsondata = $Request->jsondata;
                $recipient = $Request->recipient;
                $deliveryAdd = $Request->deliveryAdd;
                $checkoutMethod = $Request->checkoutMethod;
                $is_useIntegral = $Request->is_useIntegral;
                $josn_array = array();
                $json_data = json_decode(json_decode($jsondata));
                foreach ($json_data as $key => $value) {
                    array_push($josn_array, (array)$json_data[$key]);
                }

                $result = $this->mc->InsertToOrder(array(
                    'random_number'=>$random_number,
                    'jsondata'=>$josn_array,
                    'memberID'=>$user_data,
                    'recipient'=>$recipient,
                    'deliveryAdd'=>$deliveryAdd,
                    'checkoutMethod'=>$checkoutMethod,
                    'is_useIntegral'=>$is_useIntegral,
                    'orderclass'=>'nogroupbuy'
                ));

            	if ($result){
            		foreach ($json_data as $key => $value) {
            			$this->thisDelMemberCommodity($json_data[$key]->userID,'Car');
            		}
            		$result_message = "訂購完成";
	            }else  
	            	$result_message = "訂購失敗 (".$result.")";

	            return $result_message;
            });
            if($result_message =='訂購完成'){
                $OrderData = $this->mc->GetOrder($random_number);
                $OrderDetailed = $this->mc->GetOrderDetailed($OrderData[0]['orderID']);
                if($checkoutMethod == 'ATM'){
                    $message_text= '下單已完成，請前往ATM結帳';
                }else if($checkoutMethod == 'CreditCard'){
                    $message_text= '下單已完成，請點選下方結帳鈕進行線上刷卡結帳';
                }
                $data = array('OrderData'=>$OrderData,'OrderDetailed'=>$OrderDetailed,'message_text'=>$message_text);
                return View::make('Checkout',$data);
            }else{
                return $this->Member_commodity('Car',$result_message);
            }
        }catch (\Exception $e){
            $result_message = $e;
            return $this->Member_commodity('Car',$result_message);
        }
    }

    public function OrderGroupbuyShoppingCar(Request $Request){
        $result_message = "請購買商品";
        $jsondata = $Request->jsondata;
        $recipient = $Request->recipient;
        $deliveryAdd = $Request->deliveryAdd;
        $checkoutMethod = $Request->checkoutMethod;
        $is_useIntegral = $Request->is_useIntegral;
        if(!$this->lg->LoginSessionCheck()){
            return View::make('Login',[
                'isRegistered'=>null,
                'message_text'=>"請重新登入"
            ]);
        }
        $user_data = $this->lg->LoginSessionID();

        $josn_array = array();
        $json_data = json_decode(json_decode($jsondata));
        try{
            foreach ($json_data as $key => $value) {
                array_push($josn_array, (array)$json_data[$key]);
                //return $josn_array;
                $result =$this->mc->InsertToOrder(array(
                    'jsondata'=>$josn_array,
                    'memberID'=>$user_data,
                    'recipient'=>$recipient,
                    'deliveryAdd'=>$deliveryAdd,
                    'checkoutMethod'=>$checkoutMethod,
                    'is_useIntegral'=>$is_useIntegral,
                    'orderclass'=>'groupbuy'
                ));
                $josn_array = null;
                $josn_array = array();
                if ($result){
                    $this->thisDelMemberCommodity($json_data[$key]->userID,'Groupbuy');
                    $result_message = "訂購完成";
                }else $result_message = "訂購失敗 (".$result.")";
                
            }
        }catch(\Exception $e){
            $result_message = $e;
        }finally{
            return $this->Member_commodity('Groupbuy',$result_message);
        }
    }
}
