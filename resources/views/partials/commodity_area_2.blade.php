@for ($i = 0; $i < 2; $i++)
	<div class="col-xs-6">
		<div class="panel panel-primary ">
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
			    <?php $MAX=count($AllInformation[$array_key])<=12?count($AllInformation[$array_key]):12 ?>
				@for ($j = 0; $j < $MAX; $j++)
			    <div class="col-xs-4">
			        <!--商品-->
			            <a href="">
			            <div class="home_commodity_style">
			            	<img src="img/ps4.jpg" width=100%>
			            	<h5>名稱：{{ $AllInformation[$array_key][$j]['commodityName']  }}</h5>
			                <p>價格：{{ $AllInformation[$array_key][$j]['commodityPrice'] }}元</p>
			                <div style="display:none"></div>
			            </div>
			            </a>
			        <!--商品-->
			    </div>
				@endfor
			</div>
			<div class="text-right"><a href=" {{ route('Subpage',[
			'array_key'=>$array_key,
			'start'=>'1',
			'end'=>'12',
			'type'=>'All',
			'order_type'=>'created_at',
			'this_page'=>'1'
			]) }} " class="home_more_style">more...</a></div>
		</div>
	</div>
@endfor