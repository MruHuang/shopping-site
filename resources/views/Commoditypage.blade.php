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
	            		<div class="col-xs-3"><img src="/{{ $AllInformation['commodityPhotoB'] }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></div>
	            	@endif
	                
	                @if(is_null($AllInformation['commodityPhotoC']))
	            		<div class="col-xs-3"><img src="{{ asset('img/NoFindImage.jpg') }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></div>
	            	@else
	            		<div class="col-xs-3"><img src="/{{ $AllInformation['commodityPhotoC'] }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></div>
	            	@endif
	            	@if(is_null($AllInformation['commodityPhotoD']))
	            		<div class="col-xs-3"><img src="{{ asset('img/NoFindImage.jpg') }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></div>
	            	@else
	            		<div class="col-xs-3"><img src="/{{ $AllInformation['commodityPhotoD'] }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></div>
	            	@endif
	            	@if(is_null($AllInformation['commodityPhotoE']))
	            		<div class="col-xs-3"><img src="{{ asset('img/NoFindImage.jpg') }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></div>
	            	@else
	            		<div class="col-xs-3"><img src="/{{ $AllInformation['commodityPhotoE'] }}" alt="{{ $AllInformation['commodityName'] }}" width=100%></div>
	            	@endif
	                
	            </div>
	        	<div style="width: 560px; margin-right: auto; margin-left: auto;">
	        		<iframe class="commoditypage_panel_player" src="{{ $AllInformation['commodityVideo'] }}" frameborder="0" allowfullscreen></iframe>
	        	</div>
	        </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function() {
    	var amount=1;
    	var last_Amount = $('#last_amount').attr('data_Amount');
    	if(last_Amount ==0 ){
    		amount = 0;
    	}
        var url_addcollection = $('.addCollectioin').attr('href');
        var url_addshoppingcar = $('.addShoppingCar').attr('href');
        $('.addCollectioin').attr('href',url_addcollection+'/'+amount);
        $('.addShoppingCar').attr('href',url_addshoppingcar+'/'+amount);

        $(".amount").change(function(event) {
            amount  = $(this).val();
            $('.addCollectioin').attr('href',url_addcollection+'/'+amount);
            $('.addShoppingCar').attr('href',url_addshoppingcar+'/'+amount);
        });
    });
</script>
@stop

@if(count($message_text))
	@include('partials.Message')
@endif

@section('js_area')
<script type="text/javascript" src=" {{ asset('js/Message.js') }} "></script>
@show
