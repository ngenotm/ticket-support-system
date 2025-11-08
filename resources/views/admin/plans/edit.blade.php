@extends('layouts.admin')
@section('page_title', 'Edit Plan')

@section('content')
<div class="card shadow-sm rounded-4 border-0">
    <div class="card-header bg-warning bg-opacity-75 text-dark d-flex align-items-center justify-content-between">
        <div>
            <i class="bi bi-pencil-square me-2"></i> <strong>Edit Plan</strong>
        </div>
        <a href="{{ route('admin.plans.index') }}" class="btn btn-light btn-sm border">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card-body bg-light rounded-bottom-4">
        <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div class="row g-3">
                <!-- Title -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Title</label>
                    <input type="text" name="title" class="form-control rounded-3 shadow-sm"
                        value="{{ old('title', $plan->title) }}" required>
                </div>

                <!-- Slug -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary">Slug</label>
                    <input type="text" name="slug" class="form-control rounded-3 shadow-sm"
                        value="{{ old('slug', $plan->slug) }}" required>
                </div>

                <!-- Price -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control rounded-3 shadow-sm"
                        value="{{ old('price', $plan->price) }}" required>
                </div>

                <!-- Currency -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Currency</label>
                    <select name="currency" class="form-select rounded-3 shadow-sm">
                        @php $currencies = ['USD', 'EUR', 'GBP', 'INR', 'AUD', 'CAD', 'JPY', 'CNY']; @endphp
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency }}"
                                {{ old('currency', $plan->currency ?? 'USD') == $currency ? 'selected' : '' }}>
                                {{ $currency }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Duration -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Duration (days)</label>
                    <input type="number" name="duration_days" class="form-control rounded-3 shadow-sm"
                        value="{{ old('duration_days', $plan->duration_days) }}" required>
                </div>

                <!-- Billing Cycle -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Billing Cycle</label>
                    <select name="billing_cycle" class="form-select rounded-3 shadow-sm">
                        <option value="monthly" {{ old('billing_cycle', $plan->billing_cycle) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ old('billing_cycle', $plan->billing_cycle) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                        <option value="one-time" {{ old('billing_cycle', $plan->billing_cycle) == 'one-time' ? 'selected' : '' }}>One-Time</option>
                    </select>
                </div>

                <!-- Trial / Limits -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Trial Days</label>
                    <input type="number" name="trial_days" class="form-control rounded-3 shadow-sm"
                        value="{{ old('trial_days', $plan->trial_days) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Max Users</label>
                    <input type="number" name="max_users" class="form-control rounded-3 shadow-sm"
                        value="{{ old('max_users', $plan->max_users) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Max Storage (GB)</label>
                    <input type="number" name="max_storage_gb" class="form-control rounded-3 shadow-sm"
                        value="{{ old('max_storage_gb', $plan->max_storage_gb) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Max Projects</label>
                    <input type="number" name="max_projects" class="form-control rounded-3 shadow-sm"
                        value="{{ old('max_projects', $plan->max_projects) }}">
                </div>

                <!-- Colors -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Border Color</label>
                    <input type="color" name="border_color" class="form-control form-control-color rounded-3 shadow-sm"
                        value="{{ old('border_color', $plan->border_color) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Title Color</label>
                    <input type="color" name="title_color" class="form-control form-control-color rounded-3 shadow-sm"
                        value="{{ old('title_color', $plan->title_color) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Background Color</label>
                    <input type="color" name="background_color" class="form-control form-control-color rounded-3 shadow-sm"
                        value="{{ old('background_color', $plan->background_color) }}">
                </div>

                <!-- Badge / Renewal -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Badge Label</label>
                    <input type="text" name="badge_label" class="form-control rounded-3 shadow-sm"
                        value="{{ old('badge_label', $plan->badge_label) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Renewal Type</label>
                    <select name="renewal_type" class="form-select rounded-3 shadow-sm">
                        <option value="auto" {{ old('renewal_type', $plan->renewal_type) == 'auto' ? 'selected' : '' }}>Auto</option>
                        <option value="manual" {{ old('renewal_type', $plan->renewal_type) == 'manual' ? 'selected' : '' }}>Manual</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Featured?</label>
                    <select name="is_featured" class="form-select rounded-3 shadow-sm">
                        <option value="1" {{ old('is_featured', $plan->is_featured) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('is_featured', $plan->is_featured) ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Active?</label>
                    <select name="is_active" class="form-select rounded-3 shadow-sm">
                        <option value="1" {{ old('is_active', $plan->is_active) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !old('is_active', $plan->is_active) ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <!-- Features -->
                <div class="col-12">
                    <label class="form-label fw-semibold text-secondary">Features (JSON)</label>
                    <textarea name="features" class="form-control rounded-3 shadow-sm" rows="4">{{ old('features', json_encode($plan->features, JSON_PRETTY_PRINT)) }}</textarea>
                    <small class="text-muted">Example: {"max_tickets":100,"support":true}</small>
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('admin.plans.index') }}" class="btn btn-outline-secondary rounded-3 me-2">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn btn-success rounded-3 shadow-sm">
                    <i class="bi bi-check-circle"></i> Update Plan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
