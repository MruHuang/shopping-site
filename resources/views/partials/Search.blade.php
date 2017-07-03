<nav class="navbar navbar-default navbar_sytle" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#" style="padding: 0px;"><img src="{{ asset('img/BlueStarSC.png') }}" style="width: 90px;"></a>
             <!-- <a class="navbar-brand search_nav_title_style" style="color: #fff; font-size: 50px; margin-top: 10px;" href="{{-- route('HomeGet') --}}">藍星購物</a> -->
        </div>
        <div class="navbar-left"><a class="navbar-brand search_nav_title_style" style="color: #337ab7; font-size: 50px; margin-top: 10px;" href="{{ route('HomeGet') }}">藍星購物</a></div>
        <div class="search_nav_text_style">
            <a href="{{ route('LogOut') }}" class="navbar-link navbar-text navbar-right"  style="color: #337ab7; font-size: 30px; margin-right: 25px;">登出</a>
            <p class="navbar-text navbar-right"><a href="{{ route('MemberCenter') }}" class="navbar-link" style="color: #337ab7; font-size: 30px; margin-right: 10px;">會員中心</a></p>
            <a href="{{ route('ShoppingCar',['speciestype'=>'Car']) }}" class="navbar-link navbar-text navbar-right" style="color: #337ab7; font-size: 30px; margin-right: 10px;">購物車</a>
            <a href="{{ route('HomeGet') }}" class="navbar-link navbar-text navbar-right" style="color: #337ab7; font-size: 30px; margin-right: 0px;">首頁</a>
             
             
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="search_search_area_sytle row">
            <div class="col-xs-9 col-xs-offset-1">
                <input type="text" id="search_key"  class="search_search_sytle form-control " placeholder="搜尋">
            </div>
            <div class="col-xs-2">
                <a href="{{ route('Search',[
                'StartNumber'=>'1',
                'EndNumber'=>'10',
                'this_page'=>'1'
                ]) }}" id="search_btn" class="btn btn-primary" >搜尋</a>
                <!--<a href="" id  style="display: none;"></a>-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var url_addcollection = $('#search_btn').attr('href');
        $('#search_key').change(function(event) {
            var search_key =  $('#search_key').val();
            $('#search_btn').attr('href',url_addcollection+'/'+search_key);
        });
    });
    
</script>