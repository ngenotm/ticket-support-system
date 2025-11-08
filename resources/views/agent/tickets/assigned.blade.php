@extends('layouts.staff')

@section('page_title', 'Assigned Tickets')

@section('staff')
<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0 fw-semibold text-secondary">
            <i class="fa fa-ticket text-primary me-2"></i> Assigned Tickets
        </h4>
        <a href="{{ route('agent.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back
        </a>
    </div>

    @if ($tickets->count() > 0)
        <!-- Tickets Table -->
        <div class="table-responsive shadow-sm rounded-2 border">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Ticket ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Service</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Assigned Date</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $key => $ticket)
                        <tr>
                            <td>{{ $tickets->firstItem() + $key }}</td>
                            <td><span class="fw-semibold text-primary">{{ $ticket->ticket_track_id }}</span></td>
                            <td>{{ Str::limit($ticket->title, 30) }}</td>
                            <td>{{ $ticket->category->name ?? '—' }}</td>
                            <td>{{ $ticket->subcategory->name ?? '—' }}</td>
                            <td>{{ $ticket->service->name ?? '—' }}</td>
                            <td>{{ $ticket->siteUser->username ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $statusClass = match (strtolower($ticket->status)) {
                                        'open' => 'badge bg-success',
                                        'closed' => 'badge bg-danger',
                                        'pending' => 'badge bg-warning text-dark',
                                        default => 'badge bg-secondary'
                                    };
                                @endphp
                                <span class="{{ $statusClass }}">{{ ucfirst($ticket->status) }}</span>
                            </td>
                            <td>
                                @php
                                    $priorityClass = match (strtolower($ticket->priority)) {
                                        'high' => 'text-danger fw-bold',
                                        'medium' => 'text-warning fw-semibold',
                                        'low' => 'text-muted',
                                        default => ''
                                    };
                                @endphp
                                <span class="{{ $priorityClass }}">{{ ucfirst($ticket->priority ?? '—') }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($ticket->assigned_date)->format('d M Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('agent.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-eye me-1"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-end">
                {{ $tickets->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @else
        <div class="alert alert-info text-center py-4 shadow-sm rounded-2">
            <i class="fa fa-info-circle me-2"></i> No tickets assigned yet.
        </div>
    @endif
</div>
@endsection
