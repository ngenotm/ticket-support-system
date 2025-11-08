@extends('layouts.admin')
@section('page_title', 'Ticket Services')

@section('content')
<div class="card shadow-sm rounded-2 border-0">
    <div class="card-header bg-light d-flex justify-content-between align-items-center border-bottom">
        <h5 class="mb-0 text-dark fw-semibold">
            <i class="fas fa-cogs me-2 text-primary"></i> Ticket Services
        </h5>
        <a href="{{ route('admin.ticket_services.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="fas fa-plus me-1"></i> Add Service
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light text-secondary fw-semibold">
                    <tr>
                        <th>ID</th>
                        <th>Service Name</th>
                        <th>Subcategory</th>
                        <th>Main Category</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td class="text-muted">{{ $service->id }}</td>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->subcategory->name ?? '-' }}</td>
                            <td>{{ $service->subcategory->mainCategory->name ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $service->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.ticket_services.edit', $service->id) }}" 
                                       class="btn btn-sm btn-warning text-white px-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.ticket_services.destroy', $service->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Delete this service?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger px-2">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-2x d-block mb-2"></i>
                                No services found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection
