<div class="panel panel-primary">
	<div class="panel-heading">
	    <h3 class="panel-title">一般區</h3>
	</div>
	<div class="panel-body">
	
	    <div class="media">
	        <a class="media-left search_commodity_img_sytle" style="width: 200px;" href="{{ route('Commoditypage',['type'=>'commodity','ID'=>$AllInformation['data'][$i]['commodityID']]) }}">
	            <img src="/{{ $AllInformation['data'][$i]['commodityPhotoA'] }}" alt="{{ $AllInformation['data'][$i]['commodityName'] }}" width="100%">
	        </a>
		    <div class="media-body">
			    <a href="{{ route('Commoditypage',['type'=>'commodity','ID'=>$AllInformation['data'][$i]['commodityID']]) }}">
				    <h3 class="media-heading">{{ $AllInformation['data'][$i]['commodityName'] }}</h3>
				    <p class="search_media_text">價格：{{ $AllInformation['data'][$i]['commodityPrice'] }}</p>
				    <p class="search_media_text">數量：{{ $AllInformation['data'][$i]['commodityAmount'] }}</p>
				</a>
		    </div>
	    </div>
	</div>
</div>

                    	