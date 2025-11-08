@extends('layouts.admin')

@section('page_title', 'Site Users')

@section('content')
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center rounded-top-3">
        <h5 class="mb-0 text-secondary fw-semibold">
            <i class="bi bi-people-fill me-2 text-primary"></i> All Site Users
        </h5>
        <a href="{{ url('admin/site_user/create') }}" class="btn btn-primary btn-sm rounded-3">
            <i class="bi bi-person-plus"></i> Add New User
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success rounded-3 d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle text-nowrap mb-0">
                <thead class="table-light text-secondary">
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Status</th>
                        <th>Login Type</th>
                        <th>Last Login</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="fw-medium">{{ $user->id }}</td>
                            <td>
                                @php
                                    $borderColor = $user->activeSubscription?->plan?->border_color ?? '#ddd';
                                @endphp

                                @if($user->photo_url)
                                    <img src="{{ asset($user->photo_url) }}"
                                         alt="User"
                                         title="{{ $user->activeSubscription?->plan?->title ?? 'No active plan' }}"
                                         width="42" height="42"
                                         class="rounded-circle border border-3"
                                         style="border-color: {{ $borderColor }} !important;">
                                @else
                                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                                         style="width: 42px; height: 42px; border: 3px solid {{ $borderColor }}">
                                         <i class="bi bi-person text-muted"></i>
                                    </div>
                                @endif
                            </td>

                            <td class="fw-semibold">{{ $user->full_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-info text-dark px-2">{{ $user->user_type }}</span></td>

                            <td>
                                <form action="{{ url('admin/site_user/status/' . $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm rounded-pill px-3 {{ $user->status == 'Active' ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $user->status }}
                                    </button>
                                </form>
                            </td>

                            <td>{{ $user->login_type ?? 'N/A' }}</td>
                            <td>{{ $user->last_login_at ?? '—' }}</td>

                            <td class="text-center">
                                <a href="{{ url('admin/site_user/edit/' . $user->id) }}" 
                                   class="btn btn-sm btn-outline-warning rounded-3 me-1" 
                                   title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ url('admin/site_user/delete/' . $user->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-person-dash fs-4 d-block mb-2"></i>
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        background-color: #fff;
    }
    .table thead th {
        font-weight: 600;
        font-size: 0.9rem;
        border-bottom: 2px solid #dee2e6;
    }
    .table td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #fff;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: #fff;
    }
</style>
@endpush
