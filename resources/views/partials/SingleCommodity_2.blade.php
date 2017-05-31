@inject('MCC', 'App\MemberCommodity\MemberCommodityCount')
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
        <p style="display: none;" id="last_amount" data_Amount="1">
        <p class="commoditypage_media_text" id="groupbuy_price" data-proupbuyPrice ="{{ $AllInformation['GroupbuyPrice'] }}">會員價格：{{ $AllInformation['GroupbuyPrice'] }}元</p>
        <p class="commoditypage_media_text" id="groupbuy_count" data-groupbuyCount = "{{ $MCC->MemberGroupbuyCount($AllInformation['ID'],'groupbuy') }}">目前購買數量：{{ $MCC->MemberGroupbuyCount($AllInformation['ID'],'groupbuy') }}</p>
        <p class="commoditypage_media_text" id="now_groupbuy_price" >團購目前價格：{{ $MCC->MemberGroupbuyNowPrice($AllInformation['ID'],'groupbuy') }}元</p>
        <div class="row">
            <div class="col-xs-2">
                <p class="commoditypage_media_text">數量</p>
            </div>
            <div class="col-xs-10">
                <form>
                    <select class="groupbuy_amount">
                    <?php $MAX = 99 ?>
                    @for($i=1; $i<= $MAX; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                    </select>
                </form>
            </div>
        </div>
        <p class="commoditypage_media_text">運費：{{ $AllInformation['freight'] }}</p>
        <p class="commoditypage_media_text">滿{{ $AllInformation['Freefreight'] }}免運費</p>
        @if($AllInformation['OffTime']!=null)
            <p class="commoditypage_media_text">
            下架時間：
            <?php 
                $time = preg_split("/ /",$AllInformation['OffTime']);
                echo $time[0];
            ?>
            </p>
        @else
            <p class="commoditypage_media_text">下架時間未定</p>
        @endif
        
        <p class="commoditypage_media_text Conditions" data-Amount="0" data-price="{{ $AllInformation['GroupbuyPrice'] }}" style="display: none;"></p>
        @if(isset($AllInformation['GroupbuyAmountA']))
            <p class="commoditypage_media_text Conditions" data-Amount="{{ $AllInformation['GroupbuyAmountA'] }}" data-price="{{ $AllInformation['GroupbuyPriceA'] }}">
                優惠價格(一) 數量滿{{ $AllInformation['GroupbuyAmountA'] }} 價格為{{ $AllInformation['GroupbuyPriceA'] }}
            </p>
        @endif
        @if(isset($AllInformation['GroupbuyAmountB']))
            <p class="commoditypage_media_text Conditions" data-Amount="{{ $AllInformation['GroupbuyAmountB'] }}" data-price="{{ $AllInformation['GroupbuyPriceB'] }}">
                優惠價格(二) 數量滿{{ $AllInformation['GroupbuyAmountB'] }} 價格為{{ $AllInformation['GroupbuyPriceB'] }}
            </p>
        @endif
        @if(isset($AllInformation['GroupbuyAmountC']))
            <p class="commoditypage_media_text Conditions" data-Amount="{{ $AllInformation['GroupbuyAmountC'] }}" data-price="{{ $AllInformation['GroupbuyPriceC'] }}">
                優惠價格(三) 數量滿{{ $AllInformation['GroupbuyAmountC'] }} 價格為{{ $AllInformation['GroupbuyPriceC'] }}
            </p>
        @endif
        @if(isset($AllInformation['GroupbuyAmountD']))
            <p class="commoditypage_media_text Conditions" data-Amount="{{ $AllInformation['GroupbuyAmountD'] }}" data-price="{{ $AllInformation['GroupbuyPriceD'] }}">
                優惠價格(四) 數量滿{{ $AllInformation['GroupbuyAmountD'] }} 價格為{{ $AllInformation['GroupbuyPriceD'] }}
            </p>
        @endif
        <!-- <a href="{{-- route('addShoppingCar',['ID'=>$AllInformation['ID'],'commodityClass'=>'groupbuy','commodityArea'=>'Collection']) --}}" class="btn btn-primary commoditypage_media_btn addCollectioin">加入收藏</a> -->
        <a href="{{ route('addShoppingCar',['ID'=>$AllInformation['ID'],'commodityClass'=>'groupbuy','commodityArea'=>'Groupbuy']) }}" class="btn btn-primary commoditypage_media_btn addShoppingCar" style="float: right; margin-left: 20px;">加入購物車</a>
        <a href="{{ route('goGroupbuyCheckout',['ID'=>$AllInformation['ID'],'commodityClass'=>'groupbuy','commodityArea'=>'Groupbuy']) }}" class="btn btn-primary goGroupbuyCheckout" style="float: right; margin-left: 20px;">前往結帳</a>
    </div>
</div>

@if(count($message_text))
    @include('partials.GroupbuyCommodityMessage')
@endif


<script type="text/javascript">
    var url_addcollection = $('.addCollectioin').attr('href');
    var url_addshoppingcar = $('.addShoppingCar').attr('href');
    var url_goGroupbuyCheckout = $('.goGroupbuyCheckout').attr('href');

    var groupbuy_count = $('#groupbuy_count').attr('data-groupbuyCount');
    var finally_price = $('#groupbuy_price').attr('data-proupbuyPrice');
    var conditions_amount_array = new Array();
    var conditions_price_array = new Array();
    var amount = 1;
    var price =0;
    var totalAmount =0;
    init();

    $(".groupbuy_amount").change(function(event) {
        amount  = $(this).val();
        totalAmount = parseInt(groupbuy_count)+parseInt(amount);
		console.log(totalAmount);
        for(var i= conditions_amount_array.length-1; i>=0; i--){
            if(totalAmount >= conditions_amount_array[i]){
                finally_price = conditions_price_array[i];
                break;
            }
        }

        $('#now_groupbuy_price').text("目前價格："+finally_price+"元");
        $('.addCollectioin').attr('href',url_addcollection+'/'+amount);
        $('.addShoppingCar').attr('href',url_addshoppingcar+'/'+amount);
        $('.goGroupbuyCheckout').attr('href',url_goGroupbuyCheckout+'/'+amount);

    });

    function init(){
        $('.Conditions').each(function(){
            Amount = $(this).attr('data-Amount');
            price = $(this).attr('data-price');

            conditions_amount_array[conditions_amount_array.length] = Amount;
            conditions_price_array[conditions_price_array.length] = price;
        });
    }
    

</script>
             