@extends('layouts.admin')

@section('page_title', 'Edit Subscription Payment')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('admin.subscription_payments.index') }}" class="btn btn-outline-secondary btn-sm me-2">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <h4 class="mb-0"><i class="bi bi-credit-card"></i> Edit Subscription Payment</h4>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.subscription_payments.update', $payment->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- User -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">User</label>
                        <select name="user_id" class="form-select rounded-3" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $payment->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->username ?? $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subscription -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Subscription</label>
                        <select name="subscription_id" class="form-select rounded-3" required>
                            @foreach($subscriptions as $subscription)
                                <option value="{{ $subscription->id }}" {{ $payment->subscription_id == $subscription->id ? 'selected' : '' }}>
                                    #{{ $subscription->id }} - {{ ucfirst($subscription->status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Plan -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Plan</label>
                        <select name="plan_id" class="form-select rounded-3" required>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ $payment->plan_id == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Amount -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Amount</label>
                        <input type="number" step="0.01" name="amount" value="{{ old('amount', $payment->amount) }}" class="form-control rounded-3" required>
                    </div>

                    <!-- Currency -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Currency</label>
                        <input type="text" name="currency" value="{{ old('currency', $payment->currency ?? 'USD') }}" class="form-control rounded-3" maxlength="10">
                    </div>

                    <!-- Payment Method -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Payment Method</label>
                        <input type="text" name="payment_method" class="form-control rounded-3" value="{{ old('payment_method', $payment->payment_method) }}">
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Status</label>
                        <select name="status" class="form-select rounded-3">
                            @foreach(['pending', 'processing', 'successful', 'failed', 'refunded', 'cancelled', 'expired'] as $status)
                                <option value="{{ $status }}" {{ $payment->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Payment Type -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Payment Type</label>
                        <select name="payment_type" class="form-select rounded-3">
                            @foreach(['initial', 'renewal', 'upgrade', 'downgrade', 'manual'] as $type)
                                <option value="{{ $type }}" {{ $payment->payment_type === $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dates -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Payment Due At</label>
                        <input type="date" name="payment_due_at" class="form-control rounded-3" value="{{ optional($payment->payment_due_at)->format('Y-m-d') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Paid At</label>
                        <input type="date" name="paid_at" class="form-control rounded-3" value="{{ optional($payment->paid_at)->format('Y-m-d') }}">
                    </div>

                    <!-- JSON Fields -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Gateway Response (JSON)</label>
                        <textarea name="gateway_response" class="form-control font-monospace bg-light rounded-3" rows="3">{{ old('gateway_response', $payment->gateway_response) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Meta (JSON)</label>
                        <textarea name="meta" class="form-control font-monospace bg-light rounded-3" rows="3">{{ old('meta', $payment->meta) }}</textarea>
                    </div>

                    <!-- Notes -->
                    <div class="col-12">
                        <label class="form-label fw-semibold text-muted">Notes</label>
                        <textarea name="notes" class="form-control rounded-3" rows="3">{{ old('notes', $payment->notes) }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="bi bi-check-circle"></i> Update Payment
                    </button>
                    <a href="{{ route('admin.subscription_payments.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
