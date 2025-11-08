@extends('layouts.admin')
@section('page_title', 'Create Subscription')

@section('content')
<div class="card shadow-sm border-0">

    {{-- 🔹 Header --}}
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-credit-card me-2"></i> Add New Subscription
        </h5>
        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card-body bg-light">
        {{-- ✅ Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ❌ Error Handling --}}
        @if(session('error') || $errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i><strong>Error:</strong>
                <ul class="mb-0 mt-2 ps-3">
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

        {{-- 🧾 Form --}}
        <form action="{{ route('admin.subscriptions.store') }}" method="POST" class="row g-3">
            @csrf

            <h6 class="text-secondary fw-semibold mt-3">
                <i class="bi bi-person-circle me-1"></i> User & Plan Details
            </h6>

            {{-- Site User --}}
            <div class="col-md-6">
                <label class="form-label required">Site User</label>
                <select name="user_id" class="form-select rounded-3 shadow-sm" required>
                    <option value="">Select User</option>
                    @foreach($site_users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->username }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Plan --}}
            <div class="col-md-6">
                <label class="form-label required">Plan</label>
                <select name="plan_id" id="plan_id" class="form-select rounded-3 shadow-sm" required>
                    <option value="">Select Plan</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}"
                            data-price="{{ $plan->price }}"
                            data-currency="{{ $plan->currency ?? 'USD' }}"
                            data-duration="{{ $plan->duration_days }}"
                            {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->title }} — {{ $plan->price }} {{ $plan->currency ?? 'USD' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <h6 class="text-secondary fw-semibold mt-4">
                <i class="bi bi-cash-stack me-1"></i> Payment & Status
            </h6>

            {{-- Status --}}
            <div class="col-md-4">
                <label class="form-label required">Status</label>
                <select name="status" class="form-select rounded-3 shadow-sm" required>
                    @foreach(['active', 'cancelled', 'expired', 'pending', 'trial'] as $status)
                        <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Amount --}}
            <div class="col-md-4">
                <label class="form-label required">Amount</label>
                <input type="number" step="0.01" name="amount" id="amount"
                    class="form-control rounded-3 shadow-sm"
                    value="{{ old('amount', 0) }}" readonly required>
            </div>

            {{-- Currency --}}
            <div class="col-md-4">
                <label class="form-label required">Currency</label>
                <input type="text" name="currency" id="currency"
                    class="form-control rounded-3 shadow-sm"
                    value="{{ old('currency', 'USD') }}" readonly>
            </div>

            {{-- Payment Method --}}
            <div class="col-md-4">
                <label class="form-label">Payment Method</label>
                <select name="payment_method" class="form-select rounded-3 shadow-sm">
                    @php
                        $methods = ['Credit Card', 'Debit Card', 'PayPal', 'Stripe', 'Bank Transfer', 'UPI', 'Wallet'];
                    @endphp
                    @foreach($methods as $method)
                        <option value="{{ $method }}" {{ old('payment_method') == $method ? 'selected' : '' }}>
                            {{ $method }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Payment Reference --}}
            <div class="col-md-4">
                <label class="form-label">Payment Reference</label>
                <input type="text" name="payment_reference"
                    class="form-control rounded-3 shadow-sm"
                    value="{{ old('payment_reference') }}">
            </div>

            <h6 class="text-secondary fw-semibold mt-4">
                <i class="bi bi-calendar-date me-1"></i> Duration & Renewal
            </h6>

            {{-- Dates --}}
            <div class="col-md-4">
                <label class="form-label required">Start Date</label>
                <input type="date" name="started_at" id="started_at"
                    class="form-control rounded-3 shadow-sm"
                    value="{{ old('started_at') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label required">Expiry Date</label>
                <input type="date" name="expires_at" id="expires_at"
                    class="form-control rounded-3 shadow-sm"
                    value="{{ old('expires_at') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Trial Ends</label>
                <input type="date" name="trial_ends_at"
                    class="form-control rounded-3 shadow-sm"
                    value="{{ old('trial_ends_at') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Cancelled At</label>
                <input type="date" name="cancelled_at"
                    class="form-control rounded-3 shadow-sm"
                    value="{{ old('cancelled_at') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Renewed At</label>
                <input type="date" name="renewed_at"
                    class="form-control rounded-3 shadow-sm"
                    value="{{ old('renewed_at') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label required">Renewal Type</label>
                <select name="renewal_type" class="form-select rounded-3 shadow-sm">
                    <option value="auto" {{ old('renewal_type') == 'auto' ? 'selected' : '' }}>Auto</option>
                    <option value="manual" {{ old('renewal_type') == 'manual' ? 'selected' : '' }}>Manual</option>
                </select>
            </div>

            {{-- Notes --}}
            <div class="col-12">
                <label class="form-label">Notes</label>
                <textarea name="notes" rows="3" class="form-control rounded-3 shadow-sm">{{ old('notes') }}</textarea>
            </div>

            <div class="text-end mt-3">
                <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Save Subscription
                </button>
            </div>
        </form>
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

    function updatePlanDetails() {
        const selected = planSelect.options[planSelect.selectedIndex];
        amountInput.value = selected.getAttribute('data-price') || '';
        currencyInput.value = selected.getAttribute('data-currency') || '';

        const duration = parseInt(selected.getAttribute('data-duration'));
        if (!isNaN(duration) && startedAtInput.value) {
            const expiryDate = new Date(startedAtInput.value);
            expiryDate.setDate(expiryDate.getDate() + duration);
            expiresAtInput.value = expiryDate.toISOString().split('T')[0];
        }
    }

    planSelect.addEventListener('change', updatePlanDetails);
    startedAtInput.addEventListener('change', updatePlanDetails);

    if (planSelect.value) planSelect.dispatchEvent(new Event('change'));
});
</script>
@endpush
