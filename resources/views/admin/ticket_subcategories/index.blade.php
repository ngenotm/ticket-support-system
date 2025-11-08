@extends('layouts.admin')
@section('page_title', 'Ticket Subcategories')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0 fw-semibold text-secondary">Ticket Subcategories</h4>
        <a href="{{ route('admin.ticket_subcategories.create') }}" class="btn btn-primary shadow-sm">
            + Add New
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Table Card -->
    <div class="card shadow-sm rounded-2 border-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-secondary fw-semibold">#</th>
                        <th class="text-secondary fw-semibold">Subcategory Name</th>
                        <th class="text-secondary fw-semibold">Main Category</th>
                        <th class="text-secondary fw-semibold">Status</th>
                        <th class="text-secondary fw-semibold">Created</th>
                        <th class="text-end text-secondary fw-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subcategories as $subcategory)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-medium text-dark">{{ $subcategory->name }}</td>
                            <td>{{ $subcategory->mainCategory->name ?? 'N/A' }}</td>
                            <td>
                                @if($subcategory->is_active)
                                    <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                        Active
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td>{{ $subcategory->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.ticket_subcategories.edit', $subcategory->id) }}" 
                                       class="btn btn-warning text-dark">Edit</a>
                                    <form action="{{ route('admin.ticket_subcategories.destroy', $subcategory->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this subcategory?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-folder-x fs-3 d-block mb-2"></i>
                                No subcategories found.<br>
                                <a href="{{ route('admin.ticket_subcategories.create') }}" class="text-primary text-decoration-none">
                                    Add your first subcategory
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($subcategories->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $subcategories->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
