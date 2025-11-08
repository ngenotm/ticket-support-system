@extends('layouts.admin')

@section('page_title', 'Ticket Main Categories')

@section('content')
<div class="container-fluid py-4">

    <!-- Header Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h4 class="fw-semibold text-dark mb-0">🎫 Ticket Main Categories</h4>
        <div>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm me-2">← Back</a>
            <a href="{{ route('admin.ticket_main_categories.create') }}" class="btn btn-primary btn-sm">
                + Add Category
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-uppercase small text-muted">
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Name</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 160px;">Created</th>
                        <th style="width: 160px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="fw-medium text-secondary">{{ $category->id }}</td>
                            <td class="fw-semibold">{{ $category->name }}</td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success bg-opacity-75 px-3 py-1">Active</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-75 px-3 py-1">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $category->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.ticket_main_categories.edit', $category->id) }}" 
                                   class="btn btn-outline-primary btn-sm px-3 me-1">
                                    Edit
                                </a>
                                <form action="{{ route('admin.ticket_main_categories.destroy', $category->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3"
                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
    /* Zoho-like Professional Style */
    .table th {
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }

    .table td {
        vertical-align: middle;
        color: #444;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .btn {
        font-size: 0.875rem;
        border-radius: 4px !important;
    }

    .btn-primary {
        background-color: #0066cc;
        border-color: #0066cc;
    }

    .btn-outline-primary:hover {
        background-color: #0066cc;
        color: #fff;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .card {
        border-radius: 6px;
    }

    .alert {
        border-radius: 4px;
    }
</style>
@endsection
