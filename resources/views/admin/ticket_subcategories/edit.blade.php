@extends('layouts.admin')
@section('page_title', 'Edit Ticket Subcategory')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-pencil-square me-2"></i> Edit Ticket Subcategory
            </h5>
            <a href="{{ route('admin.ticket_subcategories.index') }}" class="btn btn-outline-dark btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card-body px-4 py-4">
            <form action="{{ route('admin.ticket_subcategories.update', $subcategory->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                {{-- Main Category --}}
                <div class="mb-3">
                    <label for="main_category_id" class="form-label fw-semibold text-secondary">Main Category</label>
                    <select name="main_category_id" id="main_category_id" class="form-select rounded-3" required>
                        <option value="">-- Select Main Category --</option>
                        @foreach($mainCategories as $category)
                            <option value="{{ $category->id }}" 
                                {{ $subcategory->main_category_id == $category->id ? 'selected' : '' }}>
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
                        value="{{ old('name', $subcategory->name) }}" 
                        placeholder="Enter subcategory name"
                        required
                    >
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Active Toggle --}}
                <input type="hidden" name="is_active" value="0">
                <div class="form-check form-switch mb-4">
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

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.ticket_subcategories.index') }}" class="btn btn-outline-secondary px-3">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle me-1"></i> Update Subcategory
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
