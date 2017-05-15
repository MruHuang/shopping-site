<!-- <form role="form"  method="POST" action=" {{ route('TrackOrderFive',[
    'orderID'=>$All['AllInformation'][$i]['orderID'] ,
    'orderState'=>$All['AllInformation'][$i]['orderState']
]) }} ">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="col-xs-6" style="padding: 0; padding-right: 5px;">
        <input type="text" name="fiveNumber" class="form-control" placeholder="輸入後五碼" style="height: 25px;">
    </div>
    <div class="col-xs-3" style="padding: 0; ">
        <button  type="submit" class="btn btn-success" style="width: 100%; padding: 2px 2px;">確認</button>
    </div>
    <div class="col-xs-3" style="padding: 0; ">
        <a class="btn btn-warning CancelOrderBtn" data_cancelID = "{{ $All['AllInformation'][$i]['orderID'] }}" style="width: 100%; padding: 2px 2px;">取消訂單</a>
    </div>
</form>
 -->
如已完成付款，
輸入匯款後五碼並按確認。<a class="btn btn-success orderFN_btn" date-orderID="{{ $All['AllInformation'][$i]['orderID'] }}" date-orderState="{{ $All['AllInformation'][$i]['orderState'] }}">輸入匯款碼</a>
