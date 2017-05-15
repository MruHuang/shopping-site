
@extends('layouts.UserMaster')

@section('title','CollectionArea')

@section('anyone_head')
	@include('partials.head.CollectionAreaHead')
@show

@section('menu')
	@include('partials.Menu')
@stop

@section('content')

<div class="panel panel-default CollectionArea_panel" >
    <div class="panel-heading">
        <h3 class="panel-title">收藏區</h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered CollectionArea_table">
            <tr>
                <th></th>
                <th>商品名稱</th>
                <th>商品分類</th>
                <th>價格</th>
                <th>&nbsp;</th>
            </tr>
            <?php $MAX= count($AllInformation); ?>
            @for($i=0;$i<$MAX;$i++)
            <tr>
                <td class="text-center">{{($i+1)}}</td>
                <td><a href="{{ route('Commoditypage',['type'=>$AllInformation[$i]['user_class'],'ID'=>$AllInformation[$i]['ID']]) }}">{{ $AllInformation[$i]['Name'] }}</a></td>
                <td><?php 
                        if($AllInformation[$i]['user_class']=='commodity') echo "一般區";
                        else if($AllInformation[$i]['user_class']=='timelimit') echo "限時限量區";
                        else if($AllInformation[$i]['user_class']=='groupbuy') echo "團購區";
                    ?></td>
                <td>{{ $AllInformation[$i]['price'] }}</td>
                <td class="text-center">
                    <a href=" {{ route('DelMemberCommodity',['ID'=>$AllInformation[$i]['user_ID'],'$speciestype'=>'Collection' ]) }} " class="btn btn-primary">刪除</a>
                </td>
            </tr>
            @endfor
        </table>
    </div>
    {{--@include('partials.pagination')--}}
</div>

@stop

@if(count($message_text))
    @include('partials.Message')
@endif

@section('js_area')
    <script type="text/javascript" src=" {{ asset('js/Message.js') }} "></script>
@show