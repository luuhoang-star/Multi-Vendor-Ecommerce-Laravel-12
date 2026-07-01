@extends('frontend.dashboard.dashboard-app')

@section('dashboard_contents')
    <div id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
        <div class="card">
            <div class="card-header p-0">
                <h5>Thông tin tài khoản</h5>
            </div>
            <div class="card-body p-0">
                <p>Bạn có thể chỉnh sửa thông tin tài khoản của mình ở đây.</p>
                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mt-30">
                        <x-input-image imageUploadId="image-upload" imagePreviewId="image-preview" imageLabelId="image-label" name="avatar" :image="auth('web')->user()->avatar" />
                        <div class="form-group col-md-12">
                            <label>Tên <span class="required">*</span></label>
                            <input required="" class="form-control" name="name" type="text"
                                value="{{ auth('web')->user()->name }}" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="form-group col-md-12">
                            <label>Địa chỉ email <span class="required">*</span></label>
                            <input required="" class="form-control" name="email" type="email"
                                value="{{ auth('web')->user()->email }}" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>



                        <div class="col-md-12">
                            <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit"
                                value="Submit">Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="card mt-4">
            <div class="card-header p-0">
                <h5>Thay đổi mật khẩu</h5>
            </div>
            <div class="card-body p-0">
                <p>Bạn có thể chỉnh sửa mật khẩu của mình ở đây.</p>
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="row mt-30">


                        <div class="form-group col-md-12">
                            <label>Mật khẩu hiện tại <span class="required">*</span></label>
                            <input required="" class="form-control" name="current_password" type="password" />
                            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                        </div>
                        <div class="form-group col-md-12">
                            <label>Mật khẩu mới <span class="required">*</span></label>
                            <input required="" class="form-control" name="password" type="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="form-group col-md-12">
                            <label>Xác nhận mật khẩu <span class="required">*</span></label>
                            <input required="" class="form-control" name="password_confirmation" type="password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>


                        <div class="col-md-12">
                            <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit"
                                value="Submit">Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts') <!--đẩy đoạn code này lên stacks -->
    <script type="text/javascript">
        $(document).ready(function() {
            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "Chọn tệp", // Default: Choose File
                label_selected: "Đổi tệp", // Default: Change File
                no_label: false // Default: false
            });
        });
    </script>
@endpush
