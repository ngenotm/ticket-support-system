@extends('layouts.staff')

@section('staff')
<div class="container-fluid mt-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold text-secondary">
            🎫 All Active Tickets
        </h4>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-2">{{ session('success') }}</div>
    @endif

    <!-- Tickets Table -->
    <div class="card shadow-sm rounded-2 border">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Track ID</th>
                        <th class="text-start">Title</th>
                        <th>Category</th>
                        <th>Open Time</th>
                        <th class="text-start">Ticket User</th>
                        <th>Replies</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Last Reply</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td><span class="badge bg-info">{{ $ticket->ticket_track_id }}</span></td>

                            <td class="text-start">
                                <a href="{{ route('agent.tickets.show', $ticket->id) }}" class="fw-semibold text-decoration-none text-secondary">
                                    {{ Str::limit($ticket->title, 40) }}
                                </a>
                            </td>

                            <td>{{ $ticket->category->name ?? '-' }}</td>
                            <td><span class="text-muted" title="{{ $ticket->opened_time }}">{{ $ticket->opened_time }}</span></td>

                            <!-- Ticket User -->
                            <td class="text-start d-flex align-items-center gap-2">
                                @if($ticket->siteUser?->profile_img)
                                    <img src="{{ asset('storage/' . $ticket->siteUser->profile_img) }}" alt="avatar" width="30" height="30" class="rounded-circle">
                                @else
                                    <span class="avatar-placeholder bg-secondary text-white rounded-circle d-inline-flex justify-content-center align-items-center" style="width:30px; height:30px;">
                                        {{ strtoupper(substr($ticket->siteUser->username ?? 'U', 0, 1)) }}
                                    </span>
                                @endif
                                {{ $ticket->siteUser->username ?? 'N/A' }}
                            </td>

                            <td><span class="badge bg-light text-dark">{{ $ticket->reply_counter }}</span></td>

                            <!-- Status -->
                            <td>
                                <span class="badge 
                                    @if($ticket->status === 'New') bg-primary
                                    @elseif($ticket->status === 'Closed') bg-dark
                                    @elseif($ticket->status === 'Pending') bg-warning text-dark
                                    @else bg-success @endif">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>

                            <!-- Priority -->
                            <td>
                                <span class="badge 
                                    @if($ticket->priority === 'High') bg-danger
                                    @elseif($ticket->priority === 'Medium') bg-info
                                    @else bg-secondary @endif">
                                    {{ $ticket->priority ?? '—' }}
                                </span>
                            </td>

                            <td><span class="text-muted" title="{{ $ticket->last_reply_time }}">{{ $ticket->last_reply_time }}</span></td>

                            <!-- Actions -->
                            <td class="text-end">
                                <a href="{{ route('agent.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">No tickets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-end">
                {{ $tickets->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
