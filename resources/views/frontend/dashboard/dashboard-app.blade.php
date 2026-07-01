@extends('frontend.layouts.app')

@section('contents')
    <x-frontend.breadcrumb :items="[['label' => 'Home', 'url' => '/'], ['label' => 'Dashboard']]" />
    <div class="page-content pt-70 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-menu">
                                <ul class="nav flex-column" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href=""><i
                                                class="fi-rs-settings-sliders mr-10"></i>Tổng quan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#orders"><i
                                                class="fi-rs-shopping-bag mr-10"></i>Đơn hàng</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#track-orders"
                                            class="fi-rs-shopping-cart-check mr-10"></i>Theo dõi đơn</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#address"><i class="fi-rs-marker mr-10"></i>Địa chỉ</a>
                                    </li>
                                    <li class="nav-item"> <!-- link để route xử lý profile-->
                                        <a class="nav-link" href="{{ route('profile') }}"><i class="fi-rs-user mr-10"></i>Thông tin tài khoản</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#wishlist-tab"><i class="fi-rs-heart mr-10"></i>
                                             Yêu thích</a>
                                    </li>
                                    <li class="nav-item"> <!--even.preventDefault giúp ngăn chuyển hướng thẻ a,click logout,khiến route logout xử lý -->
                                        <a class="nav-link" onclick="event.preventDefault(); $('.form-logout').submit()" href="login.html"><i class="fi-rs-sign-out mr-10"></i>Đăng xuất</a>
                                    </li>
                                    <form class="form-logout" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                    </form>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content account dashboard-content pl-50">

                                @yield('dashboard_contents')




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
