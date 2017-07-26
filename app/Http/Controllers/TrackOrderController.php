<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order\Order as OD;
use App\Order\OrderDetailed as ODD;
use App\Http\Requests\TrackOrderFiveRequest;
use App\Login\Login as LG;

use App\MemberCommodity\MemberCommodity as MC;
use App\CreditCard\Transaction as CCT;
use View;

class TrackOrderController extends Controller
{
    //
    private $od;
    private $lg;
    private $odd;
    private $mc;
    private $cct;

    public function __construct(OD $od, ODD $odd,LG $lg,MC $mc,CCT $cct){
    	$this->od = $od;
    	$this->odd = $odd;
        $this->lg = $lg;
        $this->mc = $mc;
        $this->cct = $cct;
    }

    public function OrderController(
        $state,
        $message_text = null,
        $order_detailed = null
    ){
    	$AllInformation=$this->od->Order($state);
        //return $AllInformation;
    	$All = Array(
    		'state'=>$state,
    		'AllInformation'=>$AllInformation
		);

    	//return $order_detailed;
    	return View::make('TrackOrder',['All'=>$All,'order_detailed'=>$order_detailed,'message_text'=>$message_text]);
    }

    public function OrderControllerDetailed($orderID,$orderState){
    	$order_detailed = $this->odd->OrderDetailed($orderID);
        $order_detailed['order_data'] = $this->od->SingleOrder($orderID);
        return $this->OrderController($orderState,null,$order_detailed);
    }

    // public function OrderUpdateFiveNumber(
    //     $orderID,
    //     $orderState,
    //     TrackOrderFiveRequest $Request
    // ){
    //     $fiveNumber = $Request->fiveNumber;
    //     $this->od->UpdateFiveNumber($orderID,
    //     $fiveNumber);
    //     return $this->OrderController($orderState);
    // }

    public function OrderUpdateFiveNumber(
        TrackOrderFiveRequest $Request
    ){
        $orderID = $Request->orderID;
        $orderState = $Request->orderState;
        $orderState ="Check";
        $fiveNumber = $Request->fiveNumber;
        $this->od->UpdateFiveNumber($orderID,
        $fiveNumber);
        return $this->OrderController($orderState);
    }


    public function CancelOrder($orderID){
        $result = null;
        try {
            //還紅利點數
            $this->od->AddIntegral($orderID);
            //增加取消訂單次數
            $this->od->AddCancel();
            // $this->odd->OrderDetailDel($orderID);
            // $this->od->OrderDel($orderID);
            $this->od->CancelOrder($orderID);
            if(!$this->lg->LoginSessionCheck()){
                return View::make('Login',[
                    'isRegistered'=>null,
                    'message_text'=>"請重新登入"
                ]);
            }
            $this->lg->UpdateSessionData();
            $result ='成功';
        } catch (\Exception $e) {
            $result ='失敗';
            //$result = $e;
        }finally{
            //return $result;
            return $this->OrderController('Unpaid',$result,null);
        }
    }

    public function TrackOrderCreditCard(Request $Request){
        $random_number = $Request->input('randomNum');
        $OrderData = $this->mc->GetOrder($random_number);
        $message_text = null;
        
        if($OrderData[0]['checkoutMethod']=='CreditCard'){
            return $this->cct->checkOrder($random_number);
        }else if($OrderData[0]['checkoutMethod']=='ATM'){
            return $this->OrderController('Unpaid',$message_text);
        }
    }

}
