@extends('layouts.admin')

@section('title', 'Manage User Role')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Role Management</h1>
        <p class="text-muted small">Update privileges for: <strong>{{ $user->email }}</strong></p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to Users
        </a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="card-title mb-0 text-primary"><i class="fas fa-user-edit me-2"></i>Profile & Permissions</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <div class="d-flex align-items-center mb-4 pb-4 border-bottom">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=80&background=random" class="rounded-circle shadow-sm border p-1 me-4">
                    <div>
                        <h4 class="mb-1 fw-bold">{{ $user->name }}</h4>
                        <div class="d-flex align-items-center text-muted small mb-2">
                            <i class="far fa-envelope me-2"></i> {{ $user->email }}
                        </div>
                        @if($user->role === 'admin')
                            <span class="badge bg-soft-primary text-primary border border-primary border-opacity-25 px-2 py-1">ADMINISTRATOR</span>
                        @else
                            <span class="badge bg-light text-dark border px-2 py-1">REGULAR USER</span>
                        @endif
                    </div>
                </div>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <h6 class="fw-bold mb-3">Assign System Role</h6>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="position-relative {{ $user->role === 'user' ? 'border-primary bg-primary bg-opacity-10' : 'border-light bg-light' }} border rounded p-3 h-100 transition-all role-card" style="cursor: pointer;">
                                <div class="form-check m-0">
                                    <input class="form-check-input mt-1" type="radio" name="role" id="roleUser" value="user" {{ $user->role === 'user' ? 'checked' : '' }}>
                                    <label class="form-check-label ps-2 w-100" for="roleUser" style="cursor: pointer;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold fs-6"><i class="fas fa-user text-primary me-2"></i> User Access</span>
                                        </div>
                                        <p class="small text-muted mb-0 lh-sm">Standard account for browsing events, purchasing tickets, and managing personal orders.</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="position-relative {{ $user->role === 'admin' ? 'border-danger bg-danger bg-opacity-10' : 'border-light bg-light' }} border rounded p-3 h-100 transition-all role-card" style="cursor: pointer;">
                                <div class="form-check m-0">
                                    <input class="form-check-input mt-1 border-danger" type="radio" name="role" id="roleAdmin" value="admin" {{ $user->role === 'admin' ? 'checked' : '' }}>
                                    <label class="form-check-label ps-2 w-100" for="roleAdmin" style="cursor: pointer;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold fs-6 text-danger"><i class="fas fa-user-shield me-2"></i> Admin Access</span>
                                        </div>
                                        <p class="small text-muted mb-0 lh-sm">Full administrative control. Can manage events, catalog, discount codes, and users.</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(auth()->id() === $user->id)
                        <div class="alert alert-warning border-0 bg-soft-warning d-flex">
                            <i class="fas fa-exclamation-triangle mt-1 me-3 fs-5 text-warning"></i>
                            <div class="small">
                                <strong>Important:</strong> You are currently editing your own profile. You cannot accidentally revoke your own administrative privileges through this interface.
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm" {{ auth()->id() === $user->id && $user->role === 'admin' ? 'disabled' : '' }}>
                            <i class="fas fa-save me-2"></i> Update Configuration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card shadow-sm border-0 mb-4 bg-light">
            <div class="card-header bg-transparent py-3 border-bottom">
                <h5 class="card-title mb-0"><i class="fas fa-chart-pie me-2 text-muted"></i>Activity Summary</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="bg-white p-3 rounded shadow-sm text-center h-100 border">
                            <h3 class="fw-bold mb-0 text-dark">{{ $user->orders()->count() }}</h3>
                            <span class="small text-muted text-uppercase fw-bold" style="letter-spacing: 1px;">Transactions</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white p-3 rounded shadow-sm text-center h-100 border border-success border-opacity-25">
                            <h3 class="fw-bold mb-0 text-success">₹{{ number_format($user->orders()->where('status', 'completed')->sum('total_amount'), 0) }}</h3>
                            <span class="small text-success text-uppercase fw-bold opacity-75" style="letter-spacing: 1px;">Revenue</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded border overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                        <span class="text-muted small fw-bold text-uppercase"><i class="fas fa-fingerprint me-2"></i>Account Status</span>
                        <span class="badge bg-success shadow-sm rounded-pill px-3 py-2">ACTIVE</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <span class="text-muted small fw-bold text-uppercase"><i class="far fa-calendar-plus me-2"></i>Member Since</span>
                        <div class="text-end">
                            <span class="fw-bold d-block text-dark">{{ $user->created_at->format('M d, Y') }}</span>
                            <span class="small text-muted">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); color: #856404; }
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .transition-all { transition: all 0.2s ease; }
    .role-card:hover { transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
</style>

@endsection

@section('scripts')
<script>
    document.querySelectorAll('.role-card').forEach(card => {
        card.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            if (radio && !radio.disabled) {
                radio.checked = true;
                
                // Reset all
                document.querySelectorAll('.role-card').forEach(c => {
                    c.classList.remove('bg-primary', 'bg-opacity-10', 'border-primary');
                    c.classList.remove('bg-danger', 'bg-opacity-10', 'border-danger');
                    c.classList.add('bg-light', 'border-light');
                });

                // Apply active style
                this.classList.remove('bg-light', 'border-light');
                if (radio.value === 'admin') {
                    this.classList.add('bg-danger', 'bg-opacity-10', 'border-danger');
                } else {
                    this.classList.add('bg-primary', 'bg-opacity-10', 'border-primary');
                }
            }
        });
    });
</script>
@endsection
