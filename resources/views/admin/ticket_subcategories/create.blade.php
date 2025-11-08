@extends('layouts.admin')
@section('page_title', 'Create Ticket Subcategory')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-3 border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-diagram-2-fill me-2"></i> Add New Ticket Subcategory
            </h5>
            <a href="{{ route('admin.ticket_subcategories.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card-body px-4 py-4">
            <form action="{{ route('admin.ticket_subcategories.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                {{-- Main Category --}}
                <div class="mb-3">
                    <label for="main_category_id" class="form-label fw-semibold text-secondary">Main Category</label>
                    <select name="main_category_id" id="main_category_id" class="form-select rounded-3" required>
                        <option value="">-- Select Main Category --</option>
                        @foreach($mainCategories as $category)
                            <option value="{{ $category->id }}" {{ old('main_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('main_category_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Subcategory Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold text-secondary">Subcategory Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control rounded-3" 
                        value="{{ old('name') }}" 
                        placeholder="Enter subcategory name" 
                        required
                    >
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Active Toggle --}}
                <input type="hidden" name="is_active" value="0">
                <div class="form-check form-switch mb-3">
                    <input 
                        class="form-check-input" 
                        type="checkbox" 
                        name="is_active" 
                        id="is_active" 
                        value="1" 
                        {{ old('is_active', isset($subcategory) ? $subcategory->is_active : 1) ? 'checked' : '' }}
                    >
                    <label class="form-check-label text-secondary fw-semibold" for="is_active">
                        Active
                    </label>
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.ticket_subcategories.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle me-1"></i> Save Subcategory
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
