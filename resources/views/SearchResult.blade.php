@extends('layouts.UserMaster')

@section('title','Search')

@section('anyone_head')
	@include('partials.head.SearchHead')
@show

@section('content')
        @if(count($AllInformation['data'])!=0)
			<div class="panel panel-default searchpage_panel_sytle">
                <div class="panel-body">
                <?php $MAX=count($AllInformation['data'])<=10?count($AllInformation['data']):10 ?>
                	@for ($i = 0; $i < $MAX; $i++)
                        @if(isset($AllInformation['data'][$i]['groupbuyID']))
                            @include('partials.SearchResult_2')
                        @elseif(isset($AllInformation['data'][$i]['limitedID']))
                            @include('partials.SearchResult_3')
                        @else(isset($AllInformation['data'][$i]['limitedID']))
                            @include('partials.SearchResult_1')
                        @endif
                	@endfor
                </div>
                <div class="text-center">
                    <div style="display: none;" id="Search_Result_data" data-text_Key="{{ $AllInformation['1'] }}" data-page = "{{ $AllInformation['0'] }}" data-this_page = "{{ $AllInformation['count'] }}"></div>
                    <nav>
                        <ul class="pagination">
                        <?php $pageInfo =  $AllInformation['count']%10!=0 ? (int)($AllInformation['count']/10)+1:(int)($AllInformation['count']/10);
                        $PageMAX = $pageInfo <= 5 ? $pageInfo : 5 ?>
                        <li><a id="first_page" href="{{ route('Search',[
                            'StartNumber'=>'1',
                            'EndNumber'=>'10',
                            'this_page'=>'1',
                            'search_text'=>$AllInformation['1']
                            ]) }}" data-page='{{ $pageInfo }}'>
                            <span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span>
                        </a></li>
                        @for( $i=1 ; $i <= $PageMAX ; $i++)
                        	@if($i==1)
                        		<li class="active"><a href="{{ route('Search',[
                                                'StartNumber'=>(($i-1)*10+1),
                                                'EndNumber'=>($i*10),
                                                'this_page'=>$i,
                                                'search_text'=>$AllInformation['1']
                                                ]) }}" class="page" data-page='{{ $i }}'>{{ $i }}</a></li>
                        	@endif
                        	@if($i>1)
                        		<li><a class="page" href="{{ route('Search',[
                                                'StartNumber'=>(($i-1)*10+1),
                                                'EndNumber'=>($i*10),
                                                'this_page'=>$i,
                                                'search_text'=>$AllInformation['1']
                                                ]) }}" data-page='{{ $i }}'>{{ $i }}</a></li>
                        	@endif
                        @endfor
                        <li><a id="last_page" href="{{ route('Search',[
                                                'StartNumber'=>(($pageInfo-1)*10+1),
                                                'EndNumber'=>($pageInfo*10),
                                                'this_page'=>$pageInfo,
                                                'search_text'=>$AllInformation['1']
                                                ]) }}" data-page='{{ $pageInfo }}'>
                        	<span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span>
                        </a></li>
                        </ul>
                    </nav>
            	</div>
            </div>
        @else
            <div class="alert alert-success text-center" role="alert" style="width: 70%; margin-right: auto;margin-left: auto;">無法搜尋到您要的結果真的非常抱歉！</div>
        @endif
    <script type="text/javascript">
    'use strict';
    var pagination_page = 2;
    var pagination_MaxPage = 5;

    $(document).ready(function() {
        var last_page = $('#last_page').attr('data-page');
        var this_page = $('#Search_Result_data').attr('data-page');
        var key = $('#Search_Result_data').attr('data-text_Key');
        checkPagination(this_page, last_page, key);
    });

    function checkPagination(this_page, last_page, key){
        if (last_page < 5) {
                SmallPagination(this_page, last_page, key);
        } else if (last_page > 5) {
                LargePagination(this_page, last_page, key);
        }
    }

    function SmallPagination(this_page, last_page, key) {
        for (var i = 0; i <= last_page; i++) {
            $("ul.pagination li:eq(" + i + ")").attr('class', '');
        }
        $("ul.pagination li:eq(" + this_page + ")").attr('class', 'active');
    }

    function LargePagination(this_page, last_page, key) {
        if (this_page > pagination_page && this_page <= (last_page - pagination_page)) {
            for (var i = 1; i <= pagination_MaxPage; i++) {
                var page = (parseInt(this_page) + i - 3);
                $("ul.pagination li:eq(" + i + ") a").attr('data-page', (page));
                $("ul.pagination li:eq(" + i + ") a").html(page);
                $("ul.pagination li:eq(" + i + ") a").attr('href', '/Search/'+(((page)-1)*10+1)+'/'+((page)*10)+'/'+page+'/'+key);
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
                $("ul.pagination li:eq(" + i + ") a").attr('href', '/Search/'+(((page)-1)*10+1)+'/'+((page)*10)+'/'+page+'/'+key);
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