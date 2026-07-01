@extends('admin.layouts.app')

@section('contents')
    <div class="container-xl">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Cập nhật vai trò</h3>

                <div class="card-actions">
                    <a href="{{ route('admin.role.create') }}" class="btn btn-primary">
                        Tạo vai trò
                    </a>
                </div>
            </div>


            <form action="{{ route('admin.role.update', $role) }}" method="POST">

                @csrf
                @method('PUT')


                <div class="card-body">

                    {{-- Role name --}}
                    <div class="row">

                        <div class="col-md-12">

                            <div class="mb-3">

                                <label class="form-label required">
                                    Tên vai trò
                                </label>


                                <input type="text" class="form-control" name="role"
                                    value="{{ old('role', $role->name) }}">


                                <x-input-error :messages="$errors->get('role')" class="mt-2" />

                            </div>

                        </div>

                    </div>



                    {{-- Permissions --}}
                    <div class="row">


                        @foreach ($permissions as $groupName => $permission)
                            <div class="col-md-4 mb-3">

                                <h3>
                                    {{ $groupName }}
                                </h3>



                                @foreach ($permission as $item)
                                    <label class="form-check">


                                        <input type="checkbox" class="form-check-input" name="permissions[]"
                                            value="{{ $item->name }}" @checked($role->hasPermissionTo($item->name))>


                                        <span class="form-check-label">

                                            {{ $item->name }}

                                        </span>


                                    </label>
                                @endforeach


                            </div>
                        @endforeach


                        {{-- lỗi permission --}}
                        <x-input-error :messages="$errors->get('permissions')" class="mt-2" />


                    </div>



                </div>



                <div class="card-footer">

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                </div>


            </form>


        </div>

    </div>
@endsection
