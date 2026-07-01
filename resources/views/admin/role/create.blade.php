@extends('admin.layouts.app')

@section('contents')
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tạo vai trò</h3>
                <div class="card-actions">
                    <a href="{{ route('admin.role.index') }}" class="btn btn-primary">Trở về</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.role.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Tên quyền (vai trò)</label>
                                <input type="text" class="form-control" name="role" value="">
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($permissions as $groupName => $permission)
                            <div class="col-md-4 mb-3">
                                <h3>{{ $groupName }}</h3>
                                @foreach ($permission as $item)
                                    <label for="" class="form-check">
                                        <input type="checkbox" class="form-check-input" value="{{ $item->name }}"
                                            name="permissions[]">
                                        <span class="form-check-label">{{ $item->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </form>
                <div class="card-footer">
                    <button class="btn btn-primary mt-3" onclick="$('form').submit()">Tạo vai trò</button>
                </div>
            </div>
        </div>
    </div>
@endsection
