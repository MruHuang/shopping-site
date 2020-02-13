<div class="panel panel-primary ">
   <div class="panel-heading">
        <div class="row" style="position: relative;">
            <div class="col-xs-8">
                <h3>
                <?php $array_key = array_keys($AllInformation)[$i]; 
                    if($array_key=='commodity') echo "一般區";
                    else if($array_key=='groupbuy') echo "團購區";
                    else if($array_key=='timelimit') echo "限時限量區";
                ?> 
                </h3>
            </div>
            <div class="col-xs-4" style="bottom:0px; position:absolute; margin-left: 66.66666;">
                    <a href=" {{ route('Subpage',[
                    'array_key'=>$array_key,
                    'start'=>'1',
                    'end'=>'12',
                    'type'=>'All',
                    'order_type'=>'updated_at',
                    'this_page'=>'1'
                    ]) }} " class="home_more_style" style="color: red; float: right;font-size: 20px;">more..</a>
                </div>
            </div>
        </div>
    <div class="panel-body">
    {{-- @for ($i = 0; $i < {{()}}}; $i++) --}}
    <?php $MAX=count($AllInformation[$array_key])<=24?count($AllInformation[$array_key]):24 ?>
        @for ($i = 0; $i < $MAX; $i++)
            <div class="col-xs-2">
                <!--商品-->
                <a href="">
                <div class="home_commodity_style">
                    <img src="img/ps4.jpg" width=200px;>
                    <h5>名稱：{{ $AllInformation[$array_key][$i]['commodityName']  }}</h5>
                    <p>價格：{{ $AllInformation[$array_key][$i]['commodityPrice'] }}元</p>
                    <div style="display:none"></div>
                </div>
                </a>
                <!--商品-->
            </div>
        @endfor
        
    </div>
    <div class="text-right"><a href=" {{ route('Subpage',[
            'array_key'=>$array_key,
            'start'=>'1',
            'end'=>'12',
            'type'=>'All',
            'order_type'=>'updated_at',
            'this_page'=>'1'
            ]) }} " class="home_more_style">more...</a>
    </div>
</div>
        