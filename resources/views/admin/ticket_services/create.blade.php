@extends('layouts.admin')
@section('page_title', 'Add Ticket Service')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-plus-circle me-2"></i> Add Ticket Service
            </h5>
            <a href="{{ route('admin.ticket_services.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body">
            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="alert alert-danger rounded-2">
                    <strong><i class="bi bi-exclamation-triangle-fill"></i> Please fix the following:</strong>
                    <ul class="mt-2 mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.ticket_services.store') }}" method="POST" class="row g-3">
                @csrf

                {{-- Main Category --}}
                <div class="col-md-6">
                    <label for="main_category_id" class="form-label fw-semibold text-secondary">Main Category</label>
                    <select id="main_category_id" class="form-select rounded-3" required>
                        <option value="">-- Select Main Category --</option>
                        @foreach($mainCategories as $main)
                            <option value="{{ $main->id }}">{{ $main->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Subcategory --}}
                <div class="col-md-6">
                    <label for="subcategory_id" class="form-label fw-semibold text-secondary">Subcategory</label>
                    <select name="subcategory_id" id="subcategory_id" class="form-select rounded-3" required>
                        <option value="">-- Select Subcategory --</option>
                    </select>
                </div>

                {{-- Service Name --}}
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold text-secondary">Service Name</label>
                    <input type="text" name="name" id="name" class="form-control rounded-3"
                        placeholder="Enter service name" required>
                </div>

                {{-- Status --}}
                <div class="col-md-6 d-flex align-items-center">
                    <input type="hidden" name="is_active" value="0">
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="is_active"
                            id="is_active"
                            value="1"
                            {{ old('is_active', 1) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_active">Active</label>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle me-1"></i> Save
                    </button>
                    <a href="{{ route('admin.ticket_services.index') }}" class="btn btn-secondary px-4">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Dependent Dropdown Script --}}
<script>
document.getElementById('main_category_id').addEventListener('change', function () {
    const mainId = this.value;
    const subSelect = document.getElementById('subcategory_id');
    subSelect.innerHTML = '<option value="">Loading...</option>';
    if (!mainId) return;

    fetch(`/admin/ticket_subcategories/${mainId}`)
        .then(res => res.json())
        .then(data => {
            subSelect.innerHTML = '<option value="">-- Select Subcategory --</option>';
            data.forEach(sub => {
                subSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
            });
        });
});
</script>
@endsection
