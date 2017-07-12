@extends('layouts.UserMaster')

@section('title','POSTCreditCard')

@section('anyone_head')
@show

@section('content')
	<form role="form"  method="POST" action="{{ $url }}" id="POSTransaction_form">
		<div class="form-group">
			<!--data-->
			<div class="form-group">
			<label>data</label>
			<input class="form-control" type="text" name="data" value="{{ $data }}">
			</div>
			<!--MAC-->
			<div class="form-group">
			<label>mac</label>
			<input class="form-control"  type="text" name="mac" value = "{{ $mac }}">
			</div>
			<!--MAC-->
			<div class="form-group">
			<label>ksn</label>
			<input class="form-control"  type="text" name="ksn" value = "{{ $ksn }}">
			</div>
			<button type='submit'>送出</button>
		</div>
	</form>

	{{-- <script type="text/javascript">
		$(document).ready(function() {
			$('#POSTransaction_form').submit();
		});
	</script> --}}
@stop