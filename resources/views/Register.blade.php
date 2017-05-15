@extends('layouts.Master')

@section('title','Register')

@section('anyone_head')
	@include('partials.head.RegisterHead')
@stop

@section('content')
<div class="panel panel-primary register_form_style">
  <div class="panel-heading ">
    <h3 class="panel-title" style="color: #fff;"><a href="{{ route('Login',['isRegistered'=>'true','message_text'=>null]) }}"><h1>藍星購物</h1></a></h3>
  </div>
  <div class="panel-body">
    <form role="form" method="POST" action=" {{ route('RegisterPost') }}" id="register_form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h3>會員註冊</h3>
            <label>會員姓名</label>
            <input type="text" class="form-control" id ="member_name" name="member_name" placeholder="輸入姓名">
            <label>會員帳號</label>
            <input type="text" class="form-control" id ="member_account" name="member_account"  placeholder="輸入帳號">
            <label>密碼</label>
            <input type="password" class="form-control" id ="member_password" name="member_password" placeholder="輸入密碼">
            <label>再次輸入密碼</label>
            <input type="password" class="form-control" id ="member_password_again" name="member_password_again" placeholder="再次輸入密碼">
            <label>手機(Ex:0912345678)</label>
            <input type="text" class="form-control" id ="member_phone" name="member_phone" placeholder="輸入手機" maxlength="10" minlength="10">
            <label>通訊地址</label>
            <!-- <input type="text" class="form-control" name="member_add"> -->
            <br>
            <input id="address" type="text" id ="member_add" value="台北市中山區" class="twaddress form-control" name="member_add" placeholder="輸入通訊地址"/>   
            <br>
            <label>信箱</label>
            <input type="text" class="form-control" id ="member_Email" name="member_Email" placeholder="輸入信箱 Ex：XXXX@XXXX.com">
            <label>生日</label>
            <input type="date" class="form-control" id ="member_birthday" name="member_birthday" placeholder="輸入生日 Ex：1990-01-01" >
            <label>Line-id</label>
            <input type="text" class="form-control" id ="member_lineid" name="member_lineid" placeholder="輸入Line-id">
            <label>推薦人(限會員)</label>
            <input type="text" class="form-control" id ="recommender_name" name="recommender_name" placeholder="輸入推薦人">
            <label>推薦人手機(Ex:0912345678)</label>
            <input type="text" class="form-control" id ="recommender_phone" name="recommender_phone" placeholder="輸入推薦人手機" maxlength="10">
            
            <div class="panel panel-primary resgister_panel_sytle">
                <div class="panel-heading">
                    <h3 class="panel-title">同意書</h3>
                </div>
                <div class="panel-body">
                    <p>同意書內容</p>
                    <label>
                        <input type="checkbox" name="agree" >同意
                    </label>
                </div>
            </div>
            <a class="btn btn-primary register_button_style" id="submit_btn" >送出</a>
    </form>
  </div>
</div>

@stop

@if(count($errors->all())||count($message_text))
	@section('message')
		@include('partials.Message')
	@stop
@endif

@section('js_area')
    <script type="text/javascript" src=" {{ asset('js/Cookies.js') }} "></script>
	<script type="text/javascript" src=" {{ asset('js/Message.js') }} "></script>
    <script type="text/javascript" src=" {{ asset('js/Address.js') }} "></script>
    <script type="text/javascript">
        $(document).ready(function() {
                
            getHtmlCookies(); 

            $(".twaddress").twaddress();
            
            $("#submit_btn").click(function(event) {
                putCookies();
                $('#register_form').submit();
            });

            
        });
        
    </script>

@stop
