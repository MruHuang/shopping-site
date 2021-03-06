<div class="modal fade message_modal">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close message_close"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">提示</h4>
            </div>
            <div class="modal-body">
                @if(count($message_text))
                 <p> {{ $message_text }}</p>
                @endif
                @if(count($errors->all()))
                @foreach($errors->all() as $error) 
                <p>{{ $error }}</p>
                @endforeach 
                @endif
             </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default message_close" style="float: right;margin-left: 20px;">Close</button>
                @if($message_text == '加入成功')
                <a href="{{ route('ShoppingCar',['speciestype'=>'Groupbuy']) }}" class="btn btn-primary" style="float: right;">前往團購購物車</a>
                @endif
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->