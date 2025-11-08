@extends('layouts.staff')

@section('page_title', 'All Site Users')

@section('staff')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0 fw-semibold">
            <i class="fas fa-users text-primary"></i> All Site Users
        </h4>
        <a href="{{ route('agent.dashboard') }}" class="btn btn-sm btn-secondary rounded-2">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    @if($users->count() > 0)
    <div class="table-responsive shadow-sm rounded-2 border">
        <table class="table table-borderless align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $user)
                @php
                    $borderColor = $user->activeSubscription?->currentPlan?->border_color 
                                   ?? $user->currentPlan?->border_color 
                                   ?? '#ddd';
                    $planTitle = $user->activeSubscription?->currentPlan?->title 
                                 ?? $user->currentPlan?->title 
                                 ?? 'No active plan';
                    $statusClass = match($user->status) {
                        'active' => 'badge bg-success',
                        'inactive' => 'badge bg-secondary',
                        default => 'badge bg-light text-dark'
                    };
                @endphp
                <tr class="align-middle">
                    <td>{{ $users->firstItem() + $key }}</td>
                    <td>
                        @if($user->photo_url)
                        <img src="{{ asset($user->photo_url) }}" loading="lazy" width="40" height="40" 
                             class="rounded-circle me-2" title="{{ $planTitle }}" 
                             style="border: 3px solid {{ $borderColor }}; padding: 2px;">
                        @else
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center me-2" 
                             style="width:40px;height:40px;border:3px solid {{ $borderColor }};background:#f8f9fa;">
                            <i class="fa fa-user text-muted"></i>
                        </div>
                        @endif
                        <a href="javascript:void(0);" 
                           class="btn btn-sm btn-outline-primary rounded-2 py-0 px-2 viewUserBtn" 
                           style="border-color: {{ $borderColor }};" 
                           data-id="{{ $user->id }}" title="View {{ $user->username }}">
                            <i class="fa fa-eye"></i> {{ $user->username }}
                        </a>
                    </td>
                    <td class="text-secondary">{{ $user->email }}</td>
                    <td class="text-secondary">{{ $user->phone ?? '—' }}</td>
                    <td class="text-secondary">{{ $user->city ?? '—' }}</td>
                    <td class="text-secondary">{{ $user->country ?? '—' }}</td>
                    <td><span class="{{ $statusClass }}">{{ ucfirst($user->status ?? 'Inactive') }}</span></td>
                    <td class="text-secondary">{{ $user->created_at?->format('d M Y') ?? '—' }}</td>
                    <td class="text-end">
                        <a href="javascript:void(0);" 
                           class="btn btn-sm btn-outline-primary rounded-2 py-0 px-2 viewUserBtn" 
                           data-id="{{ $user->id }}">
                            <i class="fa fa-eye"></i> View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>

    <!-- User Details Modal -->
    <div class="modal fade" id="ticketViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content shadow-sm rounded-2 border-0">
                <div class="modal-header bg-light border-bottom-0">
                    <h5 class="modal-title fw-semibold">🎫 User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="ticket-info-section" class="py-2"></div>
                    <hr>
                    <div id="ticket-replies-section" class="py-2"></div>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="alert alert-info text-center py-4 shadow-sm rounded-2">
        <i class="fa fa-info-circle"></i> No users found.
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = new bootstrap.Modal(document.getElementById('ticketViewModal'));

    document.querySelectorAll('.viewUserBtn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const userId = btn.dataset.id;
            modal.show();

            const infoSection = document.getElementById('ticket-info-section');
            const repliesSection = document.getElementById('ticket-replies-section');
            infoSection.innerHTML = `<div class="d-flex justify-content-center py-4">
                                        <div class="spinner-border text-primary" role="status"></div>
                                     </div>`;
            repliesSection.innerHTML = '';

            try {
                const response = await fetch(`{{ route('agent.user.details') }}?id=${userId}`);
                const data = await response.json();

                infoSection.innerHTML = data.user_html;
                repliesSection.innerHTML = data.tickets_html;
            } catch (error) {
                infoSection.innerHTML = '<div class="text-danger">Error loading user details.</div>';
            }
        });
    });
});
</script>
@endpush
