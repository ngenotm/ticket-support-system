@extends('layouts.admin')
@section('page_title', 'Edit Subscription')

@section('content')
<div class="container-fluid py-3">
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Subscription</h5>
            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-light btn-sm rounded-3">
                <i class="bi bi-arrow-left-circle me-1"></i> Back
            </a>
        </div>

        <div class="card-body">
            {{-- ✅ Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ❌ Error Handling --}}
            @if(session('error') || $errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-x-circle me-2"></i><strong>There were some issues:</strong>
                    <ul class="mb-0 mt-2">
                        @if(session('error'))
                            <li>{{ session('error') }}</li>
                        @endif
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.subscriptions.update', $subscription->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    {{-- Site Users --}}
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-semibold">Site User <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select rounded-3" required>
                            <option value="">Select User</option>
                            @foreach($site_users as $user)
                                <option value="{{ $user->id }}" {{ $subscription->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->username }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Plan --}}
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-semibold">Plan <span class="text-danger">*</span></label>
                        <select name="plan_id" id="plan_id" class="form-select rounded-3" required>
                            <option value="">Select Plan</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}"
                                    data-price="{{ $plan->price }}"
                                    data-currency="{{ $plan->currency ?? 'USD' }}"
                                    data-duration="{{ $plan->duration_days }}"
                                    {{ $subscription->plan_id == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->title }} — {{ $plan->price }} {{ $plan->currency ?? 'USD' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4">
                        <label class="form-label text-secondary fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select rounded-3" required>
                            @foreach(['active', 'cancelled', 'expired', 'pending', 'trial'] as $status)
                                <option value="{{ $status }}" {{ $subscription->status == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-4">
                        <label class="form-label text-secondary fw-semibold">Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" id="amount"
                               class="form-control rounded-3" value="{{ $subscription->amount }}" required>
                    </div>

                    {{-- Currency --}}
                    <div class="col-md-4">
                        <label class="form-label text-secondary fw-semibold">Currency <span class="text-danger">*</span></label>
                        <input type="text" name="currency" id="currency"
                               class="form-control rounded-3" value="{{ $subscription->currency }}" readonly>
                    </div>

                    {{-- Payment Method --}}
                    <div class="col-md-4">
                        <label class="form-label text-secondary fw-semibold">Payment Method</label>
                        <select name="payment_method" class="form-select rounded-3">
                            @php
                                $paymentMethods = ['Credit Card', 'Debit Card', 'PayPal', 'Stripe', 'Bank Transfer', 'UPI', 'Wallet'];
                            @endphp
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method }}" {{ $subscription->payment_method == $method ? 'selected' : '' }}>
                                    {{ $method }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Payment Reference --}}
                    <div class="col-md-4">
                        <label class="form-label text-secondary fw-semibold">Payment Reference</label>
                        <input type="text" name="payment_reference" class="form-control rounded-3"
                               value="{{ $subscription->payment_reference }}">
                    </div>

                    {{-- Started At --}}
                    <div class="col-md-4">
                        <label class="form-label text-secondary fw-semibold">Started At <span class="text-danger">*</span></label>
                        <input type="date" name="started_at" id="started_at"
                               class="form-control rounded-3"
                               value="{{ $subscription->started_at ? $subscription->started_at->format('Y-m-d') : '' }}">
                    </div>

                    {{-- Expires At --}}
                    <div class="col-md-4">
                        <label class="form-label text-secondary fw-semibold">Expires At <span class="text-danger">*</span></label>
                        <input type="date" name="expires_at" id="expires_at"
                               class="form-control rounded-3"
                               value="{{ $subscription->expires_at ? $subscription->expires_at->format('Y-m-d') : '' }}">
                    </div>

                    {{-- Trial Ends At --}}
                    <div class="col-md-4">
                        <label class="form-label text-secondary fw-semibold">Trial Ends At</label>
                        <input type="date" name="trial_ends_at" class="form-control rounded-3"
                               value="{{ $subscription->trial_ends_at ? $subscription->trial_ends_at->format('Y-m-d') : '' }}">
                    </div>

                    {{-- Cancelled At --}}
                    <div class="col-md-4">
                        <label class="form-label text-secondary fw-semibold">Cancelled At</label>
                        <input type="date" name="cancelled_at" class="form-control rounded-3"
                               value="{{ $subscription->cancelled_at ? $subscription->cancelled_at->format('Y-m-d') : '' }}">
                    </div>

                    {{-- Renewed At --}}
                    <div class="col-md-4">
                        <label class="form-label text-secondary fw-semibold">Renewed At</label>
                        <input type="date" name="renewed_at" class="form-control rounded-3"
                               value="{{ $subscription->renewed_at ? $subscription->renewed_at->format('Y-m-d') : '' }}">
                    </div>

                    {{-- Renewal Type --}}
                    <div class="col-md-4">
                        <label class="form-label text-secondary fw-semibold">Renewal Type <span class="text-danger">*</span></label>
                        <select name="renewal_type" class="form-select rounded-3">
                            <option value="auto" {{ $subscription->renewal_type == 'auto' ? 'selected' : '' }}>Auto</option>
                            <option value="manual" {{ $subscription->renewal_type == 'manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>

                    {{-- Notes --}}
                    <div class="col-md-12">
                        <label class="form-label text-secondary fw-semibold">Notes</label>
                        <textarea name="notes" class="form-control rounded-3" rows="3">{{ $subscription->notes }}</textarea>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-outline-secondary rounded-3 me-2">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-success rounded-3">
                        <i class="bi bi-check-circle me-1"></i> Update Subscription
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const planSelect = document.getElementById('plan_id');
    const amountInput = document.getElementById('amount');
    const currencyInput = document.getElementById('currency');
    const startedAtInput = document.getElementById('started_at');
    const expiresAtInput = document.getElementById('expires_at');

    planSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        amountInput.value = selected.dataset.price || '';
        currencyInput.value = selected.dataset.currency || '';
        updateExpiry();
    });

    function updateExpiry() {
        const selected = planSelect.options[planSelect.selectedIndex];
        const duration = parseInt(selected.dataset.duration);
        const startDate = new Date(startedAtInput.value);
        if (!isNaN(duration) && startedAtInput.value) {
            const expiryDate = new Date(startDate);
            expiryDate.setDate(expiryDate.getDate() + duration);
            expiresAtInput.value = expiryDate.toISOString().split('T')[0];
        }
    }

    startedAtInput.addEventListener('change', updateExpiry);
});
</script>
@endpush
