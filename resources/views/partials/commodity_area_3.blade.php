@for ($i = 0; $i < count($AllInformation); $i++)

	<div class="col-xs-{{ 12/count($AllInformation) }}">
		<div class="panel panel-primary">
		    <div class="panel-heading">
		    	<div class="row" style="position: relative;">
		    		<div class="col-xs-8">
		    			<h3>
				        <?php $array_key = array_keys($AllInformation)[$i]; 
				            if($array_key=='commodity') echo "一般區";
				            else if($array_key=='groupbuy') echo "團購區";
				            else if($array_key=='timelimit') echo "限時限量區";
				        ?> 
				        </h3>
		    		</div>
		    		<div class="col-xs-4" style="bottom:0px; position:absolute; margin-left: 66.66666667%;">
		    			<a href=" {{ route('Subpage',[
			            'array_key'=>$array_key,
			            'start'=>'1',
			            'end'=>'12',
			            'type'=>'All',
			            'order_type'=>'created_at',
			            'this_page'=>'1'
			            ]) }} " class="home_more_style" style="color: red; float: right;font-size: 20px;">more...</a>
		    		</div>
		    	</div>
		    </div>
		    <div class="panel-body">
			    <?php $MAX=count($AllInformation[$array_key])<=(18/count($AllInformation))?count($AllInformation[$array_key]):(18/count($AllInformation)) ?>
				@for ($j = 0; $j < $MAX; $j++)
				    <div class="col-xs-{{24/(12/count($AllInformation))}}"  style="height: 180px">
				        <!--商品-->
			            <a href="{{ route('Commoditypage',[
			            'type'=>$array_key,
			            'ID'=>$AllInformation[$array_key][$j]['ID']
			            ]) }}">
			            <div class="home_commodity_style">
			            	<img src="{{ $AllInformation[$array_key][$j]['commodityPhotoA'] }}" width=100%>
			            	<!-- <h5>名稱：</h5> -->
			            	<h5>{{ $AllInformation[$array_key][$j]['commodityName']  }}</h5>
			                <p>價格：{{ $AllInformation[$array_key][$j]['commodityPrice'] }}元</p>
			                <div style="display:none">{{ $AllInformation[$array_key][$j]['ID'] }}</div>
			            </div>
			            </a>
				        <!--商品-->
				    </div>
				@endfor
			</div>
			@if($MAX == (18/count($AllInformation)))
			<div class="text-right"><a href=" {{ route('Subpage',[
			'array_key'=>$array_key,
			'start'=>'1',
			'end'=>'12',
			'type'=>'All',
			'order_type'=>'created_at',
			'this_page'=>'1'
			]) }} " class="home_more_style" style="color: red">more...</a></div>
			@endif
		</div>
	</div>
@endfor