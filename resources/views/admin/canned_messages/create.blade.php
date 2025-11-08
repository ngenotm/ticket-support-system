@extends('layouts.admin')
@section('page_title', 'Add Canned Message')

@section('content')
<div class="container mt-4">
    <h4 class="fw-semibold text-primary mb-3">➕ Add New Canned Message</h4>

    <form action="{{ route('admin.canned_messages.store') }}" method="POST" class="mb-5">
        @csrf

        <div class="card border-0 shadow-sm rounded-3 p-4">
            <div class="row g-3">

                {{-- Title --}}
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Title</label>
                    <input type="text" name="title" class="form-control flat-input" required>
                </div>

                {{-- Subject --}}
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Subject</label>
                    <input type="text" name="subject" class="form-control flat-input">
                </div>

                {{-- Type --}}
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Type</label>
                    <select name="type" class="form-select flat-input" required>
                        <option value="text">Text</option>
                        <option value="html">HTML</option>
                        <option value="markdown">Markdown</option>
                    </select>
                </div>

                {{-- Category --}}
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Category</label>
                    <select name="category_id" id="category_id" class="form-select flat-input">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Subcategory --}}
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Subcategory</label>
                    <select name="subcategory_id" id="subcategory_id" class="form-select flat-input">
                        <option value="">Select Subcategory</option>
                    </select>
                </div>

                {{-- Service --}}
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-secondary">Service</label>
                    <select name="service_id" id="service_id" class="form-select flat-input">
                        <option value="">Select Service</option>
                    </select>
                </div>

                {{-- Body --}}
                <div class="col-12">
                    <label class="form-label small fw-semibold text-secondary">Body</label>
                    <textarea name="body" rows="5" class="form-control flat-input" required></textarea>
                </div>

                {{-- Is Global --}}
                <div class="col-md-4 form-check mt-3">
                    <input type="checkbox" name="is_global" id="is_global" class="form-check-input">
                    <label for="is_global" class="form-check-label fw-semibold small text-secondary">Make Global</label>
                </div>

                {{-- Status --}}
                <div class="col-md-4 mt-3">
                    <label class="form-label small fw-semibold text-secondary">Status</label>
                    <select name="status" class="form-select flat-input">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4 gap-2">
                <a href="{{ route('admin.canned_messages.index') }}" class="btn btn-light border shadow-sm px-4">
                    Cancel
                </a>
                <button type="submit" class="btn btn-success px-4">
                    Save
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const catSelect = document.getElementById('category_id');
    const subSelect = document.getElementById('subcategory_id');
    const serviceSelect = document.getElementById('service_id');

    function clearSelect(select, placeholder) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
    }

    async function fetchOptions(url) {
        try {
            const response = await fetch(url, { headers: { 'Accept': 'application/json' } });
            return response.ok ? await response.json() : [];
        } catch {
            return [];
        }
    }

    async function loadSubcategories(categoryId) {
        clearSelect(subSelect, 'Select Subcategory');
        clearSelect(serviceSelect, 'Select Service');
        if (!categoryId) return;
        const subs = await fetchOptions(`/admin/subcategories/${categoryId}`);
        subs.forEach(sub => {
            const opt = document.createElement('option');
            opt.value = sub.id;
            opt.textContent = sub.name;
            subSelect.appendChild(opt);
        });
    }

    async function loadServices(subcategoryId) {
        clearSelect(serviceSelect, 'Select Service');
        if (!subcategoryId) return;
        const services = await fetchOptions(`/admin/services/${subcategoryId}`);
        services.forEach(srv => {
            const opt = document.createElement('option');
            opt.value = srv.id;
            opt.textContent = srv.name;
            serviceSelect.appendChild(opt);
        });
    }

    catSelect.addEventListener('change', () => loadSubcategories(catSelect.value));
    subSelect.addEventListener('change', () => loadServices(subSelect.value));
});
</script>
@endpush

<style>
/* === Flat, Business-Professional Style === */
.card {
    border-radius: 10px;
    background-color: #fff;
}

.flat-input {
    border: 1px solid #d9d9d9;
    border-radius: 6px;
    font-size: 0.9rem;
    transition: all 0.2s ease-in-out;
}

.flat-input:focus {
    border-color: #2d5be3;
    box-shadow: 0 0 0 2px rgba(45,91,227,0.15);
}

.flat-input:hover {
    border-color: #b8b8b8;
}

.btn-success {
    background-color: #00b386;
    border: none;
    font-weight: 500;
}

.btn-success:hover {
    background-color: #009e75;
}

.btn-light {
    color: #333;
    background-color: #f8f9fa;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.btn-light:hover {
    background-color: #ebedef;
}

label.form-label {
    margin-bottom: 0.3rem;
}

textarea {
    resize: vertical;
}
</style>
