@extends('layouts.UserMaster')

@section('title','Checkout')

{{-- @section('anyone_head')
	@include('partials.head.ShoppingCarHead')
@show --}}

@section('content')
<div class='panel panel-primary'>
    <div class='panel-heading'>結帳明細</div>
    <table class='table'>
        <tr>
            <th>商品名稱</th>
            <th>商品價格</th>
            <th>商品數量</th>
            <th></th>
        </tr>
        <?php $MAX=5; ?>
        @for($i=0;$i<count($AllInformation);$i++)
        <tr>
            <td>{{ $AllInformation[$i]['Name'] }}</td>
            <td>{{ $AllInformation[$i]['price'] }}</td>
            <td>{{ $AllInformation[$i]['user_amount'] }}</td>
            <td class='total_price'>{{ $AllInformation[$i]['user_amount']*$AllInformation[$i]['price'] }}</td>
        </tr>
        @endfor
    <table>
    <div style='margin:20px;'>
    <form role="form"  method="POST" action=" {{ Route('Checkout') }} "> 
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="jsondata" name="jsondata" value='{{ $json_data }}'>
        <div class="form-group">
            <label>收件人</label>
            <input type="text" class="form-control" value="{{ $recipient }}" name="recipient" readonly>
        </div>
        <div class="form-group">
            <label>地址</label>
            <input type="text" class="form-control" value="{{ $deliveryAdd }}" name="deliveryAdd" readonly>
        </div>
        <div class="form-group">
            <label>結帳方式</label>
            <input type="text" class="form-control" value="{{ $checkoutMethod }}" name="checkoutMethod" readonly>
        {{-- <div class='alert alert-info' style='margin-left: 20px;'>
            建議您使用快速方便的ATM轉帳!<br>以金融卡在全省任何一部ATM自動櫃員機，<br>都能執行交易，十分安全方便
        </div> --}}
        @if($checkoutMethod =='ATM')
        <div class='alert alert-info' style='margin-left: 20px;'>
            ATM匯款方式<br/>銀行代號：808<br/>存戶帳號：0129-940-053850<br/>玉山銀行雙和分行 <br/>
            戶名：藍星購物商行趙淑芬
        </div>
        @endif
        <div class="form-group" style="margin-bottom: 0px;">
            <label>運費</label>
            <input class="form-control" id="freeFreight" type="hidden" value="{{ $freightInformation['freeFreight'] }}" disabled>
            <input class="form-control" id="freight" type="text" value="{{ $freightInformation['freight'] }}" disabled>
        </div>
        <div class="form-group" style="margin-bottom: 0px;">
            <label>總金額</label>
            <input class="form-control" id="total_amount" type="text" value="0元" disabled>
        </div>
        <div class="form-group" style="margin-bottom: 0px;">
            <label>使用紅利點數</label>
            @if($is_useIntegral!=null)
                <input class="form-control" id="userIntegral" name="userIntegral" type="text" value="{{ $userIntegral }}" readonly>
            @else
                <input class="form-control" id="userIntegral" name="userIntegral" type="text" value="0" readonly>
            @endif
        </div>
        <div class="form-group">
            <label >最後金額</label>
            <input class="form-control" type="text" id="final_price"  value="0元" disabled>
        </div>
        <div class="text-right">
            <button type="submit" id="checkout" type="submit" class="btn btn-success">結帳</button>
        </div>
        
    </form>
    </div>
</div>

<script type="text/javascript">
    init();
    function init(){
        var each_price=0;
        var total_price=0;
        var final_price=0;
        var point = parseInt($('#userIntegral').val());
        $('.total_price').each(function(){
            each_price = parseInt($(this).text());
            total_price = total_price + each_price;
        });
        var free_freight = parseInt($('#freeFreight').val());
        var freight = parseInt($('#freight').val());
        if(total_price<free_freight){
                total_price = total_price + freight;
        }else{
            $('#freight').val(0);
        }
        $('#total_amount').val(total_price+'元');
        if(total_price>point){
            final_price = total_price - point;
            console.log(total_price,point);
        }else{
            final_price = 0;
        } 
        $('#final_price').val(final_price+'元');
        
    }
</script>

@stop

@if(count($message_text))
    @include('partials.Message')
@endif

@section('js_area')
    <script type="text/javascript" src=" {{ asset('js/Message.js') }} "></script>
@show