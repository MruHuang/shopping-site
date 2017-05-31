
@extends('layouts.UserMaster')

@section('title','TrackOrder')

@section('anyone_head')
	{{--@include('partials.head.')--}}
@show

@section('menu')
	@include('partials.Menu')
@stop

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title" id="TrackOrderData" data-state="{{ $All['state'] }}">追蹤訂單</h3>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <ul class="nav nav-tabs" style="font-size: 15px;">
                <li role="presentation" id="Unpaid" class="active"><a href="{{ route('TrackOrder',['state'=>'Unpaid']) }}">未付款</a></li>
                <li role="presentation" id="Check"><a href="{{ route('TrackOrder',['state'=>'Check']) }}">待確認付款</a></li>
                <li role="presentation" id="Ready"><a href="{{ route('TrackOrder',['state'=>'Ready']) }}">準備出貨</a></li>
                <li role="presentation" id="Delivery"><a href="{{ route('TrackOrder',['state'=>'Delivery']) }}">送貨中</a></li>
                <li role="presentation" id="Carryout"><a href="{{ route('TrackOrder',['state'=>'Carryout']) }}">完成交易</a></li>
            </ul>
            <table class="table table-bordered" style="margin-bottom: 0px;">
                <tr>
                    <th>下訂時間</th>
                    <th>訂單編號</th>
                    <th>商品名稱</th>
                    <th>付款方式</th>
                    <th>總價</th>
                    <th>詳細</th>
                    <th>狀態</th>
                    @if($All['state']=='Unpaid')
                    <th>取消訂單</th>
                    @endif
                </tr>
                <?php $MAX= count($All['AllInformation']); ?>
                @for($i=0;$i<$MAX;$i++)
                    <tr>
                        <td><?php 
                                $time = preg_split("/ /",$All['AllInformation'][$i]['created_at']);
                                echo $time[0];
                            ?>
                        </td>
                        <td>{{ $All['AllInformation'][$i]['orderID'] }}</td>
                        <td>{{ $All['AllInformation'][$i]['OrderCommodityName'] }}</td>
                        <td>{{ $All['AllInformation'][$i]['checkoutMethod'] }}</td>
                        @if($All['AllInformation'][$i]['useIntegral']=='0' && $All['AllInformation'][$i]['totalPrice']=='0')
                            <td>暫無</td>   
                        @else
                            <td>{{ $All['AllInformation'][$i]['totalPrice'] }}</td>
                        @endif
                        
                        <td><a href="{{ route('SingleOrder',[
                        'orderID'=>$All['AllInformation'][$i]['orderID'],
                        'orderState'=>$All['AllInformation'][$i]['orderState']
                        ]) }}">詳細</a></td>
                        </td>

                        <td>
                        @if($All['AllInformation'][$i]['is_ordered'])
                            @if($All['AllInformation'][$i]['orderState'] == 'Unpaid')
                                @include('partials.order.orderUnpaid')
                            @elseif($All['AllInformation'][$i]['orderState'] == 'Check')
                                {{--@include('partials.order.orderReady')--}}
                                待確認付款
                            @elseif($All['AllInformation'][$i]['orderState'] == 'Ready')
                                {{--@include('partials.order.orderReady')--}}
                                準備出貨
                            @elseif($All['AllInformation'][$i]['orderState'] == 'Delivery')
                                {{--@include('partials.order.orderReady')--}}
                                送貨中
                            @elseif($All['AllInformation'][$i]['orderState'] == 'Carryout')
                                {{--@include('partials.order.orderReady')--}}
                                完成交易
                            @endif
                        @else
                            @include('partials.order.orderGroupbuy')
                        @endif

                        @if($All['AllInformation'][$i]['orderState']=='Unpaid')
                            <td>
                                <a class="btn btn-warning CancelOrderBtn" data_cancelID = "{{ $All['AllInformation'][$i]['orderID'] }}" style="width: 100%;">取消訂單</a>
                            </td>
                        @endif
                    </tr>
                @endfor
            </table>
        </div>
    </div>
    {{--@include('partials.pagination')--}}
</div>

<div class="modal fade message_modal CancelAgain" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close message_close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">再次確認</h4>
            </div>
            <div class="modal-body">
                確定要取消訂單?<br/>
                取消訂單後，將會有"取消訂單"之紀錄。
            </div>
            <div class="modal-footer">
                <a type="button" href="{{ route('cancelOrder') }}" id="cancel_confirm" class="btn btn-default message_close">確定取消訂單</a>
                <button type="button" class="btn btn-default message_close">關閉</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade message_modal orderFN_form" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close message_close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">匯款帳號後五碼</h4>
            </div>
            <div class="modal-body">
                <form role="form"  method="POST" id="orderFN_confirm_form" action="{{ route('TrackOrderFive') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="orderID" id="update_fn_orderID" value="">
                    <input type="hidden" name="orderState" id="update_fn_orderState" value="">
                    <div class="col-xs-6" style="padding: 0; padding-right: 5px;">
                        <input type="text" name="fiveNumber" class="form-control" placeholder="輸入後五碼" style="height: 25px;">
                    </div>
                    <div class="col-xs-3" style="padding: 0; ">
                        <a class="btn btn-success" id="orderFN_confirm_btn" style="width: 100%; padding: 2px 2px;">確認</a>
                    </div>
                    <div class="col-xs-3" style="padding: 0; ">
                        <a class="btn btn-warning message_close"  style="width: 100%; padding: 2px 2px;">關閉</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div id="loding_page" style="display: none;">
    @include('partials.Loading')
</div>

<script type="text/javascript">

    $(document).ready(function() {
        var orderID;
        var orderState;
        var url = $(cancel_confirm).attr('href');
        var state = $('#TrackOrderData').attr('data-state');
        init(state);
        $('.CancelOrderBtn').click(function(event) {
            var orderID = $(this).attr('data_cancelID');
            $('#cancel_confirm').attr('href',url+'/'+orderID);
            $('.CancelAgain').show();
        });

        $('.orderFN_btn').click(function(event) {
            orderID = $(this).attr('date-orderID');
            orderState = $(this).attr('date-orderState');
            $('.orderFN_form').show();
            $('#update_fn_orderID').val(orderID);
            $('#update_fn_orderState').val(orderState);
        });

        $('#orderFN_confirm_btn').click(function(event) {
            $('#loding_page').show();
            $('#orderFN_confirm_form').submit();
        });
    });

    function init(state){
        console.log(state);
        clear();
        if(state=='Unpaid'){
            $('#Unpaid').attr('class','active');
        }else if(state=='Check'){
            $('#Check').attr('class','active');
        }else if(state=='Ready'){
            $('#Ready').attr('class','active');
        }else if(state=='Delivery'){
            $('#Delivery').attr('class','active');
        }else{
            $('#Carryout').attr('class','active');
        }
    }

    function clear(){
        $('#Unpaid').attr('class','');
        $('#Check').attr('class','');
        $('#Ready').attr('class','');
        $('#Delivery').attr('class','');
        $('#Carryout').attr('class','');
    }

</script>

@stop

@if(count($order_detailed))
    @include('partials.OrderDetailedMessage')
@endif

@if(count($errors->all())||count($message_text))
    @section('message')
        @include('partials.Message')
    @show
@endif

@section('js_area')
    <script type="text/javascript" src=" {{ asset('js/Message.js') }} "></script>
@show