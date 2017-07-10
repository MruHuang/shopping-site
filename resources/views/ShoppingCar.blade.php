@extends('layouts.UserMaster')

@section('title','ShoppingCar')

@section('anyone_head')
	@include('partials.head.ShoppingCarHead')
@show

@section('menu')
	@include('partials.Menu')
@stop

@section('content')
<div class="panel panel-default ">
    <div class="panel-heading">
        <h3 class="panel-title">購物車</h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th>商品名稱</th>
                <th>商品分類</th>
                <th>價格</th>
                <th>數量</th>
                <th>小計</th>
                <th></th>
            </tr>
            <?php $MAX= count($AllInformation); ?>
            @for($i=0;$i<$MAX;$i++)
            <tr>
                <td><a href="{{ route('Commoditypage',['type'=>$AllInformation[$i]['user_class'],'ID'=>$AllInformation[$i]['ID']]) }}" class="ID" data-id="{{ $AllInformation[$i]['ID'] }} " data-userid="{{ $AllInformation[$i]['user_ID'] }}">{{ $AllInformation[$i]['Name'] }}</a></td>
                <td data-Area="{{ $AllInformation[$i]['user_class'] }}" ><?php 
                        if($AllInformation[$i]['user_class']=='commodity') echo "一般區";
                        else if($AllInformation[$i]['user_class']=='timelimit') echo "限時限量區";
                    ?></td>
                <td class="price">{{ $AllInformation[$i]['price'] }}</td>
                <td>
                    <select class="form-control amount">
                    	<?php $option = $AllInformation[$i]['amount']; ?>
                    	@for($j=1;$j<=$option;$j++)
                            @if($j == $AllInformation[$i]['user_amount'])
                                <OPTION SELECTED>{{$j}}</option>
                            @else
                                <option>{{$j}}</option>
                            @endif
                    	@endfor
                    </select>
                </td>
                <td class="total_price">{{ ($AllInformation[$i]['price']*$AllInformation[$i]['user_amount']) }}</td>
                <td class="text-center">
                    <a data-id="{{ $AllInformation[$i]['user_ID'] }}" class="btn btn-primary delete">刪除</a>
                </td>
            </tr>
            @endfor
        </table>
        <div class="col-xs-12 alert alert-info text-right" ><p id="temporarily_total_amount">總金額 元</p></div>
    </div>
    {{--@include('partials.pagination')--}}
    @if(count($AllInformation)!=0)
    	<div class="row">
	        <div class="col-xs-4 col-xs-offset-4" style="margin-bottom: 20px; ">
	            <button class="btn btn-success" id="ordering" style="width: 100%;"> 前往下單 </button>
	        </div><!-- 
            <div class="col-xs-2" style="margin-bottom: 20px; ">
                
            </div> -->
	    </div>
    @endif
    
    <div class="panel panel-default" id="details" style="display: none;" style="margin-bottom: 0px;">
        <div class="panel-body" >
            <form role="form"  method="POST" action=" {{ Route('OrderShoppingCar') }} "> 
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="speciestype" value="Car">
                <input type="hidden" id="jsondata" name="jsondata" >
                <div class="form-group">
                    <label>收件人</label>
                    <input type="text" class="form-control" value="{{ $user_data['Name'] }}" name="recipient" placeholder="輸入收件人">
                </div>
                <div class="form-group">
                    <label>地址</label>
                <input type="text" class="form-control" value="{{ $user_data['Add'] }}" name="deliveryAdd" placeholder="輸入地址">
                </div>
                <div class="form-group">
                    <label>結帳方式</label>
                    <select class="form-control" name="checkoutMethod">
                        <option>ATM</option>
                        {{-- <option>貨到付款</option> --}}

                    </select>
                    <div class='alert alert-info' style='margin-left: 20px;'>
                    建議您使用快速方便的ATM轉帳!<br>以金融卡在全省任何一部ATM自動櫃員機，<br>都能執行交易，十分安全方便
                    </div>
                    <p class="help-block" id="free_freight" data-free_freight="{{ $freightInformation['freeFreight'] }}" >{{ $freightInformation['freeFreight'] }}元以上免運</p>
                </div>
                <div class="form-group" >
                    <label>匯款帳號</label>
                    <input type="text" class="form-control" value="{{ $freightInformation['RemittanceAccount'] }}" disabled>
                </div>
                <div class="form-group" style="margin-bottom: 0px;">
                    <label>運費</label>
                    <input class="form-control" id="freight" type="text" value="{{ $freightInformation['freight'] }}" disabled>
                </div>
                <div class="form-group" style="margin-bottom: 0px;">
                    <label>總金額</label>
                    <input class="form-control" id="total_amount" type="text" value="0元" disabled>
                </div>
                @if($user_data['Integral']>0)
                <div class="row" style="margin-left: 0px;margin-right: 0px;">
                    <div class="col-xs-9 " style="padding-left: 0px;">
                        <label>可用紅利點數</label>
                        <input class="form-control" type="text" id="Integral" data-PIntegral='1'  value="{{ $user_data['Integral'] }}" disabled>
                    </div>
                    <div class="col-xs-3" >
                        <label></label>
                        <div class="checkbox" style="margin-top: 35px;">
                            <label>
                                <input type="checkbox" name="is_useIntegral" id="is_use" > 使用
                            </label>
                        </div>
                    </div>
                </div>
                @else
                <div class="form-group" style="margin-bottom: 0px;">
                    <div class="alert alert-warning"><label>紅利點數小於等於零，無法使用紅利點數</label></div>
                </div>
                @endif
                <div class="form-group">
                    <label >最後金額</label>
                    <input class="form-control" type="text" id="final_price"  value="12285元" disabled>
                </div>
                <div class="text-right">
                    <button type="submit" id="checkout" type="submit" class="btn btn-success">下單</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade message_modal" style="display: none;" id="delete_message">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close message_close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">刪除再確認</h4>
            </div>
            <div class="modal-body">
                您確認要從購物車裡刪除此項商品
                <form role="form"  method="POST" id="del_commodity_form" action=" {{ Route('DelMemberCommodity') }} "> 
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="del_commodity_id" name="commodity_id" value="">
                    <input type="hidden" name="commodity_speciestype" value="Car">
                </form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-default message_close" style="float: right;margin-left: 20px;">Close</a>
                <a id="del_commodity_btn" class="btn btn-primary" style="float: right;">確認刪除</a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function() {
        compute_temporarily_total_amount();
        $('#ordering').click(function(event) {
            $('#details').show();
            $('#ordering').hide();
            $('.delete').attr('disabled', true);
            $('.amount').attr('disabled', true);
            compute_total_price();
            var json = "[";
            $('.ID').each(function() {
                var string="{";
                var ID = $(this).attr('data-id');
                var User_ID = $(this).attr('data-userid');
                var Area = $(this).parent().next().attr('data-Area');
                var Amount = $(this).parent().next().next().next().children().val();
                string = string +'"ID":'+ID+',"Area":"'+Area+'","Amount":'+Amount+',"userID":'+User_ID+'}';
                json = json+string+",";
            });
            json = json.substring(0,json.length - 1);
            json = json+"]";
            console.log(json);
            $("#jsondata").val(JSON.stringify(json));
            //$("#jsondata").val(JSON.stringify(json));
        });
        
        $('#checkout').click(function(event) {
            $('#Details').hide();
            $('#ordering').show();

        });

        $(".amount").change(function(event) {
            var amount = $(this).val();
            var price = $(this).parent().prev().text();
            $(this).parent().next().text(price*amount);
            compute_total_price();
            compute_temporarily_total_amount();
        });

        $('#is_use').change(function(event) {
            var is_use = $(this).prop('checked');
            compute_total_price();
            if(is_use){
                var point = parseInt($('#Integral').val());
                var PIntegral = parseInt($('#Integral').attr('data-PIntegral'));
                var final_price = parseInt($('#final_price').val());
                if(final_price>point){
                    final_price = final_price - point;
                }else final_price = 0;
                
                $('#final_price').val(final_price);
            }
        });

        $('.delete').click(function(event) {
            var del_commodity_id = $(this).attr('data-id');
            $('#del_commodity_id').val(del_commodity_id);
            $('#delete_message').show()
        });

        $('#del_commodity_btn').click(function(event) {
            $('#del_commodity_form').submit();
        });

        function compute_total_price(){
            var each_price = 0;
            var total_price=0; 
            $('.total_price').each(function() {
                each_price = parseInt($(this).text());
                total_price = total_price + each_price;
            });
            var free_freight = parseInt($('#free_freight').attr('data-free_freight'));
            if(total_price<free_freight){
                var freight = parseInt($('#freight').val());
                total_price = total_price + freight;
            }
            $('#total_amount').val(total_price);
            $('#final_price').val(total_price);
        }

        function compute_temporarily_total_amount(){
            var each_price = 0;
            var total_price=0; 
            $('.total_price').each(function() {
                each_price = parseInt($(this).text());
                total_price = total_price + each_price;
            });
            var temporarily_total_amount = "總金額"+total_price+"元";
            $('#temporarily_total_amount').text(temporarily_total_amount);
        }

    });
</script>
    
@stop

@if(count($message_text))
    @include('partials.Message')
@endif

@section('js_area')
    <script type="text/javascript" src=" {{ asset('js/Message.js') }} "></script>
@show