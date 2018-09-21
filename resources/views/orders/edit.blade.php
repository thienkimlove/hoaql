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
                <a href="{{ route('orders.index') }}" class="btn btn-primary waves-effect waves-light"><span class="m-r-5"><i class="fa fa-list"></i></span>Danh sách đơn hàng</a>
            </div>
            <h4 class="page-title">Cập nhật đơn #{{ $order->code }}</h4>
        </div>
    </div>


    {!! Form::open(['route' => ['orders.update', $order->id], 'method' => 'put', 'role' => 'form', 'id' => 'order_submit_form', 'class' => 'form-horizontal', 'files' => true]) !!}

    <div class="row" @if(!$order->canEditSaleInfo() || !Sentinel::getUser()->hasAccess('orders'))style="display: none"@endif>
        @include('orders.partials.sale_part', ['order' => $order])
    </div>

    <div class="row" @if(!$order->canEditTransportInfo() || !Sentinel::getUser()->hasAccess('transports'))style="display: none"@endif>

        @include('orders.partials.transport_part', ['order' => $order])

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">

                <div class="row">
                    <div class="col-md-6">
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


    <script type="text/javascript" src="/vendor/ubold/assets/plugins/autocomplete/countries.js"></script>


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

        function updateTienPhaiThu() {
            let thanhtien = $('#total').val();
            let phi_thu_ho = $('#phi_vc_thu_ho').val();
            let int_thanhtien = parseInt(thanhtien.replace(/\./g , ""))
            let int_phi_thu_ho = parseInt(phi_thu_ho.replace(/\./g , ""))

            let maskedValue = $('#tien_phai_thu').masked(int_thanhtien+int_phi_thu_ho);
            $('#tien_phai_thu').val(maskedValue);
        }

        (function($){
            $('.select2').select2();
            $('.money').mask('#.##0', {reverse: true});
            updateTienPhaiThu();


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

            $('#total, #phi_vc_thu_ho').on('change', function(){
                updateTienPhaiThu();
            });

        })(jQuery);
    </script>
@endsection