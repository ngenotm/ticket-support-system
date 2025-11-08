@extends('layouts.admin')
@section('page_title', 'Add Role')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-semibold text-secondary">
                <i class="bi bi-person-plus me-2 text-success"></i> Add New Role
            </h4>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.roles.store') }}" method="POST" class="row g-3">
                @csrf

                <div class="col-md-6">
                    <label for="role_name" class="form-label fw-semibold text-secondary">
                        Role Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="role_name" id="role_name" class="form-control rounded-3" placeholder="e.g. Support Agent" required>
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-semibold text-secondary">Description</label>
                    <textarea name="description" id="description" class="form-control rounded-3" rows="3" placeholder="Optional: Describe this role’s purpose"></textarea>
                </div>

                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary rounded-3">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-success rounded-3">
                        <i class="bi bi-check-circle"></i> Save Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
