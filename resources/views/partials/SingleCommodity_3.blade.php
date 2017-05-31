
<div class="media">
    <div class="media-left media-middle">
        <a class="display_img"><img src="/{{ $AllInformation['commodityPhotoA'] }}" alt="{{ $AllInformation['commodityName'] }}" ></a>
    </div>
    <div class="media-body">
        <div class="panel panel-default">
            <div class="panel-body">
                <h3 class="media-heading commoditypage_media_title">{{ $AllInformation['commodityName'] }}</h3>
            </div>
        </div>
        <p class="commoditypage_media_text">市場價格：{{ $AllInformation['originalPrice'] }}元</p>
        <p class="commoditypage_media_text">特惠價格：{{ $AllInformation['LimitedPrice'] }}元</p>
        <p class="commoditypage_media_text" id="last_amount" data_Amount="{{ $AllInformation['LimitedAmount'] }}">限量數量：{{ $AllInformation['LimitedAmount'] }}</p>
        <p class="commoditypage_media_text">特惠期間至：
        <?php 
            $time = preg_split("/ /",$AllInformation['OffTime']);
            echo $time[0];
        ?></p>
        <div class="row">
            <div class="col-xs-2">
                <p class="commoditypage_media_text">數量</p>
            </div>
            <div class="col-xs-10">
                <form>
                    <select class=" amount">
                    @for($i=1; $i<= $AllInformation['LimitedAmount']; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                    </select>
                </form>
            </div>
        </div>
        <p class="commoditypage_media_text">運費：{{ $AllInformation['freight'] }}</p>
        <p class="commoditypage_media_text">滿{{ $AllInformation['Freefreight'] }}免運費</p>
        <!-- <a href="{{-- route('addShoppingCar',['ID'=>$AllInformation['ID'],'commodityClass'=>'timelimit','commodityArea'=>'Collection']) --}}" class="btn btn-primary commoditypage_media_btn addCollectioin">加入收藏</a> -->
        <a href="{{ route('addShoppingCar',['ID'=>$AllInformation['ID'],'commodityClass'=>'timelimit','commodityArea'=>'Car']) }}" class="btn btn-primary commoditypage_media_btn addShoppingCar" style="float: right; margin-left: 20px;">加入購物車</a>
        <a href="{{ route('goCheckout',['ID'=>$AllInformation['ID'],'commodityClass'=>'timelimit','commodityArea'=>'Car']) }}" class="btn btn-primary goCheckout" style="float: right; margin-left: 20px;">前往結帳</a>
    </div>
</div>

@if(count($message_text))
    @include('partials.CommodityMessage')
@endif


             