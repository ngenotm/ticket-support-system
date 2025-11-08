@extends('layouts.admin')
@section('page_title', 'Create Ticket')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold text-secondary mb-0">➕ Create New Ticket</h4>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Tickets
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <form action="{{ route('admin.tickets.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf

                {{-- User Email --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">User Email</label>
                    <select name="ticket_user" id="ticket_user" class="form-select" required>
                        <option value="">Select User</option>
                        @foreach($siteUsers as $user)
                            <option value="{{ $user->id }}" {{ old('ticket_user') == $user->id ? 'selected' : '' }}>
                                {{ $user->email }} ({{ $user->username }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Category --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Category</label>
                    <select name="cat_id" id="cat_id" class="form-select" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('cat_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Subcategory --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Subcategory</label>
                    <select name="services_cat_id" id="subcat_id" class="form-select">
                        <option value="">Select Subcategory</option>
                    </select>
                </div>

                {{-- Service --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Service</label>
                    <select name="services" id="service_id" class="form-select">
                        <option value="">Select Service</option>
                    </select>
                </div>

                {{-- Service URL --}}
                <div class="col-md-8">
                    <label class="form-label fw-semibold text-secondary">Service URL</label>
                    <input type="url" name="service_url" class="form-control rounded-3" 
                           value="{{ old('service_url') }}" placeholder="https://example.com">
                </div>

                {{-- Ticket Subject --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold text-secondary">Ticket Subject</label>
                    <input type="text" name="title" class="form-control rounded-3" 
                           value="{{ old('title') }}" placeholder="Enter short subject" required>
                </div>

                {{-- Ticket Description --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold text-secondary">Ticket Body</label>
                    <textarea name="ticket_body" class="form-control rounded-3" rows="4" placeholder="Describe the issue..." required>{{ old('ticket_body') }}</textarea>
                </div>

                {{-- Attachments --}}
                <div class="col-md-12">
                    <label class="form-label fw-semibold text-secondary">Attachments (optional)</label>
                    <input type="file" name="attachments[]" class="form-control rounded-3" multiple>
                    <small class="text-muted">You can attach multiple files (max 10MB each)</small>
                </div>

                {{-- Priority --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Priority</label>
                    <select name="priority" class="form-select rounded-3" required>
                        @foreach(['Low','Medium','High','Urgent'] as $p)
                            <option value="{{ $p }}" {{ old('priority', 'Medium') == $p ? 'selected' : '' }}>
                                {{ $p }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Action Buttons --}}
                <div class="col-12 text-end mt-3">
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-light border me-2">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle"></i> Create Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const catSelect = document.getElementById('cat_id');
    const subSelect = document.getElementById('subcat_id');
    const serviceSelect = document.getElementById('service_id');

    const clearSelect = (el, placeholder = 'Select') => {
        el.innerHTML = `<option value="">${placeholder}</option>`;
    };

    const fetchJson = async (url) => {
        try {
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            return res.ok ? await res.json() : [];
        } catch {
            return [];
        }
    };

    const loadSubcategories = async (catId) => {
        clearSelect(subSelect, 'Select Subcategory');
        clearSelect(serviceSelect, 'Select Service');
        if (!catId) return;
        const data = await fetchJson(`/admin/subcategories/${catId}`);
        data.forEach(sub => {
            subSelect.insertAdjacentHTML('beforeend', `<option value="${sub.id}">${sub.name}</option>`);
        });
    };

    const loadServices = async (subId) => {
        clearSelect(serviceSelect, 'Select Service');
        if (!subId) return;
        const data = await fetchJson(`/admin/services/${subId}`);
        data.forEach(s => {
            serviceSelect.insertAdjacentHTML('beforeend', `<option value="${s.id}">${s.name}</option>`);
        });
    };

    catSelect.addEventListener('change', () => loadSubcategories(catSelect.value));
    subSelect.addEventListener('change', () => loadServices(subSelect.value));
});
</script>
@endpush
