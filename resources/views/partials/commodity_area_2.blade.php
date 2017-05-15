@for ($i = 0; $i < 2; $i++)
	<div class="col-xs-6">
		<div class="panel panel-primary ">
		    <div class="panel-heading text-center">
		        <h3 class="panel-title">
		        <?php $array_key = array_keys($AllInformation)[$i]; 
		            if($array_key=='commodity') echo "一般區";
		            else if($array_key=='groupbuy') echo "團購區";
		            else if($array_key=='timelimit') echo "限時限量區";
		        ?> 
		        </h3>
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
			                <p>價錢：{{ $AllInformation[$array_key][$j]['commodityPrice'] }}元</p>
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
			'type'=>'1',
			'order_type'=>'AddTime',
			'this_page'=>'1'
			]) }} " class="home_more_style">more</a></div>
		</div>
	</div>
@endfor