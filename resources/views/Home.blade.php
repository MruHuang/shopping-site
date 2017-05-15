@extends('layouts.UserMaster')

@section('title','Home')
	
@section('anyone_head')
	{{--@include('partials')--}}
@show

@section('content')
	@include('partials.commodity_area_3')
	
@stop

{{--@if(count($message_text))--}}
{{--@endif--}}

@section('js_area')
@show