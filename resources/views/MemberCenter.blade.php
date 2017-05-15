
@extends('layouts.UserMaster')

@section('title','CollectionArea')

@section('anyone_head')
	{{--@include('partials.head.')--}}
@show

@section('menu')
	@include('partials.Menu')
@stop

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
	        <h3 class="panel-title">會員中心</h3>
	    </div>
        <div class="panel-body" style="padding: 10px 15px;">
            <form role="form" method="POST" action=" {{ route('MemberDataUpate') }} ">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="register_form_style" >
                        <h3>會員中心</h3>
                        <label>會員名稱</label>
                        <input type="text" class="form-control" name="member_name" value="{{ $user_Data['Name'] }}" readonly>
                        <label>會員帳號</label>
                        <input type="text" class="form-control" name="member_account" value="{{ $user_Data['Account'] }}" readonly>
                        <label>舊密碼(包含臨時密碼)</label>
                        <input type="password" class="form-control" name="member_password" placeholder="輸入舊密碼" >
                        <label>新密碼</label>
                        <input type="password" class="form-control" name="new_member_password" placeholder="輸入新密碼" >
                        <label>再次輸入新密碼</label>
                        <input type="password" class="form-control" name="new_member_password_again" placeholder="再次輸入新密碼">
                        <label>手機(Ex:0912345678)</label>
                        <input type="text" class="form-control" name="member_phone" placeholder="輸入手機" value="{{ $user_Data['Phone'] }}" maxlength="10" >
                        <label>通訊地址</label>
                        <input type="text" class="form-control" name="member_add" placeholder="輸入通訊地址" value="{{ $user_Data['Add'] }}">
                        <label>信箱</label>
                        <input type="text" class="form-control" name="member_Email" placeholder="輸入信箱" value="{{ $user_Data['Email'] }}">
                        <label>生日</label>
                        <input type="date" class="form-control" name="member_birthday" placeholder="預設生日" value="{{ $user_Data['Birthday'] }}">
                        <label>Line-id</label>
                        <input type="text" class="form-control" name="member_lineid" placeholder="預設Line-id" value="{{ $user_Data['Lineid'] }}">
                        <div class="text-right" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-primary register_button_style">更改基本資料</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@stop
@if(count($errors->all())||count($message_text))
    @section('message')
        @include('partials.Message')
    @show
@endif

@section('js_area')
    <script type="text/javascript" src=" {{ asset('js/Message.js') }} "></script>
@show