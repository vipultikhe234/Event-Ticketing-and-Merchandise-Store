@extends('layouts.admin')

@section('title', 'Performers')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Performers</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.performers.create') }}" class="btn btn-sm btn-primary px-3 rounded-pill shadow-sm">
            <i class="fas fa-plus me-1"></i> Add New Performer
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3">Performer</th>
                        <th class="py-3">Category</th>
                        <th class="py-3">Spotify ID</th>
                        <th class="py-3">Description</th>
                        <th class="text-end pe-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($performers as $performer)
                    <tr class="align-middle">
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                @if($performer->image)
                                    <img src="{{ $performer->image }}" alt="{{ $performer->name }}" class="rounded shadow-sm me-3" width="50" height="50" style="object-fit: cover; border: 2px solid white;">
                                @else
                                    <div class="rounded bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center text-secondary me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-user fa-lg"></i>
                                    </div>
                                @endif
                                <div>
                                    <span class="fw-bold d-block text-dark">{{ $performer->name }}</span>
                                    <small class="text-muted">#{{ $performer->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-soft-info text-info border border-info border-opacity-25 px-2 py-1 fw-bold">
                                {{ $performer->category->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                             @if($performer->spotify_id)
                                <a href="https://open.spotify.com/artist/{{ $performer->spotify_id }}" target="_blank" class="text-success text-decoration-none small fw-bold">
                                    <i class="fab fa-spotify me-1 opacity-75"></i> {{ Str::limit($performer->spotify_id, 10) }}
                                </a>
                            @else
                                <span class="text-muted small">Not Linked</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ Str::limit($performer->bio, 50) ?: 'No bio available' }}</td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.performers.edit', $performer->id) }}" class="btn btn-outline-primary border-0 bg-light-hover" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.performers.destroy', $performer->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this performer?')">
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
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-microphone-alt-slash display-4 text-muted opacity-25 mb-3 d-block"></i>
                            <p class="text-muted mb-0">No performers found in the system.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    .text-info { color: #0dcaf0 !important; }
    .bg-light-hover:hover { background-color: rgba(0,0,0,0.05) !important; }
</style>
@endsection
