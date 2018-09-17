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


                @if ($currentUser->hasAnyAccess(['posts.*', 'questions.*', 'videos.*', 'products.*', 'stores.*', 'banners.*', 'categories.*', 'tags.*']))

                    <li class="has-submenu">

                        <a href="#"><i class="md md-edit"></i>Nội dung Trang</a>
                        <ul class="submenu">

                            @if ($currentUser->hasAnyAccess(['banners.*']))
                                <li><a href="{{ url('/banners')}}">Banners</a></li>
                            @endif

                            @if ($currentUser->hasAnyAccess(['categories.*']))
                                <li><a href="{{ url('/categories')}}">Chuyên mục</a></li>
                            @endif

                            @if ($currentUser->hasAnyAccess(['tags.*']))
                                <li><a href="{{ url('/tags')}}">Từ khóa</a></li>
                            @endif

                            @if ($currentUser->hasAnyAccess(['posts.*']))
                                <li><a href="{{ url('/posts')}}">Bài viết</a></li>
                            @endif

                            @if ($currentUser->hasAnyAccess(['questions.*']))
                                <li><a href="{{ url('/questions')}}">Câu hỏi</a></li>
                            @endif

                            @if ($currentUser->hasAnyAccess(['videos.*']))
                                <li><a href="{{ url('/videos')}}">Videos</a></li>
                            @endif

                            @if ($currentUser->hasAnyAccess(['products.*']))
                                <li><a href="{{ url('/products')}}">Sản phẩm</a></li>
                            @endif

                            @if ($currentUser->hasAnyAccess(['stores.*']))
                                <li><a href="{{ url('/stores')}}">Phân phối</a></li>
                            @endif
                        </ul>
                    </li>

                @endif


                @if ($currentUser->hasAnyAccess(['orders.*', 'contacts.*']))

                <li class="has-submenu">
                    <a href="#"><i class="md md-layers"></i>Đơn hàng và Liên hệ</a>
                    <ul class="submenu">

                        @if ($currentUser->hasAnyAccess(['orders.*']))
                            <li><a href="{{ url('/orders')}}">Đơn hàng</a></li>
                        @endif

                        @if ($currentUser->hasAnyAccess(['contacts.*']))
                            <li><a href="{{ url('/contacts')}}">Liên hệ</a></li>
                        @endif
                    </ul>
                </li>

                @endif

                @if ($currentUser->isAdmin())

                    <li class="has-submenu">
                        <a href="#"><i class="md md-folder"></i>Thiết lập</a>
                        <ul class="submenu">
                            <li><a href="{{ url('/positions')}}">Vị trí Banners</a></li>
                            <li><a href="{{ url('/settings')}}">Thiết lập Frontend</a></li>
                            @if (env('ENABLE_SHARING') == 1)
                                <li><a href="{{ url('/shares')}}">Chia sẻ Người dùng</a></li>
                            @endif

                            @if (env('ENABLE_COMMENT') == 1)
                                <li><a href="{{ url('/comments')}}">Bình luận</a></li>
                            @endif
                        </ul>
                    </li>


                    <li class="has-submenu">
                        <a href="#"><i class="md md-settings"></i>Hệ thống</a>
                        <ul class="submenu">
                            <li><a href="{{ url('/users')}}">Thành viên</a></li>
                            <li><a href="{{ url('/roles') }}">Loại thành viên</a></li>
                            <li><a href="{{ url('/permissions') }}">Các quyền</a></li>
                        </ul>
                    </li>

                @endif
            </ul>
            <!-- End navigation menu        -->
        </div>
    </div> <!-- end container -->
</div> <!-- end navbar-custom -->
