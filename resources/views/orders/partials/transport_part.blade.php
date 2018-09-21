<div class="col-md-12">
    <div class="card-box">
        <h4 class="m-t-0 header-title"><b>Thông tin vận chuyển</b></h4>
        <p class="text-muted m-b-30 font-13">
            Mục này dành cho nhân viên vận chuyển.
        </p>

        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    <label class="col-md-3 control-label">Đơn vị vận chuyển</label>
                    <div class="col-md-9">
                        {!! Form::text('vc_name', $order->vc_name, ['id' => 'vc_name', 'class' => 'form-control', 'placeholder' => 'Đơn vị vận chuyển']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Mã vận chuyển</label>
                    <div class="col-md-9">
                        {!! Form::text('vc_code', $order->vc_code, ['id' => 'vc_code', 'class' => 'form-control', 'placeholder' => 'Mã vận chuyển']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">SDT đơn vị vận chuyển</label>
                    <div class="col-md-9">
                        {!! Form::text('vc_phone', $order->vc_phone, ['id' => 'vc_phone', 'class' => 'form-control', 'placeholder' => 'SDT đơn vị vận chuyển']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Trạng thái</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{ config('system.order_status.'.$order->status) }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Ngày tạo</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{ $order->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>


            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <label class="col-md-3 control-label">Phí VC thu hộ(VND)</label>
                    <div class="col-md-9">
                        {!! Form::text('phi_vc_thu_ho', $order->phi_vc_thu_ho, ['id' => 'phi_vc_thu_ho', 'class' => 'form-control money', 'placeholder' => 'Phí VC thu hộ']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Phí VC công ty trả(VND)</label>
                    <div class="col-md-9">
                        {!! Form::text('phi_vc_cty_tra', $order->phi_vc_cty_tra, ['id' => 'phi_vc_cty_tra', 'class' => 'form-control money', 'placeholder' => 'Phí VC công ty trả']) !!}
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label">Tiền phải thu(VND)</label>
                    <div class="col-md-9">
                        {!! Form::text('tien_phai_thu', $order->tien_phai_thu, ['id' => 'tien_phai_thu', 'class' => 'form-control money', 'placeholder' => 'Tiền phải thu', 'readonly' => true]) !!}
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>