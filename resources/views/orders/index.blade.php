@extends('layouts.app')

@section('inline_styles')
    <style>
        .select2-container--default {
            width: 250px !important;
        }
        .select2-container--default .select2-results > .select2-results__options {
            max-height: 500px;
            min-height: 400px;
            overflow-y: auto;
        }
    </style>
@endsection

@section('styles')
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
    <link href="/vendor/ubold/assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right m-t-15">
                <a href="/orders/create"><button type="button" class="btn btn-default dropdown-toggle waves-effect" >Tạo mới <span class="m-l-5"><i class="fa fa-plus"></i></span></button></a>
            </div>
            <ol class="breadcrumb">
                <li class="active">
                    Danh sách đơn hàng
                </li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-inline" role="form" id="search-form">

                            <div class="form-group m-l-10">
                                <label class="sr-only" for="">Mã đơn</label>
                                <input type="text" class="form-control" placeholder="Mã Đơn" name="code"/>
                            </div>

                            <div class="form-group m-l-10">
                                <label class="sr-only" for="">Trạng thái</label>
                                {!! Form::select('status', ['' => '--- Chọn trạng thái ---'] + config('system.order_status'), '', ['class' => 'form-control']) !!}
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-15">Tìm kiếm</button>
                        </form>

                        <div class="form-group pull-right">
                            {!! Form::open(['route' => 'orders.export', 'method' => 'get', 'role' => 'form', 'class' => 'form-inline', 'id' => 'export-form']) !!}

                            {{Form::hidden('filter_code', null)}}
                            {{Form::hidden('filter_status', null)}}

                            <button class="btn btn-danger waves-effect waves-light m-t-15" value="export" type="submit" name="export">
                                <i class="fa fa-download"></i>&nbsp; Xuất Excel
                            </button>
                            {!! Form::close() !!}

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title"><b>Danh sách đơn hàng</b></h4>
                <p class="text-muted font-13 m-b-30"></p>
                <table id="dataTables-contents" class="table table-striped table-bordered table-actions-bar">
                    <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Đại lý</th>
                        <th>Đơn hàng</th>
                        <th>Thành tiền</th>
                        <th>Vận chuyển</th>
                        <th>Trạng thái</th>
                        <th>Lịch sử</th>
                        <th>Ngày tạo</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
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
    <script src="/js/handlebars.js"></script>

    <script src="/vendor/ubold/assets/plugins/moment/moment.js"></script>
    <script src="/vendor/ubold/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
@endsection

@section('inline_scripts')
    <script type="text/javascript">
        $('.select2').select2();

        $(function () {
            let dataTable = $("#dataTables-contents").DataTable({
                searching: false,
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{!! route('orders.dataTables') !!}',
                    data: function (d) {
                        d.name = $('input[name=code]').val();
                        d.status = $('select[name=status]').val();
                    }
                },
                columns: [
                    {data: 'code', name: 'code'},
                    {data: 'customer', name: 'customer'},
                    {data: 'order', name: 'order'},
                    {data: 'total', name: 'total'},
                    {data: 'transport', name: 'transport'},
                    {data: 'status', name: 'status'},
                    {data: 'histories', name: 'histories'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action'}
                ],
                order: [[1, 'desc']]
            });

            $('#search-form').on('submit', function(e) {
                dataTable.draw();
                e.preventDefault();
            });

            dataTable.on('click', '[id^="btn-delivery-"]', function (e) {
                e.preventDefault();

                let url = $(this).data('url');

                swal({
                    title: "Bạn có muốn đánh dấu đơn này là đã chuyển?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Đánh dấu ĐÃ CHUYỂN!"
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

            dataTable.on('click', '[id^="btn-cancel-"]', function (e) {
                e.preventDefault();

                let url = $(this).data('url');

                swal({
                    title: "Bạn có muốn hủy đơn?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Hủy đơn!"
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

            dataTable.on('click', '[id^="btn-return-"]', function (e) {
                e.preventDefault();

                let url = $(this).data('url');

                swal({
                    title: "Bạn có muốn hoàn đơn?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Hoàn đơn!"
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



            dataTable.on('click', '[id^="btn-complete-"]', function (e) {
                e.preventDefault();

                let url = $(this).data('url');

                swal({
                    title: "Bạn có muốn đánh dấu đơn này là đã hoàn thành?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Đánh dấu HOÀN THÀNH!"
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

            $('#export-form').on('submit', function (e) {
                $('input[name=filter_code]').val($('input[name=code]').val());

                $('input[name=filter_status]').val($('select[name=status]').val());


                $(this).submit();
                dataTable.draw();
                e.preventDefault();
            });

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endsection