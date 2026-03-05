@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Manage Users</h1>
        <p class="text-muted small">View registered users, assign roles, and monitor engagement.</p>
    </div>
</div>

<div class="card shadow-sm border-0 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3">Account</th>
                        <th class="py-3">Email Address</th>
                        <th class="py-3 text-center">Role</th>
                        <th class="py-3 text-center">Activity</th>
                        <th class="py-3">Joined Date</th>
                        <th class="text-end pe-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="align-middle">
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=40&background=random" class="rounded-circle me-3 shadow-sm border" style="width: 40px; height: 40px;">
                                <div>
                                    <span class="fw-bold d-block text-dark">{{ $user->name }}</span>
                                    <small class="text-muted">ID: #{{ $user->id }}</small>
                                </div>
                                @if(auth()->id() === $user->id)
                                    <span class="badge bg-soft-info text-info ms-2 border border-info border-opacity-25" style="font-size: 0.65rem;">YOU</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <a href="mailto:{{ $user->email }}" class="text-decoration-none text-muted small"><i class="far fa-envelope me-1"></i> {{ $user->email }}</a>
                        </td>
                        <td class="text-center">
                            @if($user->role === 'admin')
                                <span class="badge bg-soft-primary text-primary border border-primary border-opacity-25 px-2 py-1">
                                    <i class="fas fa-shield-alt me-1 opacity-50 small"></i> ADMIN
                                </span>
                            @else
                                <span class="badge bg-light text-dark border px-2 py-1 fw-normal">
                                    <i class="fas fa-user me-1 opacity-50 small"></i> USER
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->orders_count > 0)
                                <div class="badge bg-soft-success text-success border border-success border-opacity-25 px-2 py-1">
                                    <i class="fas fa-shopping-bag me-1 opacity-50"></i> {{ $user->orders_count }} orders
                                </div>
                            @else
                                <span class="text-muted small">No orders</span>
                            @endif
                        </td>
                        <td>
                            <div class="small text-muted">
                                <i class="far fa-calendar-alt me-1"></i> {{ $user->created_at->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary border-0 bg-light-hover" title="Manage Role">
                                    <i class="fas fa-user-cog"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete this user account? All associated orders will also be deleted.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger border-0 bg-light-hover" title="Delete Account" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                        <i class="fas fa-user-times"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-users display-4 text-muted opacity-25 mb-3 d-block"></i>
                            <p class="text-muted mb-0">No users found in the system.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
        <div class="card-footer bg-white py-3 border-top-0">
            {{ $users->links() }}
        </div>
    @endif
</div>

<style>
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    .bg-light-hover:hover { background-color: rgba(0,0,0,0.05) !important; }
</style>
@endsection
