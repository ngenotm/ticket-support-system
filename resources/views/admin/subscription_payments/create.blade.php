@extends('layouts.admin')

@section('page_title', 'Add Subscription Payment')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
        <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i> Add Subscription Payment</h5>
        <a href="{{ route('admin.subscription_payments.index') }}" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>
    </div>

    <div class="card-body bg-white">
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.subscription_payments.store') }}">
            @csrf

            <div class="row g-3">
                <!-- User -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">User</label>
                    <select name="user_id" class="form-select rounded-3 shadow-sm" required>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->username ?? $user->email }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Subscription -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">Subscription</label>
                    <select name="subscription_id" class="form-select rounded-3 shadow-sm" required>
                        <option value="">Select Subscription</option>
                        @foreach($subscriptions as $subscription)
                            <option value="{{ $subscription->id }}">#{{ $subscription->id }} - {{ $subscription->status }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Plan -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">Plan</label>
                    <select name="plan_id" class="form-select rounded-3 shadow-sm" required>
                        <option value="">Select Plan</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Amount -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">Amount</label>
                    <input type="number" step="0.01" name="amount" class="form-control rounded-3 shadow-sm" required>
                </div>

                <!-- Currency -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">Currency</label>
                    <input type="text" name="currency" class="form-control rounded-3 shadow-sm" value="USD" maxlength="10" required>
                </div>

                <!-- Payment Method -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">Payment Method</label>
                    <input type="text" name="payment_method" class="form-control rounded-3 shadow-sm" placeholder="e.g. Stripe, PayPal, Razorpay">
                </div>

                <!-- Payment Reference -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">Payment Reference</label>
                    <input type="text" name="payment_reference" class="form-control rounded-3 shadow-sm" placeholder="e.g. TXN12345">
                </div>

                <!-- Invoice Number -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">Invoice Number</label>
                    <input type="text" name="invoice_number" class="form-control rounded-3 shadow-sm" placeholder="e.g. INV-00123">
                </div>

                <!-- Payment Intent ID -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">Payment Intent ID</label>
                    <input type="text" name="payment_intent_id" class="form-control rounded-3 shadow-sm" placeholder="e.g. pi_abc123">
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">Status</label>
                    <select name="status" class="form-select rounded-3 shadow-sm">
                        <option>pending</option>
                        <option>processing</option>
                        <option>successful</option>
                        <option>failed</option>
                        <option>refunded</option>
                        <option>cancelled</option>
                        <option>expired</option>
                    </select>
                </div>

                <!-- Payment Type -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">Payment Type</label>
                    <select name="payment_type" class="form-select rounded-3 shadow-sm">
                        <option>initial</option>
                        <option>renewal</option>
                        <option>upgrade</option>
                        <option>downgrade</option>
                        <option>manual</option>
                    </select>
                </div>

                <!-- Renewal Attempt -->
                <div class="col-md-6 d-flex align-items-center">
                    <div class="form-check mt-3">
                        <input type="checkbox" name="renewal_attempt" value="1" class="form-check-input" id="renewal_attempt">
                        <label class="form-check-label text-secondary" for="renewal_attempt">Renewal Attempt</label>
                    </div>
                </div>

                <!-- Dates -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">Payment Due At</label>
                    <input type="date" name="payment_due_at" class="form-control rounded-3 shadow-sm">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary">Paid At</label>
                    <input type="date" name="paid_at" class="form-control rounded-3 shadow-sm">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary">Refunded At</label>
                    <input type="date" name="refunded_at" class="form-control rounded-3 shadow-sm">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary">Next Retry At</label>
                    <input type="date" name="next_retry_at" class="form-control rounded-3 shadow-sm">
                </div>

                <!-- Retry Fields -->
                <div class="col-md-6">
                    <label class="form-label text-secondary">Retry Count</label>
                    <input type="number" name="retry_count" class="form-control rounded-3 shadow-sm" value="0" min="0">
                </div>

                <div class="col-md-6">
                    <label class="form-label text-secondary">Max Retries</label>
                    <input type="number" name="max_retries" class="form-control rounded-3 shadow-sm" value="3" min="0">
                </div>

                <!-- JSON Fields -->
                <div class="col-12">
                    <label class="form-label text-secondary">Gateway Response (JSON)</label>
                    <textarea name="gateway_response" class="form-control font-monospace rounded-3 shadow-sm" rows="3" placeholder='{"transaction_id": "123"}'></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label text-secondary">Meta (JSON)</label>
                    <textarea name="meta" class="form-control font-monospace rounded-3 shadow-sm" rows="3" placeholder='{"note": "optional info"}'></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label text-secondary">Notes</label>
                    <textarea name="notes" class="form-control rounded-3 shadow-sm" rows="3" placeholder="Additional remarks..."></textarea>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-4">
                <button type="submit" class="btn btn-success me-2 rounded-3 px-4">
                    <i class="bi bi-check-circle"></i> Save Payment
                </button>
                <a href="{{ route('admin.subscription_payments.index') }}" class="btn btn-outline-secondary rounded-3 px-4">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
