<div class="col-md-12">
    <div class="card-box">
        <h4 class="m-t-0 header-title"><b>Thông tin đơn hàng</b></h4>
        <p class="text-muted m-b-30 font-13">
            Mục này dành cho nhân viên kinh doanh.
        </p>

        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    <label class="col-md-3 control-label">Chọn đại lý</label>
                    <div class="col-md-9">
                        {!! Form::select('customer_id', ['' => 'Chọn đại lý'] + \App\Lib\Helpers::customerList(), isset($order)? $order->customer_id : null, ['id' => 'customer_id',  'class' => 'form-control select2', 'data-placeholder' => 'Chọn đại lý...']) !!}
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Tên đại lý</label>
                    <div class="col-md-9">
                        {!! Form::text('customer_name', isset($order)? $order->customer_name : null, ['id' => 'customer_name', 'class' => 'form-control', 'placeholder' => 'Tên đại lý']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">SDT đại lý</label>
                    <div class="col-md-9">
                        {!! Form::text('customer_phone', isset($order)? $order->customer_phone : null, ['id' => 'customer_phone', 'class' => 'form-control', 'placeholder' => 'SDT đại lý']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Địa chỉ đại lý</label>
                    <div class="col-md-9">
                        {!! Form::textarea('customer_address', isset($order)? $order->customer_address : null, ['id' => 'customer_address', 'class' => 'form-control', 'rows' => 5, 'placeholder' => 'Địa chỉ đại lý']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Ghi chú</label>
                    <div class="col-md-9">
                        {!! Form::textarea('note', isset($order)? $order->note : null, ['id' => 'note', 'rows' => 5, 'class' => 'form-control', 'placeholder' => 'Ghi chú']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Chọn Phương thức Thanh toán</label>
                    <div class="col-md-9">
                        {!! Form::select('payment_id', ['' => 'Chọn Phương thức Thanh toán'] + \App\Lib\Helpers::paymentList(), isset($order)? $order->payment_id : null, ['id' => 'payment_id',  'class' => 'form-control select2', 'data-placeholder' => 'Chọn Phương thức Thanh toán...']) !!}
                    </div>

                </div>


            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <label class="col-md-3 control-label">Chọn cơ chế</label>
                    <div class="col-md-9">
                        {!! Form::select('rule_id', ['' => 'Chọn cơ chế'] + \App\Lib\Helpers::ruleList(), isset($order)? $order->rule_id : null, ['id' => 'rule_id',  'class' => 'form-control select2', 'data-placeholder' => 'Chọn cơ chế...']) !!}
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Số lượng</label>
                    <div class="col-md-9">
                        {!! Form::text('quantity', isset($order)? $order->quantity : 0, ['id' => 'quantity', 'class' => 'form-control money', 'placeholder' => 'Số lượng']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Đơn giá(VND)</label>
                    <div class="col-md-9">
                        {!! Form::text('price', isset($order)? $order->price : 0, ['id' => 'price', 'class' => 'form-control money', 'placeholder' => 'Đơn giá']) !!}
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-md-3 control-label">Lương(VND)</label>
                    <div class="col-md-9">
                        {!! Form::text('salary', isset($order)? $order->salary : 0, ['id' => 'salary', 'class' => 'form-control money', 'placeholder' => 'Lương']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Thưởng(VND)</label>
                    <div class="col-md-9">
                        {!! Form::text('award', isset($order)? $order->award : 0, ['id' => 'award', 'class' => 'form-control money', 'placeholder' => 'Thưởng']) !!}
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-md-3 control-label">Thành tiền</label>
                    <div class="col-md-9">
                        {!! Form::text('total', isset($order)? $order->total : 0, ['id' => 'total', 'class' => 'form-control money', 'placeholder' => 'Thành tiền', 'readonly' => true]) !!}
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Số lượng túi</label>
                    <div class="col-md-9">
                        {!! Form::text('bag_qty', isset($order)? $order->bag_qty : 0, ['id' => 'bag_qty', 'class' => 'form-control money', 'placeholder' => 'Số lượng túi']) !!}
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Số lượng hộp</label>
                    <div class="col-md-9">
                        {!! Form::text('box_qty', isset($order)? $order->box_qty : 0, ['id' => 'box_qty', 'class' => 'form-control money', 'placeholder' => 'Số lượng hộp']) !!}
                    </div>

                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Số lượng tặng</label>
                    <div class="col-md-9">
                        {!! Form::text('gift', isset($order)? $order->gift : 0, ['id' => 'gift', 'class' => 'form-control money', 'placeholder' => 'Số lượng tặng']) !!}
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>