@extends('layouts.UserMaster')

@section('title','Subpage')

@section('anyone_head')
	@include('partials.head.SubpageHead')
@show

@section('content')
	<div class="container">
		<div class="panel panel-primary ">
                <div class="panel-heading text-center">
                    <h3 class="panel-title" id="Subpage_data" data-area = "{{ $All['area'] }}" data-type = "{{ $All['this_type'] }}" data-this_page = "{{ $All['this_page'] }}">
                    <?php 
                        if($All['area']=='commodity') echo "一般區";
                        else if($All['area']=='groupbuy') echo "團購區";
                        else if($All['area']=='timelimit') echo "限時限量區";
                    ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <!--移動式分類(幻燈片)-->
                    <div id="carousel-example-generic" class="carousel slide subpage_type_area_sytle" data-ride="carousel">
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                        <?php $commodity_species= count($All['type']);?> 
	                       
	                        	<div class="item active">

	                        	@for($i=0; $i < $commodity_species ; $i++)
                                    @if($i%5 == 0 && $i != 0)
                                </div>
                                <div class="item">
                                    @endif
	                        		@if($i%5 == 0)
	                        			<div class="col-xs-2 col-xs-offset-1">
                                    @else
                                        <div class="col-xs-2">
	                        		@endif
	                        		        <a href=" {{ route('Subpage',[
                                                'array_key'=>$All['area'],
                                                'start'=>'1',
                                                'end'=>'12',
                                                'type'=>$All['type'][$i]['speciseID'],
                                                'order_type'=>'AddTime',
                                                'this_page'=>'1'
                                                ]) }}" class="btn subpage_btn_type_style type_select">{{ $All['type'][$i]['speciseName'] }}</a>
                                        </div>
                                    
	                        	@endfor
	                        	</div>
                    
                        </div>
                        @if($commodity_species>5)
	                        <!-- Controls -->
	                        <a class="subpage_carousel_letf_sytle" href="#carousel-example-generic" role="button" data-slide="prev">
	                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	                            <span class="sr-only">Previous</span>
	                        </a>
	                        <a class="subpage_carousel_right_sytle" href="#carousel-example-generic" role="button" data-slide="next">
	                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	                            <span class="sr-only">Next</span>
	                        </a>
                        @endif
                    </div>
                    <!--商品區-->
                   	<?php $MAX=count($All['Information'])<=12?count($All['Information']):12 ?>
                    @for ($i = 0; $i < $MAX; $i++)
			            <div class="col-xs-3" style="height: 350px">
			                <!--商品-->
			                <a href="{{ route('Commoditypage',[
                            'type'=>$All['area'],
                            'ID'=>$All['Information'][$i]['ID']]) }}">
			                <div class="subpage_commodity_style">
			                    <img src="/{{ $All['Information'][$i]['commodityPhotoA'] }}" width=200px; >
			                    <h4>名稱：{{ $All['Information'][$i]['commodityName'] }}</h4>
                                <p>價錢：{{ $All['Information'][$i]['commodityPrice'] }}</p>
                                <div style="display:none">{{ $All['Information'][$i]['ID'] }}</div>
			                </div>
			                </a>
			                <!--商品-->
			            </div>
			        @endfor
                </div>
                <!-- 分頁 -->
                {{--@include('partials.pagination')--}}
            <div class="text-center">
                    <nav>
                        <ul class="pagination">
                        <?php $pageInfo =  $All['count_page']%12!=0 ? (int)($All['count_page']/12)+1:(int)($All['count_page']/12);
                        $PageMAX=$pageInfo<=5?$pageInfo:5 ?>
                        <li><a id="first_page" href="{{ route('Subpage',[
                                                'array_key'=>$All['area'],
                                                'start'=>1,
                                                'end'=>12,
                                                'type'=>$All['this_type'],
                                                'order_type'=>'AddTime',
                                                'this_page'=>1
                                                ]) }}" data-page='{{ $pageInfo }}'>
                        	<span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span>
                        </a></li>
                        @for( $i=1 ; $i <= $PageMAX ; $i++)
                        	@if($i==1)
                        		<li class="active"><a href="{{ route('Subpage',[
                                                'array_key'=>$All['area'],
                                                'start'=>(($i-1)*12+1),
                                                'end'=>($i*12),
                                                'type'=>$All['this_type'],
                                                'order_type'=>'AddTime',
                                                'this_page'=>$i
                                                ]) }}" class="page" data-page='{{ $i }}'>{{ $i }}</a></li>
                        	@endif
                        	@if($i>1)
                        		<li><a class="page" href="{{ route('Subpage',[
                                                'array_key'=>$All['area'],
                                                'start'=>(($i-1)*12+1),
                                                'end'=>($i*12),
                                                'type'=>$All['this_type'],
                                                'order_type'=>'AddTime',
                                                'this_page'=>$i
                                                ]) }}" data-page='{{ $i }}'>{{ $i }}</a></li>
                        	@endif
                        @endfor
                        <li><a id="last_page" href="{{ route('Subpage',[
                                                'array_key'=>$All['area'],
                                                'start'=>(($pageInfo-1)*12+1),
                                                'end'=>($pageInfo*12),
                                                'type'=>$All['this_type'],
                                                'order_type'=>'AddTime',
                                                'this_page'=>$pageInfo
                                                ]) }}"  data-page='{{ $pageInfo }}'>
                        	<span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span>
                        </a></li>
                        </ul>
                        <div>每頁12筆，第{{ $All['this_page'] }}/{{ (int)($All['count_page']/12) }}頁</div>
                    </nav> 
            	</div>
        </div>
	</div>
    <script type="text/javascript">
    'use strict';
    var pagination_page = 2;
    var pagination_MaxPage = 5;

    $(document).ready(function() {
        var last_page = $('#last_page').attr('data-page');
        var type = $('#Subpage_data').attr('data-type');
        var area = $('#Subpage_data').attr('data-area');
        var this_page = $('#Subpage_data').attr('data-this_page');
        var order_type = 'AddTime';
        checkPagination(this_page, last_page, area, type, order_type);
    });

    function checkPagination(this_page, last_page, area, type, order_type){
        if (last_page < 5) {
                SmallPagination(this_page, last_page, area, type, order_type);
        } else if (last_page > 5) {
                LargePagination(this_page, last_page, area, type, order_type);
        }
    }

    function SmallPagination(this_page, last_page, area, type, order_type) {
        for (var i = 0; i <= last_page; i++) {
            $("ul.pagination li:eq(" + i + ")").attr('class', '');
        }
        $("ul.pagination li:eq(" + this_page + ")").attr('class', 'active');
    }

    function LargePagination(this_page, last_page, area, type, order_type) {
        if (this_page > pagination_page && this_page <= (last_page - pagination_page)) {
            for (var i = 1; i <= pagination_MaxPage; i++) {
                var page = (parseInt(this_page) + i - 3);
                $("ul.pagination li:eq(" + i + ") a").attr('data-page', (page));
                $("ul.pagination li:eq(" + i + ") a").html(page);
                $("ul.pagination li:eq(" + i + ") a").attr('href', '/Subpage/'+area+'/'+(((page)-1)*12+1)+'/'+((page)*12)+'/'+type+'/'+order_type+'/'+(page));
                $("ul.pagination li:eq(" + i + ")").attr('class', '');
                if (page == this_page) {
                    $("ul.pagination li:eq(" + i + ")").attr('class', 'active');
                }
            }
        } else {
            var page_Min = (this_page - pagination_page) > 0 ? (last_page - pagination_MaxPage + 1) : 　1;
            for (var i = 1; i <= pagination_MaxPage; i++) {
                var page = (page_Min + i - 1);
                $("ul.pagination li:eq(" + i + ") a").attr('data-page', page);
                $("ul.pagination li:eq(" + i + ") a").html(page);
                $("ul.pagination li:eq(" + i + ")").attr('class', '');
                $("ul.pagination li:eq(" + i + ") a").attr('href', '/Subpage/'+area+'/'+(((page)-1)*12+1)+'/'+((page)*12)+'/'+type+'/'+order_type+'/'+page);
                if (page == this_page) {
                    $("ul.pagination li:eq(" + i + ")").attr('class', 'active');
                }
            }
        }
    }

    </script>
@stop

{{--@if(count($message_text))--}}
{{--@endif--}}

@section('js_area')
		
@show
