<?php

namespace App\Order;

use App\Order\ProductInformation as PI;
use App\Login\Login as LG;
use  App\MemberCommodity\MemberCommodityCount as MCC;

class OrderDetailed
{
    private $pi;
    private $lg;
    private $mcc;

    public function __construct(PI $pi,LG $lg,MCC $mcc){
        $this->pi = $pi;
        $this->lg = $lg;
        $this->mcc = $mcc;
    }
    //

    public function OrderDetailed($orderID){
        $result = null;
        $memberID = $this->lg->LoginSessionID();
        if($memberID != null){
            $orderDetailData = $this->pi->GetOrderInformation($orderID);
            if($orderDetailData[0]['groupbuyID']!= null){
                $nowPrice = $this->mcc->MemberGroupbuyNowPrice($orderDetailData[0]['groupbuyID'],'groupbuy');
                $orderDetailData[0]['groupbuyPrice'] = $nowPrice;
            }
        }
        return $orderDetailData;
    }

    public function OrderDetailDel($orderID){
        return $this->pi->OrderDetailDel($orderID);
    }
}
