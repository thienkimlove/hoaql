@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">HỆ THỐNG</h4>
            <p class="text-muted page-title-alt">Chào mừng bạn {{Sentinel::getUser()->name}}</p>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="widget-bg-color-icon card-box fadeInDown animated">
                <div class="bg-icon bg-icon-success pull-left">
                    <i class="md md-input text-success"></i>
                </div>
                <div class="text-right">
                    <h3 class="text-dark"><b class="counter">0</b></h3>
                    <p class="text-muted">Số lượng đơn hàng</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-bg-color-icon card-box">
                <div class="bg-icon bg-icon-pink pull-left">
                    <i class="md md-import-export text-pink"></i>
                </div>
                <div class="text-right">
                    <h3 class="text-dark"><b class="counter">0</b></h3>
                    <p class="text-muted">Số lượng đại lý</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-bg-color-icon card-box">
                <div class="bg-icon bg-icon-purple pull-left">
                    <i class="md md-store text-purple"></i>
                </div>
                <div class="text-right">
                    <h3 class="text-dark"><b class="counter">0</b></h3>
                    <p class="text-muted">Số lượng giao vận</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="widget-bg-color-icon card-box">
                <div class="bg-icon bg-icon-info pull-left">
                    <i class="md md-account-child text-info"></i>
                </div>
                <div class="text-right">
                    <h3 class="text-dark"><b class="counter">{{ \App\Models\User::count() }}</b></h3>
                    <p class="text-muted">Số lượng người dùng</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>


    <!-- End row -->
@endsection