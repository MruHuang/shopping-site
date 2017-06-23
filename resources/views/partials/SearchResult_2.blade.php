@inject('MCC', 'App\MemberCommodity\MemberCommodityCount')
<div class="panel panel-success">
	<div class="panel-heading">
	    <h3 class="panel-title">團購區</h3>
	</div>
	<div class="panel-body">
	    <div class="media">
	        <a class="media-left search_commodity_img_sytle" style="width: 200px;" href="{{ route('Commoditypage',['type'=>'groupbuy','ID'=>$AllInformation['data'][$i]['groupbuyID']]) }}">
	            <img src="/{{ $AllInformation['data'][$i]['commodityPhotoA'] }}" alt="{{ $AllInformation['data'][$i]['commodityName'] }}" width="100%">
	        </a>
		    <div class="media-body">
		    	<a href="{{ route('Commoditypage',['type'=>'groupbuy','ID'=>$AllInformation['data'][$i]['groupbuyID']]) }}">
				    <h3 class="media-heading">{{ $AllInformation['data'][$i]['commodityName'] }}</h3>
				    <p class="search_media_text">價格：{{ $AllInformation['data'][$i]['groupbuyPrice'] }}</p>
				    <p class="search_media_text">目前被購買數量：{{ $MCC->MemberCommodityCount($AllInformation['data'][$i]['groupbuyID'],'groupbuy') }}</p>
			    </a>
		    </div>
	    </div>
	</div>
</div>
                    	