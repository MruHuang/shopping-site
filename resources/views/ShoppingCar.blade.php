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
                <th>總價</th>
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
                    <a href=" {{ route('DelMemberCommodity',['ID'=>$AllInformation[$i]['user_ID'],'$speciestype'=>'Car' ]) }} " class="btn btn-primary delete">刪除</a>
                </td>
            </tr>
            @endfor
        </table>
    </div>
    {{--@include('partials.pagination')--}}
    @if(count($AllInformation)!=0)
    	<div class="row">
	        <div class="col-xs-4 col-xs-offset-4" style="margin-bottom: 20px; ">
	            <button class="btn btn-success" id="ordering" style="width: 100%;"> 下訂 </button>
	        </div>
	    </div>
    @endif
    
    <div class="panel panel-default" id="details" style="display: none;" style="margin-bottom: 0px;">
        <div class="panel-body" >
            <form role="form"  method="POST" action=" {{ Route('OrderShoppingCar') }} "> 
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                        <option>貨到付款</option>
                    </select>
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
                        <label>可用積分</label>
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
                    <div class="alert alert-warning"><label>積分小於等於零，無法使用積分</label></div>
                </div>
                @endif
                <div class="form-group">
                    <label >最後金額</label>
                    <input class="form-control" type="text" id="final_price"  value="12285元" disabled>
                </div>
                <div class="text-right">
                    <button type="submit" id="checkout" type="submit" class="btn btn-success">結帳</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
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

    });
</script>
    
@stop

@if(count($message_text))
    @include('partials.Message')
@endif

@section('js_area')
    <script type="text/javascript" src=" {{ asset('js/Message.js') }} "></script>
@show