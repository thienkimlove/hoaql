<div class="navbar-custom">
    <?php
        $currentUser = Sentinel::getUser();
    ?>
    <div class="container">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">
                <li class="has-submenu">
                    <a href="{{url('admin')}}"><i class="md md-dashboard"></i>Trang chủ</a>
                </li>


                @if ($currentUser->hasAccess(['customers']))

                    <li class="has-submenu">

                        <a href="{{ url('/customers')}}"><i class="md md-layers"></i>Đại lý</a>

                    </li>

                @endif

                @if ($currentUser->hasAnyAccess(['orders', 'transports']))

                    <li class="has-submenu">

                        <a href="{{ url('/orders')}}"><i class="md md-folder"></i>Đơn hàng</a>

                    </li>

                @endif

                @if ($currentUser->isAdmin())

                    <li class="has-submenu">
                        <a href="#"><i class="md md-settings"></i>Hệ thống</a>
                        <ul class="submenu">
                            <li><a href="{{ url('/users')}}">Thành viên</a></li>
                            <li><a href="{{ url('/roles') }}">Loại thành viên</a></li>
                            <li><a href="{{ url('/payments') }}">Phương thức thanh toán</a></li>
                            <li><a href="{{ url('/rules')}}">Cơ chế</a></li>

                        </ul>
                    </li>

                @endif
            </ul>
            <!-- End navigation menu        -->
        </div>
    </div> <!-- end container -->
</div> <!-- end navbar-custom -->
