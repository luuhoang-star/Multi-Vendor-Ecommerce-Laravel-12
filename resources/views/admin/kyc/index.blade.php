@extends('admin.layouts.app')

@section('contents')
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Kyc Requests</h3>
                <div class="card-actions">
                    <a href="#" class="btn btn-primary btn-3">
                        <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-2">
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Add new
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Full   Name</th>
                                <th>Email</th>
                                <th>Date of birth</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kycRequests as $kycRequest)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kycRequest->full_name }}a</td>
                                <td class="text-secondary">{{ $kycRequest->user->email }}</td> <!-- Lấy email của User thuộc về KycRequest này. -->
                                <td class="text-secondary">{{ $kycRequest->date_of_birth }}</td>
                                <td class="text-secondary">{{ $kycRequest->gender }}</td>
                                @if($kycRequest->status == 'pending')
                                <td class="text-secondary"><span class="badge bg-warning-lt">Đang chờ</span></td>
                                @elseif($kycRequest->status == 'approved')
                                      <td class="text-secondary"><span class="badge bg-success-lt">Được duyệt</span></td>
                                @else
                                      <td class="text-secondary"><span class="badge bg-danger-lt">Bị từ chối</span></td>
                                @endif
                                <td><a href="{{ route('admin.kyc.show', $kycRequest->id) }}">View</a></td> <!--Tạo url tới route có tên kyc.show và truyền đối tượng $kycRequest vào route đó -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            
            <div class="card-footer">
                {{ $kycRequests->links() }}
            </div>
            </div>
        </div>
    </div>
@endsection
