@extends('frontend.layouts.app')

@section('contents')
    <x-frontend.breadcrumb :items="[['label' => 'Home', 'url' => '/'], ['label' => 'Login']]" />
    <div class="page-content pt-150 pb-135">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                    <div class="row">
                        <div class="col-lg-6 pr-30 d-none d-lg-block">
                            <img class="border-radius-15" src="{{ asset('assets/frontend/dist/imgs/page/login-1.png') }}"
                                alt="" />
                        </div>
                        <div class="col-lg-6 col-md-8">
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <div class="login_wrap widget-taber-content background-white">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1">
                                        <h1 class="mb-5">Đăng nhập</h1>
                                        <p class="mb-30">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký
                                                tại đây</a></p>
                                    </div>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" required="" name="email" placeholder="Email của bạn"
                                                value="{{ old('email') }}" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="password" name="password"
                                                placeholder="Your password *" />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>

                                        <div class="login_footer form-group mb-50">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" id="exampleCheckbox1"
                                                        value="" name="remember" />
                                                    <label class="form-check-label" for="exampleCheckbox1"><span>Ghi nhớ
                                                            đăng nhập
                                                        </span></label>
                                                </div>
                                            </div>
                                            <a class="text-muted" href="{{ route('password.request') }}">Quên mật khẩu ?</a>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-heading btn-block hover-up"
                                                name="login">Đăng nhập</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
