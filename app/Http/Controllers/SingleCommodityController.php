<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SingleCommodity\SingleCommodity as SC;
use App\Login\Login as LG;
use App\Model\Member_commodity as MC;
use View;


class SingleCommodityController extends Controller
{
	//
	private $sc;
    private $lg;
    public function __construct(SC $sc,LG $lg){
        $this->sc = $sc;
        $this->lg = $lg;
    }
	
    public function SingleCommodity($type='commodity', $ID='9', $message_text = null){
    	$AllInformation = $this->sc->Commodity($type, $ID);
        $commodityIntroduction = $AllInformation[0]['commodityIntroduction'];
        $AllInformation[0]['commodityIntroduction'] = str_replace(chr(13).chr(10), "<br />",$commodityIntroduction);
    	//$AllInformation = array_filter($AllInformation);
        //return $AllInformation; 
    	return view::make('Commoditypage',['AllInformation'=>$AllInformation[0],'type'=>$type,'message_text'=>$message_text]);
	}

    public function Member_commodityInsertData(
        $ID,
        $commodityClass,
        $commodityArea,
        $amount
    ){
        $user_ID = $this->lg->LoginSessionID();
        //return $ID.$commodityClass.$commodityArea.$amount;
        try{
            if($amount!=0){
                $member_commodity = new MC;
                $member_commodity->memberID = $user_ID;
                $member_commodity->commodityID = $ID;
                $member_commodity->commodityClass = $commodityClass;
                $member_commodity->commodityAmount = $amount;
                $member_commodity->commodityArea = $commodityArea;
                $member_commodity->isOrder = 1;
                $member_commodity->save();
                $message_text="加入成功";
            }else{
                $message_text="數量不足，無法加入購物車";
            }
        }catch (\Exception $e){
            $message_text="加入失敗，請try again。";
            if($user_ID == null)
                return View::make('Login',[
                    'isRegistered'=>null,
                    'message_text'=>null
                ]);
            $message_text = $e;
        }finally{
            return $this->SingleCommodity($commodityClass,$ID,$message_text);
        }
    }

    public function GoCheckout(
        $ID,
        $commodityClass,
        $commodityArea,
        $amount
    ){
        $user_ID = $this->lg->LoginSessionID();
        //$message_text = "123";
        try{
            if($amount!=0){
                $member_commodity = new MC;
                $member_commodity->memberID = $user_ID;
                $member_commodity->commodityID = $ID;
                $member_commodity->commodityClass = $commodityClass;
                $member_commodity->commodityAmount = $amount;
                $member_commodity->commodityArea = $commodityArea;
                $member_commodity->isOrder = 1;
                $member_commodity->save();
                $message_text="加入成功";
            }else{
                $message_text="數量不足，無法加入購物車";
            }
        }catch (\Exception $e){
            $message_text="加入失敗，請try again。";
            if($user_ID == null)
                return View::make('Login',[
                    'isRegistered'=>null,
                    'message_text'=>null
                ]);
            $message_text=$e;
        }finally{
            //return $message_text;
            return redirect()->route('ShoppingCar',['speciestype'=>'Car']);
        }
    }

    public function GoGroupbuyCheckout(
        $ID,
        $commodityClass,
        $commodityArea,
        $amount
    ){
        $user_ID = $this->lg->LoginSessionID();
        //return $ID.$commodityClass.$commodityArea.$amount;
        try{
            if($amount!=0){
                $member_commodity = new MC;
                $member_commodity->memberID = $user_ID;
                $member_commodity->commodityID = $ID;
                $member_commodity->commodityClass = $commodityClass;
                $member_commodity->commodityAmount = $amount;
                $member_commodity->commodityArea = $commodityArea;
                $member_commodity->isOrder = 1;
                $member_commodity->save();
                $message_text="加入成功";
            }else{
                $message_text="數量不足，無法加入購物車";
            }
        }catch (\Exception $e){
            $message_text="加入失敗，請try again。";
            if($user_ID == null)
                return View::make('Login',[
                    'isRegistered'=>null,
                    'message_text'=>null
                ]);
        }finally{
            return redirect()->route('ShoppingCar',['speciestype'=>'Groupbuy']);
        }
    }
}
