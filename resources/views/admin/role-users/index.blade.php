@extends('admin.layouts.app')

@section('contents')
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách người dùng & quyền</h3>
                <div class="card-actions">
                    <a href="{{ route('admin.role-users.create') }}" class="btn btn-primary">Tạo người dùng</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>STT.</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($admins as $admin)
                                <tr>
                                    <td> {{ $loop->iteration }}</td>
                                    <td> {{ $admin->name }}</td>
                                    <td> {{ $admin->email }}</td>
                                    <td>
                                        @foreach ($admin->getRoleNames() as $role)
                                            <span class="badge bg-primary-lt">{{ $role }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if (!$admin->hasRole('Super Admin'))
                                            <a href="{{ route('admin.role-users.edit', $admin) }}">Sửa</a>
                                            <a class="text-danger delete-item"
                                                href="{{ route('admin.role-users.destroy', $admin) }}">Xóa</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Không có vai trò nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    {{-- {{ $kycRequests->links() }} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
