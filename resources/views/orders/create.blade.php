@extends('layouts.app')

@section('styles')
    <!-- Plugins css-->
    <link href="/vendor/ubold/assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/multiselect/css/multi-select.css"  rel="stylesheet" type="text/css" />
    <link href="/vendor/ubold/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="/vendor/ubold/assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/vendor/ubold/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="{{ route('orders.index') }}" class="btn btn-primary waves-effect waves-light"><span class="m-r-5"><i class="fa fa-list"></i></span> Danh sách Đơn hàng</a>
            </div>
            <h4 class="page-title">Tạo mới Đơn hàng</h4>
        </div>
    </div>

    {!! Form::open(['route' => ['orders.store'], 'method' => 'post', 'role' => 'form','id' => 'order_submit_form', 'class' => 'form-horizontal', 'files' => true]) !!}
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
                                {!! Form::select('customer_id', ['' => 'Chọn đại lý'] + \App\Lib\Helpers::customerList(), null, ['id' => 'customer_id',  'class' => 'form-control select2', 'data-placeholder' => 'Chọn đại lý...']) !!}
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Tên đại lý</label>
                            <div class="col-md-9">
                                {!! Form::text('customer_name', null, ['id' => 'customer_name', 'class' => 'form-control', 'placeholder' => 'Tên đại lý']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">SDT đại lý</label>
                            <div class="col-md-9">
                                {!! Form::text('customer_phone', null, ['id' => 'customer_phone', 'class' => 'form-control', 'placeholder' => 'SDT đại lý']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Địa chỉ đại lý</label>
                            <div class="col-md-9">
                                {!! Form::textarea('customer_address', null, ['id' => 'customer_address', 'class' => 'form-control', 'rows' => 5, 'placeholder' => 'Địa chỉ đại lý']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Ghi chú</label>
                            <div class="col-md-9">
                                {!! Form::textarea('note', null, ['id' => 'note', 'rows' => 5, 'class' => 'form-control', 'placeholder' => 'Ghi chú']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Phương thức Thanh toán</label>
                            <div class="col-md-9">

                                {!! Form::select('payment_id', ['' => 'Chọn Phương thức Thanh toán'] + \App\Lib\Helpers::paymentList(), null, ['id' => 'payment_id',  'class' => 'form-control select2', 'data-placeholder' => 'Chọn Phương thức Thanh toán...']) !!}

                            </div>

                        </div>


                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Cơ chế</label>
                            <div class="col-md-9">
                                {!! Form::select('rule_id', ['' => 'Chọn cơ chế'] + \App\Lib\Helpers::ruleList(), null, ['id' => 'rule_id',  'class' => 'form-control select2', 'data-placeholder' => 'Chọn cơ chế...']) !!}
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Số lượng</label>
                            <div class="col-md-9">
                                {!! Form::text('quantity', null, ['id' => 'quantity', 'class' => 'form-control money', 'placeholder' => 'Số lượng']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Đơn giá(VND)</label>
                            <div class="col-md-9">
                                {!! Form::text('price', 0, ['id' => 'price', 'class' => 'form-control money', 'placeholder' => 'Đơn giá']) !!}
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-md-3 control-label">Lương(VND)</label>
                            <div class="col-md-9">
                                {!! Form::text('salary', 0, ['id' => 'salary', 'class' => 'form-control money', 'placeholder' => 'Lương']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Thưởng(VND)</label>
                            <div class="col-md-9">
                                {!! Form::text('award', 0, ['id' => 'award', 'class' => 'form-control money', 'placeholder' => 'Thưởng']) !!}
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-md-3 control-label">Thành tiền</label>
                            <div class="col-md-9">
                                {!! Form::text('total', 0, ['id' => 'total', 'class' => 'form-control money', 'placeholder' => 'Thành tiền', 'readonly' => true]) !!}
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Số lượng túi</label>
                            <div class="col-md-9">
                                {!! Form::text('bag_qty', 0, ['id' => 'bag_qty', 'class' => 'form-control money', 'placeholder' => 'Số lượng túi']) !!}
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Số lượng hộp</label>
                            <div class="col-md-9">
                                {!! Form::text('box_qty', 0, ['id' => 'box_qty', 'class' => 'form-control money', 'placeholder' => 'Số lượng hộp']) !!}
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Số lượng tặng</label>
                            <div class="col-md-9">
                                {!! Form::text('gift', 0, ['id' => 'gift', 'class' => 'form-control money', 'placeholder' => 'Số lượng tặng']) !!}
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
@endsection

@section('scripts')
    <script src="/vendor/ubold/assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
    <script src="/vendor/ubold/assets/plugins/switchery/js/switchery.min.js"></script>
    <script type="text/javascript" src="/vendor/ubold/assets/plugins/multiselect/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="/vendor/ubold/assets/plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
    <script src="/vendor/ubold/assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
    <script src="/vendor/ubold/assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/vendor/ubold/assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
    <script src="/vendor/ubold/assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
    <script src="/vendor/ubold/assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>

    <
    <script type="text/javascript" src="/vendor/ubold/assets/plugins/autocomplete/countries.js"></script>


    <script type="text/javascript" src="/vendor/ubold/assets/pages/jquery.form-advanced.init.js"></script>

    <script type="text/javascript" src="/vendor/jQuery-Mask-Plugin/dist/jquery.mask.min.js"></script>
@endsection

@section('inline_scripts')
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
            $('.select2').select2();
            $('.money').mask('#.##0', {reverse: true});

            $('#order_submit_button').on('click', function(e){
                e.preventDefault();
                $('#order_submit_form').submit();
                return false;
            });

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

        })(jQuery);
    </script>
@endsection