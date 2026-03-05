@extends('layouts.admin')

@section('title', 'Manage Orders')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Manage Orders</h1>
        <p class="text-muted small">Monitor ticket sales and merchandise purchases.</p>
    </div>
</div>

<div class="card shadow-sm border-0 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3">Order ID</th>
                        <th class="py-3">Customer</th>
                        <th class="py-3">Purchased Item</th>
                        <th class="py-3">Amount</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3">Date</th>
                        <th class="text-end pe-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="align-middle">
                        <td class="ps-4">
                            <span class="fw-bold font-monospace text-primary">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            @if($order->user)
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($order->user->name) }}&size=32&background=random" class="rounded-circle me-2 shadow-sm border" style="width: 32px; height: 32px;">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $order->user->name }}</div>
                                        <small class="text-muted"><i class="far fa-envelope me-1"></i>{{ Str::limit($order->user->email, 20) }}</small>
                                    </div>
                                </div>
                            @else
                                <div class="text-muted"><i class="fas fa-user-times me-2"></i>Deleted User</div>
                            @endif
                        </td>
                        <td>
                            @if($order->event)
                                <span class="badge bg-soft-info text-info border border-info border-opacity-25 p-1 px-2 mb-1">
                                    <i class="fas fa-ticket-alt me-1"></i> Ticket
                                </span>
                                <div class="fw-medium text-dark small text-truncate" style="max-width: 200px;" title="{{ $order->event->title }}">
                                    {{ Str::limit($order->event->title, 25) }}
                                </div>
                            @elseif($order->merchandise)
                                <span class="badge bg-soft-warning text-warning border border-warning border-opacity-25 p-1 px-2 mb-1">
                                    <i class="fas fa-shopping-bag me-1"></i> Merchandise
                                </span>
                                <div class="fw-medium text-dark small text-truncate" style="max-width: 200px;" title="{{ $order->merchandise->name }}">
                                    {{ Str::limit($order->merchandise->name, 25) }}
                                </div>
                            @else
                                <span class="text-muted small"><i class="fas fa-question-circle me-1"></i> Item Unavailable</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-success">₹{{ number_format($order->total_amount, 2) }}</div>
                            <small class="text-muted d-block">Qty: {{ $order->quantity }}</small>
                            @if($order->discount_code)
                                <span class="badge bg-light text-dark border border-secondary border-opacity-25" style="font-size: 0.65rem;">
                                    <i class="fas fa-tag me-1 text-muted"></i>{{ $order->discount_code }}
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm shadow-none cursor-pointer {{ 
                                    $order->status === 'completed' ? 'border-success text-success bg-soft-success fw-bold' : 
                                    ($order->status === 'pending' ? 'border-warning text-dark bg-soft-warning fw-bold' : 'border-danger text-danger bg-soft-danger fw-bold') 
                                }}" onchange="this.form.submit()" style="width: 130px; border-radius: 8px;">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }} class="fw-medium text-dark">PENDING</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }} class="fw-medium text-dark">COMPLETED</option>
                                    <option value="failed" {{ $order->status === 'failed' ? 'selected' : '' }} class="fw-medium text-dark">FAILED</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <div class="small fw-medium text-dark">{{ $order->created_at->format('M d, Y') }}</div>
                            <small class="text-muted"><i class="far fa-clock me-1"></i>{{ $order->created_at->format('h:i A') }}</small>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-primary border-0 bg-light-hover" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete this order record? This cannot be reversed.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger border-0 bg-light-hover" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-receipt display-4 text-muted opacity-25 mb-3 d-block"></i>
                            <p class="text-muted mb-0">No orders have been placed yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
        <div class="card-footer bg-white py-3 border-top-0">
            {{ $orders->links() }}
        </div>
    @endif
</div>

<style>
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); }
    .text-info { color: #0dcaf0 !important; }
    .cursor-pointer { cursor: pointer; }
    .bg-light-hover:hover { background-color: rgba(0,0,0,0.05) !important; }
</style>
@endsection
