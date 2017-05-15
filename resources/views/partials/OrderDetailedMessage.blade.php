
<div class="modal fade message_modal">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close message_close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">提示</h4>
            </div>
            <div class="modal-body" >
                <div class="row" style="margin-right: 20px;margin-left: 20px;">
                    <div class="form-group">
                        <label>收件人</label>
                        <input class="form-control" type="text" value="{{ $order_detailed['order_data'][0]['recipient'] }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>付款方式</label>
                        <input class="form-control" type="text" value="{{ $order_detailed['order_data'][0]['checkoutMethod'] }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>匯款帳號後五碼</label>
                        @if($order_detailed['order_data'][0]['moneyTransferFN'] == 0)
                            <input class="form-control" type="text" value="無" disabled>
                        @else
                        <input class="form-control" type="text" value="{{$order_detailed['order_data'][0]['moneyTransferFN']}}" disabled>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>地址</label>
                        <input class="form-control" type="text" value="{{ $order_detailed['order_data'][0]['deliveryAdd'] }}" disabled>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                       <!--  <th>商品連結</th> -->
                        <th>商品名稱</th>
                        <th>商品分類</th>
                        <th>購買數量</th>
                        <th>價格</th>
                    </tr>
                    <?php $MAX = count($order_detailed)-1 ?>
                    @for($i=0;$i<$MAX;$i++)
                    <tr>
                        @if($order_detailed[$i]['commodityArea'] == 'commodity')
                            <!-- <td><a href="{{ route('Commoditypage',[
                            'type'=>$order_detailed[$i]['commodityArea'],
                            'ID'=>$order_detailed[$i]['commodityID']]) }}">商品連結</a></td> -->
                            <td>{{ $order_detailed[$i]['commodityName'] }}</td>
                            <td>一般商品</td>
                            <td>{{ $order_detailed[$i]['commodityAmount'] }}</td>
                            <td>{{ $order_detailed[$i]['commodityPrice'] }}</td>
                        @elseif($order_detailed[$i]['commodityArea'] == 'groupbuy')
                            <!-- <td><a href="{{ route('Commoditypage',[
                            'type'=>$order_detailed[$i]['commodityArea'],
                            'ID'=>$order_detailed[$i]['groupbuyID']]) }}">商品連結</a></td> -->
                            <td>{{ $order_detailed[$i]['commodityName'] }}</td>
                            <td>團購商品</td>
                            <td>{{ $order_detailed[$i]['commodityAmount'] }}</td>
                            <td>{{ $order_detailed[$i]['groupbuyPrice'] }}</td>
                        @else
                            <!-- <td><a href="{{ route('Commoditypage',[
                            'type'=>$order_detailed[$i]['commodityArea'],
                            'ID'=>$order_detailed[$i]['limitedID']]) }}">商品連結</a></td> -->
                            <td>{{ $order_detailed[$i]['commodityName'] }}</td>
                            <td>限時限量商品</td>
                            <td>{{ $order_detailed[$i]['commodityAmount'] }}</td>
                            <td>{{ $order_detailed[$i]['limitedPrice'] }}</td>
                        @endif
                        </tr>
                    @endfor
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default message_close">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->