@extends('layouts.admin')
@section('page_title', 'Manage App Users')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold text-primary mb-0">App Users</h4>
        <a href="{{ route('admin.app_user.create') }}" class="btn btn-success btn-sm px-3 shadow-sm">
            + Add New User
        </a>
    </div>

    {{-- ✅ Success Message --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm small py-2 mb-3">
            <strong>✅</strong> {{ session('success') }}
        </div>
    @endif

    <div class="card border-light shadow-sm rounded-3">
        <div class="card-body table-responsive p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom">
                    <tr class="text-secondary small text-uppercase">
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Panel</th>
                        <th>Status</th>
                        <th width="120" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="align-middle">
                            <td class="fw-semibold text-muted">{{ $user->id }}</td>
                            <td>{{ $user->user }}</td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>{{ $user->role->role_name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $user->panel }}
                                </span>
                            </td>
                            <td>
                                <span class="badge px-3 py-2 bg-{{ $user->status == 'Active' ? 'success' : 'secondary' }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.app_user.edit', $user->id) }}" 
                                   class="btn btn-sm btn-outline-primary rounded-pill shadow-sm px-3">
                                   Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted py-3">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<style>
    /* === Flat Zoho-like Look === */
    .container {
        max-width: 1100px;
    }

    .card {
        border-radius: 10px;
        background: #fff;
    }

    .table {
        border-collapse: separate;
        border-spacing: 0 5px;
    }

    .table thead th {
        font-weight: 600;
        letter-spacing: 0.03em;
        background-color: #f9fafb !important;
    }

    .table tbody tr {
        transition: all 0.2s ease-in-out;
    }

    .table tbody tr:hover {
        background-color: #f5f9ff;
    }

    .btn-success {
        background-color: #00b386;
        border: none;
        font-weight: 500;
    }

    .btn-success:hover {
        background-color: #00a077;
    }

    .btn-outline-primary {
        border: 1px solid #d3d7de;
        color: #2d5be3;
        background: #fff;
        transition: all 0.2s ease-in-out;
    }

    .btn-outline-primary:hover {
        background-color: #2d5be3;
        color: #fff;
    }

    .badge {
        font-size: 0.75rem;
        font-weight: 500;
        border-radius: 6px;
    }

    .alert {
        border-radius: 8px;
        font-size: 0.9rem;
    }
</style>
