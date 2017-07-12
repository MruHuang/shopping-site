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
        @for($i=0;$i<count($OrderDetailed);$i++)
        <tr>
            <td>{{ $OrderDetailed[$i]['commodityName'] }}</td>
            @if($OrderDetailed[$i]['commodityArea']=='commodity')
            <td>一般區</td>
            @else
            <td>限量區</td>
            @endif
            <td>{{ $OrderDetailed[$i]['buyPrice'] }}</td>
            <td>{{ $OrderDetailed[$i]['commodityAmount'] }}</td>
            <td class='total_price'>{{ $OrderDetailed[$i]['commodityAmount']*$OrderDetailed[$i]['buyPrice'] }}</td>
        </tr>
        @endfor
    <table>
    <div style='margin:20px;'>
    <form role="form"  method="POST" action=" {{ Route('Checkout') }} "> 
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="randomNum" value="{{ $OrderData[0]['randomNum'] }}">
        <div class="form-group">
            <label>收件人</label>
            <input type="text" class="form-control" value="{{ $OrderData[0]['recipient'] }}" readonly>
        </div>
        <div class="form-group">
            <label>地址</label>
            <input type="text" class="form-control" value="{{ $OrderData[0]['deliveryAdd'] }}" readonly>
        </div>
        <div class="form-group">
            <label>結帳方式</label>
            <input type="text" class="form-control" value="{{ $OrderData[0]['checkoutMethod'] }}" readonly>
        {{-- <div class='alert alert-info' style='margin-left: 20px;'>
            建議您使用快速方便的ATM轉帳!<br>以金融卡在全省任何一部ATM自動櫃員機，<br>都能執行交易，十分安全方便
        </div> --}}
        @if($OrderData[0]['checkoutMethod'] =='ATM')
        <div class='alert alert-info' style='margin-left: 20px;'>
            ATM匯款方式<br/>銀行代號：808<br/>存戶帳號：0129-940-053850<br/>玉山銀行雙和分行 <br/>
            戶名：藍星購物商行趙淑芬
        </div>
        @endif
        <div class="form-group" style="margin-bottom: 0px;">
            <label>運費</label>
            <input class="form-control" id="freight" type="text" value="{{ $OrderData[0]['freight'] }}" disabled>
        </div>
        <div class="form-group" style="margin-bottom: 0px;">
            <label>使用紅利點數</label>
            <input class="form-control" id="userIntegral" type="text" value="{{ $OrderData[0]['useIntegral'] }}" readonly>
        </div>
        <div class="form-group" style="margin-bottom: 0px;">
            <label>總金額</label>
            <input class="form-control" id="total_amount" type="text" value="{{ $OrderData[0]['totalPrice'] }}元" disabled>
        </div>
        <div class="text-right">
            <button type="submit" id="checkout" type="submit" class="btn btn-success">結帳</button>
        </div>
        
    </form>
    </div>
</div>

@stop

@if(count($message_text))
    @include('partials.Message')
@endif

@section('js_area')
    <script type="text/javascript" src=" {{ asset('js/Message.js') }} "></script>
@show