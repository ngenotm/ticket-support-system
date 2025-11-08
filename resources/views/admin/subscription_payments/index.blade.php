@extends('layouts.admin')

@section('page_title', 'Subscription Payments')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-credit-card text-primary"></i> Subscription Payments
        </h4>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.subscription_payments.create') }}" class="btn btn-primary rounded-3">
                <i class="bi bi-plus-circle me-1"></i> Add Payment
            </a>
            <a href="#" class="btn btn-outline-secondary rounded-3">
                <i class="bi bi-upload me-1"></i> Import
            </a>
        </div>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success rounded-3 shadow-sm">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Card Container -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Subscription</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Method</th>
                            <th>Invoice</th>
                            <th>Reference</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Paid At</th>
                            <th>Due At</th>
                            <th>Retries</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td class="text-muted">{{ $payment->id }}</td>
                                <td>{{ $payment->user->username ?? $payment->user->email ?? 'N/A' }}</td>
                                <td>{{ $payment->plan->title ?? 'N/A' }}</td>
                                <td>#{{ $payment->subscription->id ?? 'N/A' }}</td>
                                <td>${{ number_format($payment->amount, 2) }}</td>
                                <td>{{ $payment->currency }}</td>
                                <td>{{ $payment->payment_method ?? '—' }}</td>
                                <td>{{ $payment->invoice_number ?? '—' }}</td>
                                <td>{{ $payment->payment_reference ?? '—' }}</td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2
                                        @if($payment->status === 'successful') bg-success-subtle text-success
                                        @elseif($payment->status === 'failed') bg-danger-subtle text-danger
                                        @elseif($payment->status === 'pending') bg-warning-subtle text-dark
                                        @else bg-secondary-subtle text-secondary @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ ucfirst($payment->payment_type) }}</td>
                                <td>{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : '—' }}</td>
                                <td>{{ $payment->payment_due_at ? $payment->payment_due_at->format('Y-m-d') : '—' }}</td>
                                <td>{{ $payment->retry_count }}/{{ $payment->max_retries }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.subscription_payments.edit', $payment) }}" class="btn btn-warning rounded-start">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.subscription_payments.destroy', $payment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded-end"
                                                onclick="return confirm('Are you sure you want to delete this payment?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="text-center text-muted py-4">
                                    <i class="bi bi-exclamation-circle"></i> No payments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3 d-flex justify-content-center">
        {{ $payments->links() }}
    </div>
</div>
@endsection
