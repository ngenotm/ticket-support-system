<nav class="navbar navbar-light bg-white shadow-sm mb-4 rounded-2 border-0">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Left: Back Button + Page Title -->
        <div class="d-flex align-items-center gap-3">
            <!-- Back Button -->
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm">
                &larr; Back
            </a>
            <!-- Page Title -->
            <span class="navbar-brand mb-0 h5 fw-semibold text-secondary">@yield('page_title')</span>
        </div>

        <!-- Right: User Info + Chat Dropdown -->
        <div class="d-flex align-items-center gap-3">
            <!-- Logged-in Info -->
            <div class="text-secondary small">
                Logged in as: <strong>{{ auth()->user()->user }}</strong>
            </div>

            <!-- Internal Chat Dropdown -->
            <div class="dropdown">
                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    Internal IM
                </button>

                <div class="dropdown-menu dropdown-menu-end p-3 rounded-2 shadow-sm"
                     style="width: 320px; max-height: 400px; overflow-y: auto; background: #ffffff;">

                    <!-- Select User -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">To:</label>
                        <select id="chatUserSelect" class="form-select form-select-sm">
                            <option value="">Select user...</option>
                            @foreach(\App\Models\AppUser::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->user }} -- {{ $user->role->role_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Related Ticket -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Related Ticket:</label>
                        <select id="chatTicketSelect" class="form-select form-select-sm">
                            <option value="">(Optional)</option>
                            @foreach(\App\Models\Ticket::select('id', 'ticket_track_id')->get() as $t)
                                <option value="{{ $t->id }}">{{ $t->ticket_track_id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Chat Messages Box -->
                    <div id="chatMessagesBox" class="border rounded-2 p-2 mb-3 small"
                         style="height:150px; overflow-y:auto; background:#f8f9fa;">
                        <em>Select a user to start chatting...</em>
                    </div>

                    <!-- Message Input -->
                    <div class="input-group input-group-sm">
                        <input type="text" id="chatMessageInput" class="form-control rounded-2" placeholder="Type message..." disabled>
                        <button class="btn btn-primary rounded-2" id="chatSendBtn" disabled>Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
