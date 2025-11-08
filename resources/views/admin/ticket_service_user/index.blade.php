@extends('layouts.admin')

@section('page_title', 'Service–User Links')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h4 class="fw-semibold text-dark mb-0">🔗 Service–User Links</h4>
        <a href="{{ route('admin.ticket_service_user.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-circle me-1"></i> Add New Link
        </a>
    </div>

    <!-- Alerts -->
    @if (session('success'))
        <div class="alert alert-success border-0 rounded-2 py-2 px-3 small">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small text-uppercase">
                    <tr>
                        <th class="ps-3" width="60">ID</th>
                        <th>Service</th>
                        <th>User</th>
                        <th>Created At</th>
                        <th class="text-end pe-3" width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($links as $link)
                        <tr>
                            <td class="ps-3 text-muted">{{ $link->id }}</td>
                            <td class="fw-medium">{{ $link->service->name ?? '—' }}</td>
                            <td>{{ $link->SiteUser->username ?? '—' }}</td>
                            <td class="text-muted small">{{ $link->created_at->format('Y-m-d') }}</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.ticket_service_user.edit', $link->id) }}" class="btn btn-sm btn-outline-warning me-2">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.ticket_service_user.destroy', $link->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this link?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No service-user links found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Inline Styles for Professional Layout -->
<style>
    .card {
        border-radius: 6px;
        background-color: #fff;
    }

    table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-light {
        background-color: #f8f9fa !important;
    }

    th {
        font-weight: 600 !important;
        font-size: 0.78rem;
        letter-spacing: 0.4px;
    }

    td {
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .btn {
        border-radius: 4px !important;
        font-size: 0.8rem;
        padding: 0.35rem 0.6rem;
    }

    .btn-outline-warning {
        border-color: #ffcc00;
        color: #b8860b;
    }

    .btn-outline-warning:hover {
        background-color: #fff3cd;
    }

    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #f8d7da;
    }

    .border-bottom {
        border-color: #e0e0e0 !important;
    }
</style>
@endsection
