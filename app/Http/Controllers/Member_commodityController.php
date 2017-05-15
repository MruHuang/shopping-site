<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MemberCommodity\MemberCommodity as MC;
use App\MemberCommodity\MemberCommodityCount as MCC;
use App\Login\Login as LG;
use App\Model\Member_commodity as mcSQL;
use View;
use DB;

class Member_commodityController extends Controller
{
    //
    private $lg;
    private $mc;
    private $mcc;
    public function __construct(LG $lg,MC $mc, MCC $mcc){
        $this->lg = $lg;
        $this->mc = $mc;
        $this->mcc = $mcc;
    }

    public function Member_commodity($speciestype = null,$message_text = null
	){
       if(!$this->lg->LoginSessionCheck()){
            return View::make('Login',[
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
    public function DelMemberCommodity($ID,$speciestype){
        if(!$this->lg->LoginSessionCheck()){
            return View::make('Login',[
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

    public function OrderShoppingCar(Request $Request){
        //$result_message = $Request->is_useIntegral;
        $result_message = "請購買商品";
        if(!$this->lg->LoginSessionCheck()){
            return View::make('Login',[
                'message_text'=>"請重新登入"
            ]);
        }
        $user_data = $this->lg->LoginSessionID();
     
        try{
            $result_message = DB::transaction(function() use(
                $Request,
                $user_data,
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
                    'jsondata'=>$josn_array,
                    'memberID'=>$user_data,
                    'recipient'=>$recipient,
                    'deliveryAdd'=>$deliveryAdd,
                    'checkoutMethod'=>$checkoutMethod,
                    'is_useIntegral'=>$is_useIntegral,
                    'orderclass'=>'nogroupbuy'
                ));

                if ($result == 1){
                    foreach ($json_data as $key => $value) {
                        $this->DelMemberCommodity($json_data[$key]->userID,'Car');
                    }
                    $result_message = "訂購完成";
                }else  $result_message = "訂購失敗 (".$result.")";

                return $result_message;
            });
            

            
            //$result_message = '123';
        }catch (\Exception $e){
            // return View::make('Login',[
            //     'message_text'=>$e
            // ]);
            $result_message = $e;
        }
        finally{
            //return $result_message;
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
                if ($result == 1){
                    $this->DelMemberCommodity($json_data[$key]->userID,'Groupbuy');
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
