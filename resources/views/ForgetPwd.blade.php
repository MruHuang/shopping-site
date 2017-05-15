@extends('layouts.Master')

@section('title','ForgetPwd')

@section('anyone_head')
	@include('partials.head.ForgetPwdHead')
@show

@section('content')

<div class="panel panel-primary forgetPwd_form_style">
  <div class="panel-heading ">
    <h3 class="panel-title" style="color: #fff;"><a href="{{ route('Login') }}"><h1>藍星購物</h1></a></h3>
  </div>
  <div class="panel-body">
    <form role="form" method="POST" style="font-size: 20px;" action=" {{ route('ForgetPwdPost') }}  ">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <label>會員帳號</label>
        <input type="text" class="form-control" style="height: 45px; font-size: 18px;" name="member_account" placeholder="輸入會員帳號">
        <div style="margin-top: 20px;"/>
        <label>E-mail</label>
        <input type="text" class="form-control" style="height: 45px; font-size: 18px;" name="member_Email" placeholder="輸入E-mail">
        <div class="panel panel-primary forgetPwd_panel_sytle">
            <div class="panel-heading">
                <h3 class="panel-title">忘記密碼</h3>
            </div>
            <div class="panel-body">
                <p>輸入會員名稱與E-mail後，我們將會寄一組隨機密碼給您，請盡快更改您的密碼</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <a href=" {{ route('Register') }} " style="height: 50px; padding-top: 10px;" class="btn btn-danger forgetPwd_button_sytle" >註冊</a>
            </div>
            <div class="col-xs-4">
                <a href=" {{ route('Login') }} " style="height: 50px; padding-top: 10px;" class="btn btn-primary forgetPwd_button_sytle" >首頁</a>
            </div>
            <div class="col-xs-4">
                <button style="height: 50px;" class="btn btn-primary forgetPwd_button_sytle" type="submit">送 出</button>
            </div>
        </div>
    </form>
  </div>
</div>
    
@stop

@if(count($message_text))
	@section('message')
		@include('partials.Message')
	@show
@endif

@section('js_area')
	<script type="text/javascript" src=" {{ asset('js/Message.js') }} "></script>
@show

<!-- <div class="forgetPwd_form_style">
        <a href="{{-- route('Login',['message_text'=>null]) --}}"><h1>藍星購物</h1></a>
        <form role="form"  method="POST" action=" {{-- Route('ForgetPwdPost') --}} "> 
            <input type="hidden" name="_token" value="{{-- csrf_token() --}}">
            <label>會員名稱</label>
            <input type="text" class="form-control" name="member_account" placeholder="輸入會員名稱">
            <label>E-mail</label>
            <input type="text" class="form-control" name="member_Email" placeholder="輸入E-mail">
            <div class="panel panel-primary forgetPwd_panel_sytle">
                <div class="panel-heading">
                    <h3 class="panel-title">忘記密碼</h3>
                </div>
                <div class="panel-body">
                    <p>輸入會員名稱與E-mail後，我們將會寄一組隨機密碼給您，請盡快更改您的密碼</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a href=" {{-- route('Register') --}}" class="btn btn-danger forgetPwd_button_sytle">註冊</a>
                </div>
                <div class="col-xs-4 col-xs-offset-4">
                    <button class="btn btn-primary forgetPwd_button_sytle" type="submit">送出</button>
                </div>
            </div>
        </form>
    </div> -->