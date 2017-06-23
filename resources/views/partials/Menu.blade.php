@inject('lg', 'App\Login\Login')
<div class="container"  style="margin-bottom: 30px;">
    <div class="row">
        <!--<div class="col-xs-2">
            <a href="{{-- route('ShoppingCar',['speciestype'=>'Collection']) --}}" class="btn btn-primary menu_btn" ">收藏區</a>
        </div>-->
        <div class="col-xs-2 col-xs-offset-1">
            <a href="{{ route('ShoppingCar',['speciestype'=>'Car']) }}" class="btn btn-primary menu_btn">購物車</a>
        </div>
        <div class="col-xs-2">
            <a href="{{ route('ShoppingCar',['speciestype'=>'Groupbuy']) }}" class="btn btn-primary menu_btn">團購購物車</a>
        </div>
        <div class="col-xs-2">
            <a href="{{ route('TrackOrder',['state'=>'Unpaid']) }}" class ="btn btn-primary menu_btn">追蹤訂單</a>
        </div>
        <div class="col-xs-2">
            <a href="{{ route('MemberCenter') }}" class="btn btn-primary menu_btn">會員中心</a>
        </div>
        <div class="col-xs-2">
            <a class="btn btn-primary menu_btn" disabled>紅利點數：{{ $lg->LoginIntegral() }}</a>
        </div>
    </div>
</div>