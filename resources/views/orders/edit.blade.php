@extends('layouts.app')

@section('styles')
    <!-- Plugins css-->
    <link href="/vendor/ubold/assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/multiselect/css/multi-select.css"  rel="stylesheet" type="text/css" />
    <link href="/vendor/ubold/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />


    <!-- DataTables -->
    <link href="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/dataTables.colVis.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/datatables/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/vendor/ubold/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">


@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('orders.index') }}" class="btn btn-primary waves-effect waves-light"><span class="m-r-5"><i class="fa fa-list"></i></span>Danh sách đơn hàng</a>
            </div>
            <h4 class="page-title">Cập nhật đơn #{{ $order->code }}</h4>
        </div>
    </div>

    @if ($order->canEditSaleInfo() && Sentinel::getUser()->hasAccess('orders'))

        {!! Form::open(['route' => ['orders.sale_update', $order->id], 'method' => 'put', 'role' => 'form', 'id' => 'order_submit_form', 'class' => 'form-horizontal', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b>Thông tin đơn hàng</b></h4>
                        <p class="text-muted m-b-30 font-13">
                            Mục này dành cho nhân viên kinh doanh.
                        </p>

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Đại lý</label>
                                    <div class="col-md-9">
                                        {!! Form::select('customer_id', ['' => 'Chọn đại lý'] + \App\Lib\Helpers::customerList(), $order->customer_id, ['id' => 'customer_id',  'class' => 'form-control select2', 'data-placeholder' => 'Chọn đại lý...']) !!}
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Tên đại lý</label>
                                    <div class="col-md-9">
                                        {!! Form::text('customer_name', $order->customer_name, ['id' => 'customer_name', 'class' => 'form-control', 'placeholder' => 'Tên đại lý']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">SDT đại lý</label>
                                    <div class="col-md-9">
                                        {!! Form::text('customer_phone', $order->customer_phone, ['id' => 'customer_phone', 'class' => 'form-control', 'placeholder' => 'SDT đại lý']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Địa chỉ đại lý</label>
                                    <div class="col-md-9">
                                        {!! Form::textarea('customer_address', $order->customer_address, ['id' => 'customer_address', 'class' => 'form-control', 'rows' => 5, 'placeholder' => 'Địa chỉ đại lý']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Ghi chú</label>
                                    <div class="col-md-9">
                                        {!! Form::textarea('note', $order->note, ['id' => 'note', 'rows' => 5, 'class' => 'form-control', 'placeholder' => 'Ghi chú']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Phương thức Thanh toán</label>
                                    <div class="col-md-9">
                                        {!! Form::select('payment_id', ['' => 'Chọn Phương thức Thanh toán'] + \App\Lib\Helpers::paymentList(), $order->payment_id, ['id' => 'payment_id',  'class' => 'form-control select2', 'data-placeholder' => 'Chọn Phương thức Thanh toán...']) !!}
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
                                    <label class="col-md-3 control-label">Cơ chế</label>
                                    <div class="col-md-9">
                                        {!! Form::select('rule_id', ['' => 'Chọn cơ chế'] + \App\Lib\Helpers::ruleList(), $order->rule_id, ['id' => 'rule_id',  'class' => 'form-control select2', 'data-placeholder' => 'Chọn cơ chế...']) !!}
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Số lượng</label>
                                    <div class="col-md-9">
                                        {!! Form::text('quantity', $order->quantity, ['id' => 'quantity', 'class' => 'form-control money', 'placeholder' => 'Số lượng']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Đơn giá(VND)</label>
                                    <div class="col-md-9">
                                        {!! Form::text('price', $order->price, ['id' => 'price', 'class' => 'form-control money', 'placeholder' => 'Đơn giá']) !!}
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-md-3 control-label">Lương(VND)</label>
                                    <div class="col-md-9">
                                        {!! Form::text('salary', $order->salary, ['id' => 'salary', 'class' => 'form-control money', 'placeholder' => 'Lương']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Thưởng(VND)</label>
                                    <div class="col-md-9">
                                        {!! Form::text('award', $order->award, ['id' => 'award', 'class' => 'form-control money', 'placeholder' => 'Thưởng']) !!}
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-md-3 control-label">Thành tiền</label>
                                    <div class="col-md-9">
                                        {!! Form::text('total', $order->total, ['id' => 'total', 'class' => 'form-control money', 'placeholder' => 'Thành tiền', 'readonly' => true]) !!}
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Số lượng túi</label>
                                    <div class="col-md-9">
                                        {!! Form::text('bag_qty', $order->bag_qty, ['id' => 'bag_qty', 'class' => 'form-control money', 'placeholder' => 'Số lượng túi']) !!}
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Số lượng hộp</label>
                                    <div class="col-md-9">
                                        {!! Form::text('box_qty', $order->box_qty, ['id' => 'box_qty', 'class' => 'form-control money', 'placeholder' => 'Số lượng hộp',]) !!}
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Số lượng tặng</label>
                                    <div class="col-md-9">
                                        {!! Form::text('gift', $order->gift, ['id' => 'gift', 'class' => 'form-control money', 'placeholder' => 'Số lượng tặng']) !!}
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label no-padding-right"></label>
                                    <div class="col-md-9">
                                        <button id="order_submit_button" type="button" class="btn btn-success waves-effect waves-light">Lưu</button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label no-padding-right"></label>
                                    <div class="col-md-9">
                                        @include('layouts.partials.errors')
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    @elseif ($order->canEditTransportInfo() && Sentinel::getUser()->hasAccess('transports'))
        {!! Form::open(['route' => ['orders.vc_update', $order->id], 'method' => 'put', 'role' => 'form', 'id' => 'order_submit_form', 'class' => 'form-horizontal', 'files' => true]) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b>Thông tin đơn hàng</b></h4>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Đại lý</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">{{ $order->customer_name.' (Mã : '.$order->customer->code.' - Phone : '.$order->customer_phone.')' }}</p>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <label class="col-md-3 control-label">Địa chỉ đại lý</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">{{ $order->customer_address }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Ghi chú</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">{{ $order->note }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Phương thức Thanh toán</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">{{ $order->payment->name }}</p>
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
                                    <label class="col-md-3 control-label">Cơ chế</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">{{ $order->rule->name }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Số lượng</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static" id="display_quantity">{{ \App\Lib\Helpers::intToDotString($order->quantity) }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Đơn giá(VND)</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">{{ \App\Lib\Helpers::vn_price($order->price) }}</p>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-md-3 control-label">Lương(VND)</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">{{ \App\Lib\Helpers::vn_price($order->salary) }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Thưởng(VND)</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">{{ \App\Lib\Helpers::vn_price($order->award) }}</p>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-md-3 control-label">Thành tiền</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static" id="thanh_tien">{{ \App\Lib\Helpers::vn_price($order->total) }}</p>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Số lượng túi</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">{{ \App\Lib\Helpers::intToDotString($order->bag_qty) }}</p>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Số lượng hộp</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">{{ \App\Lib\Helpers::intToDotString($order->box_qty) }}</p>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Số lượng tặng</label>
                                    <div class="col-md-9">
                                        <p class="form-control-static">{{ \App\Lib\Helpers::intToDotString($order->gift) }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
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

                                <div class="card-box table-responsive">
                                    <p class="text-muted font-13 m-b-30">Danh sách mã sản phẩm đã nhập : <span id="already_insert"></span></p>
                                    <p class="text-muted font-13 m-b-30">Danh sách mã sản phẩm còn thiếu : <span id="still_needed"></span></p>
                                    <table id="order_details" class="table table-striped table-bordered table-actions-bar">
                                        <thead>
                                        <tr>
                                            <td>Loại nhập mã</td>
                                            <td>Thông tin đã nhập</td>
                                            <td>Thời gian nhập</td>
                                            <td>Hành động</td>
                                        </tr>
                                        </thead>
                                    </table>

                                    <button id="button_modal_insert_code" type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#product-add-modal"><i class="fa fa-edit m-r-5"></i> Nhập mã sản phẩm</button>

                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Số túi nylon</label>
                                    <div class="col-md-9">
                                        {!! Form::text('small_bag_qty', $order->small_bag_qty, ['id' => 'small_bag_qty', 'class' => 'form-control money', 'placeholder' => 'Số túi nylon']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Số thùng Carton</label>
                                    <div class="col-md-9">
                                        {!! Form::text('carton_box_qty', $order->carton_box_qty, ['id' => 'carton_box_qty', 'class' => 'form-control money', 'placeholder' => 'Số thùng Carton']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Số tem Holo</label>
                                    <div class="col-md-9">
                                        {!! Form::text('holo_term_qty', $order->holo_term_qty, ['id' => 'holo_term_qty', 'class' => 'form-control money', 'placeholder' => 'Số tem Holo']) !!}
                                    </div>
                                </div>

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

                                <div class="form-group">
                                    <label class="col-md-3 control-label no-padding-right"></label>
                                    <div class="col-md-9">
                                        <button id="order_submit_button" type="button" class="btn btn-success waves-effect waves-light">Lưu</button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label no-padding-right"></label>
                                    <div class="col-md-9">
                                        @include('layouts.partials.errors')
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

        {!! Form::close() !!}

        <div id="product-add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Nhập danh sách mã sản phẩm" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Nhập danh sách mã sản phẩm</h4>
                    </div>
                    {!! Form::open(['method' => 'post', 'role' => 'form', 'id' => 'form_insert_code', 'class' => 'form-horizontal', 'files' => true]) !!}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Loại nhập mã</label>
                            <div class="col-md-9">
                                {!! Form::select('is_manually', ['' => 'Chọn loại nhập'] + config('system.item_list'), null, ['id' => 'is_manually',  'class' => 'form-control select2', 'data-placeholder' => 'Loại nhập mã...']) !!}

                                <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}" />
                            </div>
                        </div>

                        <div class="form-group" id="ma_le" style="display: none">
                            <label class="col-md-3 control-label">Mã lẻ</label>
                            <div class="col-md-9">
                                <div class="progress" style="display: none">
                                    <div id="progress-percent" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                        <span id="progPercentage" class = "current-value">0</span>
                                    </div>
                                    <div class="count btn btn-primary"><span id="charCount">0</span> Char</div>
                                    <div class="count btn btn-primary"><span id="lineCount">1</span> Lines</div>
                                </div>
                                {!! Form::textarea('manually_items', null, ['id' => 'manually_items',  'class' => 'form-control', 'data-placeholder' => 'Danh sách mã lẻ...']) !!}
                            </div>

                        </div>

                        <div class="form-group" id="start_ma" style="display: none">
                            <label class="col-md-3 control-label">Từ mã (AXXXXXXX)</label>
                            <div class="col-md-9">
                                {!! Form::text('start_code', null, ['id' => 'start_code', 'maxlength' => 9, 'minlength' => 9, 'class' => 'form-control', 'data-placeholder' => 'Từ mã...']) !!}
                            </div>
                        </div>

                        <div class="form-group" id="end_ma" style="display: none">
                            <label class="col-md-3 control-label">Đến mã (AXXXXXXX)</label>
                            <div class="col-md-9">
                                {!! Form::text('end_code', null, ['id' => 'end_code', 'maxlength' => 9, 'minlength' => 9,'class' => 'form-control', 'data-placeholder' => 'Đến mã...']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9 error" id="error_modal"></div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button id="button_insert_code" type="button" class="btn btn-primary waves-effect waves-light">Lưu</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div><!-- /.modal -->
    @endif



@endsection

@section('scripts')
    <script src="/vendor/ubold/assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>

    <script src="/vendor/ubold/assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
    <script src="/vendor/ubold/assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="/vendor/jQuery-Mask-Plugin/dist/jquery.mask.min.js"></script>

    <script src="/vendor/ubold/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.bootstrap.js"></script>

    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/buttons.bootstrap.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/jszip.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/responsive.bootstrap.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.scroller.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.colVis.js"></script>
    <script src="/vendor/ubold/assets/plugins/datatables/dataTables.fixedColumns.min.js"></script>

    <script src="/vendor/ubold/assets/pages/datatables.init.js"></script>
    <script src="/vendor/ubold/assets/plugins/select2/js/select2.full.min.js"></script>

    <script src="/vendor/Inputmask/dist/inputmask/inputmask.js"></script>
    <script src="/vendor/Inputmask/dist/inputmask/inputmask.extensions.js"></script>
    <script src="/vendor/Inputmask/dist/inputmask/inputmask.numeric.extensions.js"></script>
    <script src="/vendor/Inputmask/dist/inputmask/inputmask.date.extensions.js"></script>
    <script src="/vendor/Inputmask/dist/inputmask/jquery.inputmask.js"></script>
    <script src="/vendor/Inputmask/dist/inputmask/bindings/inputmask.binding.js"></script>
    <script src="/vendor/Textarea-Character-Line-Count-Limit-Plugin/jquery.textArea.js"></script>



@endsection
@section('inline_scripts')
@if ($order->canEditSaleInfo() && Sentinel::getUser()->hasAccess('orders'))

    <script>

        function updateTotalValue() {
            let quantity = $('#quantity').val();
            let price = $('#price').val();
            let int_qty = parseInt(quantity.replace(/\./g , ""))
            let int_price = parseInt(price.replace(/\./g , ""))
            let totalVal = int_qty*int_price;
            let maskedValue = $('#total').masked(totalVal);
            $('#total').val(maskedValue);

        }


        (function($){

            $('#customer_id').on('change', function(){
                let customer_id = $(this).val();
                $.ajax({
                    url : '/ajax',
                    type : 'POST',
                    data : { customer_id : customer_id, part : 'fill_customer' },
                    beforeSend: function (xhr) {
                        let token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    }
                }).always(function (res) {
                    if (res) {
                        $('#customer_name').val(res.name).parents('div.form-group').show();
                        $('#customer_phone').val(res.phone).parents('div.form-group').show();
                        $('#customer_address').val(res.address).parents('div.form-group').show();
                    }
                });


            });

            $('#rule_id').on('change', function(){
                let rule_id = $(this).val();

                $.ajax({
                    url : '/ajax',
                    type : 'POST',
                    data : { rule_id : rule_id, part : 'fill_rule' },
                    beforeSend: function (xhr) {
                        let token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    }
                }).done(function (res) {
                    if (res) {
                        $('#quantity').val(res.quantity).parents('div.form-group').show();
                        $('#price').val(res.price).parents('div.form-group').show();
                        $('#salary').val(res.salary).parents('div.form-group').show();
                        $('#award').val(res.award).parents('div.form-group').show();
                        $('#total').val(res.total).parents('div.form-group').show();
                        $('#box_qty, #bag_qty, #gift').show();
                    }
                });

            });

            $('#quantity, #price').on('change', function(){
                updateTotalValue();
            });

            $('.select2').select2();
            $('.money').mask('#.##0', {reverse: true});


            $('#order_submit_button').on('click', function(e){
                e.preventDefault();
                $('#order_submit_form').submit();
                return false;
            });

        })(jQuery);

    </script>

@elseif ($order->canEditTransportInfo() && Sentinel::getUser()->hasAccess('transports'))

    <script>
        function chunkSubstr(str, size) {
            let numChunks = Math.ceil(str.length / size)
            let chunks = new Array(numChunks)

            for (let i = 0, o = 0; i < numChunks; ++i, o += size) {
                chunks[i] = str.substr(o, size)
            }

            return chunks.join("\n");
        }



        function updateTienPhaiThu() {
            let thanhtien = $('#thanh_tien').html();
            let phi_thu_ho = $('#phi_vc_thu_ho').val();
            let int_thanhtien = parseInt(thanhtien.replace(/\./g , "").replace("đ" , ""));
            let int_phi_thu_ho = parseInt(phi_thu_ho.replace(/\./g , ""))

            let maskedValue = $('#tien_phai_thu').masked(int_thanhtien+int_phi_thu_ho);
            $('#tien_phai_thu').val(maskedValue);
        }

        (function($){
            $('.select2').select2();
            $('.money').mask('#.##0', {reverse: true});
            updateTienPhaiThu();

            $('#start_code, #end_code').inputmask({ 'regex' : 'A\\d{8}'}); //mask with dynamic syntax

            $("#manually_items").textareaCounter({
                txtElem:'manually_items',
                charElem:'charCount',
                lineElem:'lineCount',
                progElem:'progress-percent',
                progPerc:'progPercentage',
                txtCount:'90',
                lineCount:'10',
                charPerLine:'9',
            }).bind('paste', function(e) {
                var elem = $(this);
                setTimeout(function() {
                    elem.val(function(i, val) {
                        let temp_val = $.trim(val.replace(/\s?,\s?/g, '\n').replace(/\n+/g, ''));

                        return chunkSubstr(temp_val, 9);
                    });
                }, 20);
            });


            $('#order_submit_button').on('click', function(e){
                e.preventDefault();
                $('#order_submit_form').submit();
                return false;
            });

            $('#phi_vc_thu_ho').on('change', function(){
                updateTienPhaiThu();
            });

            let dataTable = $("#order_details").DataTable({
                searching: false,
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{!! route('details.dataTables') !!}',
                    data: function (d) {
                        d.order_id = $('input[name=order_id]').val();
                    }
                },
                columns: [
                    {data: 'is_manually', name: 'is_manually'},
                    {data: 'info', name: 'info'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action'},
                ],
                order: [[1, 'desc']],
                "footerCallback": function ( row, data, start, end, display ) {
                    if (data.length > 0) {
                        $('#already_insert').html(data[0].already_insert);
                        $('#still_needed').html(data[0].still_needed);
                        if (data[0].still_needed === 0) {
                            $("#button_modal_insert_code").hide();
                        } else {
                            $("#button_modal_insert_code").show();
                        }
                    } else {
                        let display_quantity = $('#display_quantity').html();
                        let int_quantity = parseInt(display_quantity.replace(/\./g , "").replace("đ" , ""));
                        $('#already_insert').html(0);
                        $('#still_needed').html(int_quantity);
                        $("#button_modal_insert_code").show();
                    }
                }
            });


            dataTable.on('click', '[id^="btn-delete-"]', function (e) {
                e.preventDefault();

                let url = $(this).data('url');

                swal({
                    title: "Bạn có muốn xóa dòng nhập mã này?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Xóa!"
                }).then(function () {
                    $.ajax({
                        url : url,
                        type : 'GET',
                        beforeSend: function (xhr) {
                            var token = $('meta[name="csrf_token"]').attr('content');
                            if (token) {
                                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                            }
                        }
                    }).always(function (data) {
                        dataTable.draw();
                    });
                });
            });

            $("#product-add-modal").on("show.bs.modal", function(e) {
                $('#is_manually').val('');
                $('#manually_items').val('');
                $('#start_code, #end_code').val('');
                $('#start_ma, #end_ma').hide();
                $('#ma_le').hide();
                $('#error_modal').html('');
            });



            $('#is_manually').on('change', function(e){
                let choose_manually = $(this).val();
                if (choose_manually === '1') {
                    $('#manually_items').val('');
                    $('#ma_le').show();
                    $('#start_code, #end_code').val('');
                    $('#start_ma, #end_ma').hide();
                    $('#error_modal').html('');
                } else {
                    $('#start_code, #end_code').val('');
                    $('#start_ma, #end_ma').show();
                    $('#manually_items').val('');
                    $('#ma_le').hide();
                    $('#error_modal').html('');
                }
            });

            $('#button_insert_code').on('click', function(e){
                e.preventDefault();
                let is_manually = $('#is_manually').val();
                let start_code = $('#start_code').val();
                let end_code = $('#end_code').val();
                let manually_items = $('#manually_items').val();
                let order_id = $('#order_id').val();
                $('#error_modal').html('');
                $.ajax({
                    url : '{!! route('details.store') !!}',
                    type : 'POST',
                    data : { is_manually : is_manually, start_code: start_code, end_code: end_code, manually_items : manually_items, order_id:order_id },
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    }
                }).always(function (res) {
                    if (res.error) {
                        for (var i=0; i < res.error.length; i++) {
                            $('#error_modal').append('<span>'+res.error[i]+'</span>');
                        }

                    } else {
                        $('#product-add-modal').modal('hide');
                        dataTable.draw();
                    }

                });
            });

        })(jQuery);

    </script>

@endif
@endsection
