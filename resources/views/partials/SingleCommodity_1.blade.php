<div class="media">
    <div class="media-left media-middle" >
         <a class="display_img"><img src="/{{ $AllInformation['commodityPhotoA'] }}" alt="{{ $AllInformation['commodityName'] }}" ></a>
    </div>
    <div class="media-body">
        <div class="panel panel-default">
            <div class="panel-body">
                <h3 class="media-heading commoditypage_media_title">{{ $AllInformation['commodityName'] }}</h3>
            </div>
        </div>
        <p class="commoditypage_media_text">市場價格：{{ $AllInformation['originalPrice'] }}元</p>
        <p class="commoditypage_media_text">會員價格：{{ $AllInformation['commodityPrice'] }}元</p>
        <p class="commoditypage_media_text" id="last_amount" data_Amount="{{ $AllInformation['commodityAmount'] }}">剩餘數量：{{ $AllInformation['commodityAmount'] }}</p>
        <div class="row">
            <div class="col-xs-2">
                <p class="commoditypage_media_text">數量</p>
            </div>
            <div class="col-xs-10">
                <form>
                    <select class=" amount">
                    @for($i=1; $i<= $AllInformation['commodityAmount']; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                    </select>
                </form>
            </div>
        </div>
        <p class="commoditypage_media_text">運費：{{ $AllInformation['freight'] }}</p>
        <p class="commoditypage_media_text">滿{{ $AllInformation['Freefreight'] }}免運費</p>
        <!-- <a href="{{-- route('addShoppingCar',['ID'=>$AllInformation['ID'],'commodityClass'=>'commodity','commodityArea'=>'Collection']) --}}" class="btn btn-primary commoditypage_media_btn addCollectioin">加入收藏</a> -->
        <a href="{{ route('addShoppingCar',['ID'=>$AllInformation['ID'],'commodityClass'=>'commodity','commodityArea'=>'Car']) }}" class="btn btn-primary commoditypage_media_btn addShoppingCar" style="float: right; margin-left: 20px;">加入購物車</a>
        <a href="{{ route('goCheckout',['ID'=>$AllInformation['ID'],'commodityClass'=>'commodity','commodityArea'=>'Car']) }}" class="btn btn-primary goCheckout" style="float: right; margin-left: 20px;">前往結帳</a>
    </div>
</div>

@if(count($message_text))
    @include('partials.CommodityMessage')
@endif

             