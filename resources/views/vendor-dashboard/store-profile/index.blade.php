@extends('vendor-dashboard.layouts.app')

@section('contents')
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update Store Profile</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('vendor.store-profile.update', 1) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        {{-- Cột trái: ảnh đại diện --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Logo</label>
                                <x-input-image imageUploadId="image-upload" imagePreviewId="image-preview"
                                    imageLabelId="image-label" name="avatar" :image="asset($store?->logo)" />
                                <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Banner</label>
                                <x-input-image imageUploadId="image-upload-two" imagePreviewId="image-preview-two"
                                    imageLabelId="image-label-two" name="banner" :image="asset($store?->banner)" />
                                <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Cột phải: name + email --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Name</label>
                                <input type="text" name="name" value="{{ $store?->name }}">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" value="{{ $store?->phone }}">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Email</label>
                                <input type="text" name="email" value="{{ $store?->email }}">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                        </div>


                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" value="{{ $store?->address }}">
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Short Description</label>
                                <textarea name="short_description">{!! $store?->short_description !!}</textarea>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Long Description</label>
                                <textarea name="long_description" id="editor">{!! $store?->long_description !!}</textarea>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                        </div>

                    </div> {{-- đóng row --}}

                    <button type="submit" class="btn btn-primary">Update Account</button>
                </form>
            </div>
        </div>



    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.uploadPreview({
                input_field: "#image-upload",
                preview_box: "#image-preview",
                label_field: "#image-label",
                label_default: "Choose File",
                label_selected: "Change File",
                no_label: false
            });
            $.uploadPreview({
                input_field: "#image-upload-two",
                preview_box: "#image-preview-two",
                label_field: "#image-label-two",
                label_default: "Choose File",
                label_selected: "Change File",
                no_label: false
            });

        });
    </script>
@endpush
