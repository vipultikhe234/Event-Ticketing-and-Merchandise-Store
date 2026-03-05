@extends('layouts.admin')

@section('title', 'Admin Control Center')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <div>
        <h1 class="h2 mb-0 fw-bold">Command Center</h1>
        <p class="text-muted small">Platform overview and quick management access.</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <span class="btn btn-sm btn-outline-secondary disabled rounded-pill px-3">
                <i class="far fa-clock me-1"></i> {{ now()->format('M d, Y') }}
            </span>
        </div>
    </div>
</div>

<!-- Key Metrics Row -->
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-4">
    <!-- Total Revenue -->
    <div class="col">
        <div class="card stat-card bg-primary text-white h-100 shadow-sm border-0 overflow-hidden position-relative">
            <div class="card-body p-4 position-relative z-index-1">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0 fw-bold text-uppercase opacity-75" style="letter-spacing: 1px;">Gross Revenue</h6>
                    <div class="bg-white bg-opacity-25 rounded p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                         <i class="fas fa-wallet fs-5"></i>
                    </div>
                </div>
                <h2 class="display-6 fw-bold mb-1">₹{{ number_format($stats['total_revenue'], 0) }}</h2>
                <div class="d-flex align-items-center text-white text-opacity-75 small">
                    <i class="fas fa-shopping-cart me-1"></i> From {{ $stats['orders_count'] }} successful orders
                </div>
            </div>
            <!-- Decorative circle -->
            <div class="position-absolute top-0 end-0 translate-middle-y bg-white bg-opacity-10 rounded-circle" style="width: 150px; height: 150px; margin-right: -20px;"></div>
        </div>
    </div>

    <!-- Events -->
    <div class="col">
        <div class="card stat-card bg-success text-white h-100 shadow-sm border-0 overflow-hidden position-relative">
            <div class="card-body p-4 position-relative z-index-1">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0 fw-bold text-uppercase opacity-75" style="letter-spacing: 1px;">Active Events</h6>
                    <div class="bg-white bg-opacity-25 rounded p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-calendar-alt fs-5"></i>
                    </div>
                </div>
                <h2 class="display-6 fw-bold mb-1">{{ $stats['events'] }}</h2>
            </div>
            <div class="card-footer bg-success-dark border-0 p-3">
                <a href="{{ route('admin.events.index') }}" class="text-white text-decoration-none small fw-bold d-flex justify-content-between align-items-center stretched-link">
                    <span>Manage Catalog</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
             <!-- Decorative circle -->
            <div class="position-absolute bottom-0 start-0 translate-middle-y bg-white bg-opacity-10 rounded-circle" style="width: 100px; height: 100px; margin-left: -20px; z-index: 0;"></div>
        </div>
    </div>
    
    <!-- Merchandise -->
    <div class="col">
        <div class="card stat-card bg-info text-white h-100 shadow-sm border-0 overflow-hidden position-relative">
            <div class="card-body p-4 position-relative z-index-1">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0 fw-bold text-uppercase opacity-75" style="letter-spacing: 1px;">Merchandise</h6>
                    <div class="bg-white bg-opacity-25 rounded p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-tshirt fs-5"></i>
                    </div>
                </div>
                <h2 class="display-6 fw-bold mb-1">{{ $stats['merchandise'] }}</h2>
            </div>
            <div class="card-footer bg-info-dark border-0 p-3">
                <a href="{{ route('admin.merchandise.index') }}" class="text-white text-decoration-none small fw-bold d-flex justify-content-between align-items-center stretched-link">
                    <span>Manage Inventory</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
             <!-- Decorative circle -->
            <div class="position-absolute top-50 end-0 translate-middle-y bg-white bg-opacity-10 rounded-circle" style="width: 120px; height: 120px; margin-right: -40px; z-index: 0;"></div>
        </div>
    </div>

     <!-- Performers -->
     <div class="col">
        <div class="card stat-card bg-warning text-dark h-100 shadow-sm border-0 overflow-hidden position-relative">
            <div class="card-body p-4 position-relative z-index-1">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="card-title mb-0 fw-bold text-uppercase opacity-75" style="letter-spacing: 1px;">Performers</h6>
                    <div class="bg-dark bg-opacity-10 rounded p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-microphone-alt fs-5"></i>
                    </div>
                </div>
                <h2 class="display-6 fw-bold mb-1">{{ $stats['performers'] }}</h2>
            </div>
            <div class="card-footer bg-warning-dark border-0 p-3">
                <a href="{{ route('admin.performers.index') }}" class="text-dark text-decoration-none small fw-bold d-flex justify-content-between align-items-center stretched-link">
                    <span>Manage Roster</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
             <!-- Decorative circle -->
             <div class="position-absolute bottom-0 end-0 translate-middle-y bg-dark bg-opacity-5 rounded-circle" style="width: 100px; height: 100px; margin-right: -20px; z-index: 0;"></div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Secondary Stats -->
    <div class="col-xl-3 col-lg-4">
        <div class="card shadow-sm border-0 mb-4 h-100">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h6 class="fw-bold mb-0 text-dark"><i class="fas fa-cogs mx-2 text-secondary"></i>System Settings</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3 border-light">
                        <div>
                            <i class="fas fa-tags text-primary mx-2"></i>
                            <span class="fw-medium">Categories</span>
                        </div>
                        <span class="badge bg-soft-primary text-primary rounded-pill">{{ $stats['categories'] }}</span>
                    </a>
                    <a href="{{ route('admin.discount-codes.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3 border-light">
                        <div>
                            <i class="fas fa-percent text-success mx-2"></i>
                            <span class="fw-medium">Discount Codes</span>
                        </div>
                        <span class="badge bg-soft-success text-success rounded-pill">{{ $stats['discount_codes'] }}</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3 border-light">
                        <div>
                            <i class="fas fa-users text-info mx-2"></i>
                            <span class="fw-medium">User Accounts</span>
                        </div>
                        <i class="fas fa-chevron-right text-muted small"></i>
                    </a>
                </div>
            </div>
            <div class="card-footer bg-light border-0 py-3 mt-auto">
                 <div class="d-flex align-items-center text-muted small">
                    <i class="fas fa-shield-alt text-success me-2"></i>
                    <span>All systems operational</span>
                 </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="col-xl-9 col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0 fw-bold"><i class="fas fa-history mx-2 text-primary"></i>Recent Transactions</h6>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light rounded-pill px-3 shadow-none text-primary fw-medium small">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 small text-uppercase text-muted fw-bold">Order ID</th>
                                <th class="py-3 small text-uppercase text-muted fw-bold">Customer</th>
                                <th class="py-3 small text-uppercase text-muted fw-bold">Item</th>
                                <th class="py-3 small text-uppercase text-muted fw-bold text-end">Amount</th>
                                <th class="py-3 small text-uppercase text-muted fw-bold text-center">Status</th>
                                <th class="pe-4 py-3 small text-uppercase text-muted fw-bold text-end">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td class="ps-4">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="fw-bold font-monospace text-decoration-none">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</a>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $order->user->name ?? 'Deleted Guest' }}</div>
                                </td>
                                <td>
                                    @if($order->event)
                                        <span class="badge bg-soft-info text-info border border-info border-opacity-25 p-1 px-2 me-1" title="Ticket">
                                            <i class="fas fa-ticket-alt"></i>
                                        </span>
                                        <span class="small fw-medium">{{ Str::limit($order->event->title, 20) }}</span>
                                    @elseif($order->merchandise)
                                         <span class="badge bg-soft-warning text-warning border border-warning border-opacity-25 p-1 px-2 me-1" title="Merch">
                                            <i class="fas fa-shopping-bag"></i>
                                        </span>
                                        <span class="small fw-medium">{{ Str::limit($order->merchandise->name, 20) }}</span>
                                    @else
                                        <span class="text-muted small">N/A</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold text-success">₹{{ number_format($order->total_amount, 2) }}</td>
                                <td class="text-center">
                                    @if($order->status === 'completed')
                                        <span class="badge bg-soft-success text-success border border-success border-opacity-25 px-2 py-1"><i class="fas fa-check-circle me-1"></i> PAID</span>
                                    @elseif($order->status === 'pending')
                                        <span class="badge bg-soft-warning text-dark border border-warning border-opacity-25 px-2 py-1"><i class="fas fa-clock me-1"></i> PENDING</span>
                                    @else
                                        <span class="badge bg-soft-danger text-danger border border-danger border-opacity-25 px-2 py-1"><i class="fas fa-times-circle me-1"></i> FAILED</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4 text-muted small">
                                    {{ $order->created_at->diffForHumans(null, true, true) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-receipt display-4 text-muted opacity-25 mb-3 d-block"></i>
                                    <p class="text-muted mb-0">No recent transactions found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
    .z-index-1 { z-index: 1; }
    
    .bg-success-dark { background-color: rgba(0, 0, 0, 0.15); }
    .bg-info-dark { background-color: rgba(0, 0, 0, 0.1); }
    .bg-warning-dark { background-color: rgba(0, 0, 0, 0.05); }
    
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); }
</style>
@endsection
