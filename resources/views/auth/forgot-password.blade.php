{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
@extends('frontend.layouts.app')

@section('contents')
    <x-frontend.breadcrumb :items="[['label' => 'Home', 'url' => '/'], ['label' => 'Quên mật khẩu']]" />
    <div class="page-content pt-150 pb-135">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                    <div class="row">

                        <div class="col-lg-6 col-md-8 offset-lg-3">
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <div class="login_wrap widget-taber-content background-white">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1">
                                        <h3 class="mb-5">Quên mật khẩu</h3>
                                        <p class="mb-30">
                                            {{ __('Quên mật khẩu? Hãy nhập địa chỉ email của bạn. Chúng tôi sẽ gửi cho bạn liên kết đặt lại mật khẩu để tạo mật khẩu mới.') }}
                                        </p>
                                    </div>
                                    <form method="post" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" required="" name="email" placeholder="Email của bạn"
                                                value="{{ old('email') }}" />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-heading btn-block hover-up"
                                                name="login">{{ __('Gửi liên kết đặt lại mật khẩu') }}</button>
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
