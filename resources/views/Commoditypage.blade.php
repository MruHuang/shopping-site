@extends('layouts.UserMaster')

@section('title','CommodityPage')

@section('anyone_head')
	@include('partials.head.CommoditypageHead')
@show

@section('content')
	<div class="panel panel-default commoditypage_panel_sytle">
        <div class="panel-heading">
        <h3>
        	<?php 
                if($type=='commodity') echo "一般區";
                else if($type=='groupbuy') echo "團購區";
                else if($type=='timelimit') echo "限時限量區";
            ?>
        </h3>
        </div>
        <div class="panel-body">
	        @if($type == 'commodity')
	        	@include('partials.SingleCommodity_1')
	        @endif
	        @if($type == 'groupbuy')
	        	@include('partials.SingleCommodity_2')
	        @endif
	        @if($type == 'timelimit')
	            @include('partials.SingleCommodity_3')
	        @endif
			<div class="panel panel-default commoditypage_introduction_area_sytle">
	            <div class="panel-body">
	                <h3 class="commoditypage_introduction_title_sytle">商品簡介</h3>
	                <p class="commoditypage_introduction_text_sytle">{{ $AllInformation['commodityIntroduction'] }}</p>
	            </div>
	            <div class="row">
	            	@if(is_null($AllInformation['commodityPhotoB']))
	            		<div class="col-xs-3"><img src="{{ asset('img/NoFindImage.jpg') }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></div>
	            	@else
	            		<div class="col-xs-3"><a class="display_img"><img src="/{{ $AllInformation['commodityPhotoB'] }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></a></div>
	            	@endif
	                
	                @if(is_null($AllInformation['commodityPhotoC']))
	            		<div class="col-xs-3"><img src="{{ asset('img/NoFindImage.jpg') }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></div>
	            	@else
	            		<div class="col-xs-3"><a class="display_img"><img src="/{{ $AllInformation['commodityPhotoC'] }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></a></div>
	            	@endif
	            	@if(is_null($AllInformation['commodityPhotoD']))
	            		<div class="col-xs-3"><img src="{{ asset('img/NoFindImage.jpg') }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></div>
	            	@else
	            		<div class="col-xs-3"><a class="display_img"><img src="/{{ $AllInformation['commodityPhotoD'] }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></a></div>
	            	@endif
	            	@if(is_null($AllInformation['commodityPhotoE']))
	            		<div class="col-xs-3"><img src="{{ asset('img/NoFindImage.jpg') }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></div>
	            	@else
	            		<div class="col-xs-3"><a class="display_img"><img src="/{{ $AllInformation['commodityPhotoE'] }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></a></div>
	            	@endif
	                
	            </div>
                @if(!is_null($AllInformation['commodityVideo']))
	        	<div style="width: 560px; margin-right: auto; margin-left: auto;">
	        		<iframe class="commoditypage_panel_player" src="{{ $AllInformation['commodityVideo'] }}" frameborder="0" allowfullscreen></iframe>
	        	</div>
                @endif
	        </div>
        </div>
    </div>

<div class="modal message_modal" id="display_image_area" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close message_close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">圖片</h4>
            </div>
            <div class="modal-body">
            	<img id="display_image" src="" style="width: 600px;height: 400px;display:block; margin-right: auto;margin-left: auto;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default message_close">Close</button>
            </div>
        </div>    
    </div>
</div>
<!-- /.modal -->


<script type="text/javascript">
    $(document).ready(function() {
    	var amount=1;
    	var last_Amount = $('#last_amount').attr('data_Amount');
    	if(last_Amount ==0 ){
    		amount = 0;
    	}
        var url_addcollection = $('.addCollectioin').attr('href');
        var url_addshoppingcar = $('.addShoppingCar').attr('href');
        var url_goCheckout = $('.goCheckout').attr('href');
        var url_goGroupbuyCheckout = $('.goGroupbuyCheckout').attr('href');

        $('.addCollectioin').attr('href',url_addcollection+'/'+amount);
        $('.addShoppingCar').attr('href',url_addshoppingcar+'/'+amount);
        $('.goCheckout').attr('href',url_goCheckout+'/'+amount);
        $('.goGroupbuyCheckout').attr('href',url_goGroupbuyCheckout+'/'+amount);

        $(".amount").change(function(event) {
            amount  = $(this).val();
            $('.addCollectioin').attr('href',url_addcollection+'/'+amount);
            $('.addShoppingCar').attr('href',url_addshoppingcar+'/'+amount);
            $('.goCheckout').attr('href',url_goCheckout+'/'+amount);
        });

        $('.display_img').click(function(event) {
        	var img_src = $(this).children().attr('src');
        	$('#display_image').attr('src',img_src);
        	$('#display_image_area').show();
        });
    });
</script>

@section('js_area')
<script type="text/javascript" src=" {{ asset('js/Message.js') }} "></script>
@show

@stop


