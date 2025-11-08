@extends('layouts.admin')
@section('page_title', 'Create Plan')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-semibold text-secondary mb-0">
            <i class="bi bi-card-list text-primary me-2"></i> Add New Plan
        </h2>
        <a href="{{ route('admin.plans.index') }}" class="btn btn-outline-secondary rounded-pill shadow-sm px-3">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <!-- Card Form -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.plans.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <!-- Title -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary">Title</label>
                        <input type="text" name="title" class="form-control rounded-3" value="{{ old('title') }}" required>
                    </div>

                    <!-- Slug -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary">Slug</label>
                        <input type="text" name="slug" class="form-control rounded-3" value="{{ old('slug') }}" required>
                    </div>

                    <!-- Price -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control rounded-3" value="{{ old('price', 0) }}" required>
                    </div>

                    <!-- Currency -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Currency</label>
                        <select name="currency" class="form-select rounded-3">
                            @php
                                $currencies = ['USD', 'EUR', 'GBP', 'INR', 'AUD', 'CAD', 'JPY', 'CNY'];
                            @endphp
                            @foreach($currencies as $currency)
                                <option value="{{ $currency }}" {{ old('currency', 'USD') == $currency ? 'selected' : '' }}>
                                    {{ $currency }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Duration -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Duration (days)</label>
                        <input type="number" name="duration_days" class="form-control rounded-3" value="{{ old('duration_days', 30) }}" required>
                    </div>

                    <!-- Billing Cycle -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Billing Cycle</label>
                        <select name="billing_cycle" class="form-select rounded-3">
                            <option value="monthly" {{ old('billing_cycle')=='monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ old('billing_cycle')=='yearly' ? 'selected' : '' }}>Yearly</option>
                            <option value="one-time" {{ old('billing_cycle')=='one-time' ? 'selected' : '' }}>One-Time</option>
                        </select>
                    </div>

                    <!-- Trial Days -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Trial Days</label>
                        <input type="number" name="trial_days" class="form-control rounded-3" value="{{ old('trial_days', 0) }}">
                    </div>

                    <!-- Max Users -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Max Users</label>
                        <input type="number" name="max_users" class="form-control rounded-3" value="{{ old('max_users') }}">
                    </div>

                    <!-- Max Storage -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Max Storage (GB)</label>
                        <input type="number" name="max_storage_gb" class="form-control rounded-3" value="{{ old('max_storage_gb') }}">
                    </div>

                    <!-- Max Projects -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Max Projects</label>
                        <input type="number" name="max_projects" class="form-control rounded-3" value="{{ old('max_projects') }}">
                    </div>

                    <!-- Colors -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Border Color</label>
                        <input type="color" name="border_color" class="form-control form-control-color rounded-3" value="{{ old('border_color', '#007bff') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Title Color</label>
                        <input type="color" name="title_color" class="form-control form-control-color rounded-3" value="{{ old('title_color', '#000000') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Background Color</label>
                        <input type="color" name="background_color" class="form-control form-control-color rounded-3" value="{{ old('background_color', '#f8f9fa') }}">
                    </div>

                    <!-- Misc -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Badge Label</label>
                        <input type="text" name="badge_label" class="form-control rounded-3" value="{{ old('badge_label') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Renewal Type</label>
                        <select name="renewal_type" class="form-select rounded-3">
                            <option value="auto" {{ old('renewal_type')=='auto' ? 'selected' : '' }}>Auto</option>
                            <option value="manual" {{ old('renewal_type')=='manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Featured?</label>
                        <select name="is_featured" class="form-select rounded-3">
                            <option value="1" {{ old('is_featured') ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !old('is_featured') ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-secondary">Active?</label>
                        <select name="is_active" class="form-select rounded-3">
                            <option value="1" selected>Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <!-- Features -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold text-secondary">Features (JSON)</label>
                        <textarea name="features" class="form-control rounded-3" rows="3">{{ old('features') }}</textarea>
                        <small class="text-muted">Example: {"max_tickets":100,"support":true}</small>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                        <i class="bi bi-check-circle me-1"></i> Save Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
