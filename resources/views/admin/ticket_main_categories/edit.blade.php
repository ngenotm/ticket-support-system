@extends('layouts.admin')

@section('page_title', 'Edit Ticket Main Category')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h4 class="fw-semibold text-secondary mb-0">
            <i class="bi bi-pencil-square me-2 text-primary"></i> Edit Main Category
        </h4>
        <a href="{{ route('admin.ticket_main_categories.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    {{-- Form Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body px-4 py-4">
            <form method="POST" action="{{ route('admin.ticket_main_categories.update', $category->id) }}" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                {{-- Category Name --}}
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold text-secondary">
                        Category Name <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control form-control-lg border-secondary-subtle rounded-2"
                           value="{{ old('name', $category->name) }}"
                           placeholder="Enter category name"
                           required>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Active Switch --}}
                <div class="form-check form-switch mb-4 ps-0">
                    <input type="hidden" name="is_active" value="0">
                    <div class="d-flex align-items-center">
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                id="is_active"
                                value="1"
                                {{ old('is_active', (int)$category->is_active) == 1 ? 'checked' : '' }}
                            >
                        </div>
                        <label class="ms-2 text-secondary" for="is_active">Active</label>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.ticket_main_categories.index') }}" class="btn btn-light border text-secondary fw-semibold px-4">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary fw-semibold px-4">
                        <i class="bi bi-check-circle me-1"></i> Update Category
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
