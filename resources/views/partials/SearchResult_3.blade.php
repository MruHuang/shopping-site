<div class="panel panel-danger">
	<div class="panel-heading">
	    <h3 class="panel-title">限時限量區</h3>
	</div>
	<div class="panel-body">
	    <div class="media">
	        <a class="media-left search_commodity_img_sytle" style="width: 200px;" href="{{ route('Commoditypage',['type'=>'timelimit','ID'=>$AllInformation['data'][$i]['limitedID']]) }}">
	            <img src="/{{ $AllInformation['data'][$i]['commodityPhotoA'] }}" alt="{{ $AllInformation['data'][$i]['commodityName'] }}" width="100%">
	        </a>
		    <div class="media-body">
			    <a href="{{ route('Commoditypage',['type'=>'timelimit','ID'=>$AllInformation['data'][$i]['limitedID']]) }}">
				    <h3 class="media-heading">{{ $AllInformation['data'][$i]['commodityName'] }}</h3>
				    <p class="search_media_text">價格：{{ $AllInformation['data'][$i]['limitedPrice'] }}</p>
				    <p class="search_media_text">數量：{{ $AllInformation['data'][$i]['limitedAmount'] }}</p>

				    <p class="search_media_text">下架時間：
				    	<?php 
                			$time = preg_split("/ /",$AllInformation['data'][$i]['offTime']);
                			echo $time[0];
            			?>
            		</p>
			    </a>
		    </div>
	    </div>
	</div>
</div>
                    	