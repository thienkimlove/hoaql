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
                <a href="{{ route('rules.index') }}" class="btn btn-primary waves-effect waves-light"><span class="m-r-5"><i class="fa fa-list"></i></span>Danh sách cơ chế</a>
            </div>
            <h4 class="page-title">Sửa cơ chế</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-sm-12">
                        {!! Form::open(['route' => ['rules.update', $rule->id], 'method' => 'put', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true]) !!}
                        @include('layouts.partials.errors')

                        <div class="form-group">
                            <label class="col-md-3 control-label">Tên cơ chế</label>
                            <div class="col-md-9">
                                {!! Form::text('name', $rule->name, ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Tên cơ chế']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Số lượng</label>
                            <div class="col-md-9">
                                {!! Form::text('quantity', $rule->quantity, ['id' => 'quantity', 'class' => 'form-control money', 'placeholder' => 'Số lượng']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Đơn giá(VND)</label>
                            <div class="col-md-9">
                                {!! Form::text('price', $rule->price, ['id' => 'price', 'class' => 'form-control money', 'placeholder' => 'Đơn giá']) !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Lương(VND)</label>
                            <div class="col-md-9">
                                {!! Form::text('salary', $rule->salary, ['id' => 'salary', 'class' => 'form-control money', 'placeholder' => 'Lương']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Thưởng(VND)</label>
                            <div class="col-md-9">
                                {!! Form::text('award', $rule->award, ['id' => 'award', 'class' => 'form-control money', 'placeholder' => 'Thưởng']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Trạng thái</label>
                            <div class="col-md-9">
                                {!! Form::checkbox('status', '1', $rule->status, ['data-plugin' => 'switchery', 'data-color' => '#81c868']) !!}
                                <span class="lbl"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Ngày tạo</label>
                            <div class="col-md-9">
                                <p class="form-control-static">{{ $rule->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right"></label>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Lưu</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="/vendor/ubold/assets/plugins/autoNumeric/autoNumeric.js" type="text/javascript"></script>
    <script type="text/javascript" src="/vendor/ubold/assets/plugins/autocomplete/jquery.mockjax.js"></script>
    <script type="text/javascript" src="/vendor/ubold/assets/plugins/autocomplete/jquery.autocomplete.min.js"></script>
    <script type="text/javascript" src="/vendor/ubold/assets/plugins/autocomplete/countries.js"></script>
    <script type="text/javascript" src="/vendor/ubold/assets/pages/autocomplete.js"></script>
    <script type="text/javascript" src="/vendor/jQuery-Mask-Plugin/dist/jquery.mask.min.js"></script>

@endsection

@section('inline_scripts')
    <script>
        (function($){
            $('.select2').select2();
            $('.money').mask('#.##0', {reverse: true});
        })(jQuery);
    </script>
@endsection