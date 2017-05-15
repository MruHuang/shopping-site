@extends('layouts.Master')

@section('title','Login')

@section('anyone_head')
	@include('partials.head.LoginHead')
@show

@section('content')
<div class="panel panel-primary login_form_style">
  <div class="panel-heading ">
    <h3 class="panel-title" style="color: #fff;"><a href="{{ route('Login') }}"><h1>藍星購物</h1></a></h3>
  </div>
  <div class="panel-body">
    <form role="form" method="POST" style="font-size: 20px;" action=" {{ route('LoginPost') }}  ">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
	    <label>帳號</label>
	    <input type="text" class="form-control" style="height: 45px; font-size: 18px;" name="member_account" placeholder="輸入帳號">
	    <div style="margin-top: 20px;"/>
	    <label>密碼</label>
	    <input type="password" class="form-control" style="height: 45px; font-size: 18px;" name="member_password" placeholder="輸入密碼">
	    <div class="row">
	        <div class="col-md-4" style="margin-top: 15px;">
	       	    <a href=" {{ route('Register') }} " style="height: 50px; padding-top: 10px;" class="btn btn-danger login_button_sytle" >註冊</a>
	        </div>
	        <div class="col-md-4" style="margin-top: 15px;">
	            <a href=" {{ route('ForgetPwd') }} " style="height: 50px; padding-top: 10px;" class="btn btn-primary login_button_sytle" >忘記密碼</a>
	        </div>
	        <div class="col-md-4" style="margin-top: 15px;">
	            <button style="height: 50px;" class="btn btn-primary login_button_sytle" type="submit">登　入</button>
	        </div>
	    </div>
	</form>
  </div>
</div>

@if($isRegistered)
<script type="text/javascript">
	ClearCookies();
    console.log('clean');
</script>
@endif


@stop

@if(count($message_text))
	@section('message')
		@include('partials.Message')
	@show
@endif


@section('js_area')
	<script type="text/javascript" src=" {{ asset('js/Message.js') }} "></script>
@show

