@extends('layouts.admin')

@section('page_title', 'Add Expired Subscription')

@section('content')
<div class="container mt-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold mb-0">📅 Add Expired Subscription</h4>
        <a href="{{ route('admin.expired_subscriptions.index') }}" class="btn btn-outline-secondary rounded-3 shadow-sm">
            ← Back
        </a>
    </div>

    <!-- Form Card -->
    <form action="{{ route('admin.expired_subscriptions.store') }}" method="POST"
          class="card border-0 shadow-sm rounded-3 p-4 bg-white">
        @csrf

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-secondary">User</label>
                <select name="user_id" class="form-select" required>
                    <option value="">-- Select User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->username ?? $user->email }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-secondary">Plan</label>
                <select name="plan_id" class="form-select">
                    <option value="">-- Select Plan --</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}">{{ $plan->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-secondary">Amount</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="0.00">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-secondary">Currency</label>
                <input type="text" name="currency" class="form-control" value="USD">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-secondary">Status</label>
                <select name="status" class="form-select">
                    <option value="expired">Expired</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="grace_period">Grace Period</option>
                    <option value="renewal_failed">Renewal Failed</option>
                    <option value="archived">Archived</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-secondary">Renewal Type</label>
                <select name="renewal_type" class="form-select">
                    <option value="auto">Auto</option>
                    <option value="manual">Manual</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-secondary">Expiry Reason</label>
                <textarea name="expiry_reason" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-secondary">Admin Notes</label>
                <textarea name="admin_notes" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-secondary">Expired At</label>
                <input type="datetime-local" name="expired_at" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold text-secondary">Expires At</label>
                <input type="datetime-local" name="expires_at" class="form-control">
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('admin.expired_subscriptions.index') }}"
               class="btn btn-outline-secondary shadow-sm rounded-3">Cancel</a>
            <button type="submit" class="btn btn-success shadow-sm rounded-3 px-4">💾 Save Record</button>
        </div>
    </form>
</div>
@endsection
