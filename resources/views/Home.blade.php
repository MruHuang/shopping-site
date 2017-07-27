@extends('layouts.UserMaster')

@section('title','Home')
	
@section('anyone_head')
	{{--@include('partials')--}}
@show

@section('content')
	 <div class='panel panel-success' style='margin:15px;'>
		<div class='panel-heading'><h4>最新消息</h3></div>
		<div class='panel-body' style='overflow-y:auto; height: 150px;'>
			{{ $LatestNews }}
		</div>
	</div> 
	@include('partials.commodity_area_3')
	<div class='alert alert-info col-xs-12'>
		ATM匯款方式<br/>銀行代號：808<br/>存戶帳號：0129-940-053850<br/>玉山銀行雙和分行 <br/>
		戶名：藍星購物商行趙淑芬
	<div>
@stop

{{--@if(count($message_text))--}}
{{--@endif--}}

@section('js_area')
@show