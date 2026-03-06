@extends('layouts.admin')

@section('title', 'Events')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Events</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.events.create') }}" class="btn btn-sm btn-primary px-3 rounded-pill shadow-sm">
            <i class="fas fa-calendar-plus me-1"></i> Add New Event
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3">Event Details</th>
                        <th class="py-3">Category</th>
                        <th class="py-3">Performers</th>
                        <th class="py-3">Capacity</th>
                        <th class="py-3 text-center">Ticket Price</th>
                        <th class="text-end pe-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr class="align-middle">
                        <td class="ps-4">
                            <div class="fw-bold text-dark d-block fs-6 mb-1">{{ $event->title }}</div>
                            <div class="d-flex align-items-center text-muted small">
                                <span class="me-3"><i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</span>
                                <span><i class="far fa-clock me-1"></i> {{ $event->time }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-soft-primary text-primary border border-primary border-opacity-10 px-2 py-1">
                                {{ $event->category->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                             <div class="d-flex flex-wrap gap-1">
                                @foreach($event->performers as $performer)
                                    <span class="badge bg-light text-dark fw-normal border" style="font-size: 0.75rem;">
                                        <i class="fas fa-microphone me-1 opacity-50 small"></i> {{ $performer->name }}
                                    </span>
                                @endforeach
                             </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="fw-bold me-2">{{ $event->capacity }}</span>
                                <div class="progress flex-grow-1" style="height: 6px; min-width: 60px;">
                                    <div class="progress-bar bg-info" style="width: 100%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center fw-bold text-success">₹{{ number_format($event->ticket_price, 2) }}</td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-outline-primary border-0 bg-light-hover" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this event? All data will be lost.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger border-0 bg-light-hover" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-calendar-times display-4 text-muted opacity-25 mb-3 d-block"></i>
                            <p class="text-muted mb-0">No events found in the system.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.08); }
    .bg-light-hover:hover { background-color: rgba(0,0,0,0.05) !important; }
</style>
@endsection
