@extends('layouts.admin')

@section('page_title', 'Roles Management')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-semibold text-secondary">
                <i class="bi bi-people-fill me-2 text-primary"></i> Roles Management
            </h4>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary rounded-3">
                <i class="bi bi-person-plus me-1"></i> Add Role
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success rounded-3 shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-secondary">
                            <th class="fw-semibold">#</th>
                            <th class="fw-semibold">Role Name</th>
                            <th class="fw-semibold">Description</th>
                            <th class="fw-semibold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td class="fw-semibold">{{ $role->role_name }}</td>
                                <td class="text-muted">{{ $role->description ?? '—' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.roles.edit', $role->id) }}" 
                                       class="btn btn-sm btn-outline-warning rounded-3 me-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="btn btn-sm btn-outline-danger rounded-3"
                                            onclick="return confirm('Are you sure you want to delete this role?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-2"></i> No roles found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
