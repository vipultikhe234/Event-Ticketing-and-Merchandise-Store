@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Transaction Ref: <span class="text-primary font-monospace">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></h1>
        <p class="text-muted small">View comprehensive details about this purchase.</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to Orders
        </a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="card-title mb-0 text-primary"><i class="fas fa-box-open mx-2"></i>Purchased Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="bg-light p-4 mx-4 mb-4 rounded border d-flex align-items-center gap-4 position-relative">
                    @if($order->status === 'completed')
                        <div class="position-absolute top-0 end-0 mt-3 me-3">
                            <span class="badge bg-success rounded-circle p-2 shadow-sm"><i class="fas fa-check text-white"></i></span>
                        </div>
                    @endif

                    <div class="flex-shrink-0">
                        @if($order->event)
                            @if($order->event->image_url)
                                <img src="{{ $order->event->image_url }}" class="img-fluid rounded shadow-sm object-fit-cover" style="width: 120px; height: 120px;">
                            @else
                                <div class="bg-white rounded border d-flex align-items-center justify-content-center shadow-sm" style="width: 120px; height: 120px;">
                                    <i class="fas fa-ticket-alt fa-3x text-info opacity-50"></i>
                                </div>
                            @endif
                        @elseif($order->merchandise)
                             @if($order->merchandise->image)
                                <img src="{{ $order->merchandise->image }}" class="img-fluid rounded shadow-sm object-fit-cover" style="width: 120px; height: 120px;">
                            @else
                                <div class="bg-white rounded border d-flex align-items-center justify-content-center shadow-sm" style="width: 120px; height: 120px;">
                                    <i class="fas fa-tshirt fa-3x text-warning opacity-50"></i>
                                </div>
                            @endif
                        @else
                            <div class="bg-white rounded border d-flex align-items-center justify-content-center shadow-sm" style="width: 120px; height: 120px;">
                                <i class="fas fa-question-circle fa-3x text-muted opacity-25"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-grow-1">
                        @if($order->event)
                            <span class="badge bg-soft-info text-info border border-info border-opacity-25 px-2 py-1 mb-2 fw-medium">
                                <i class="fas fa-calendar-check me-1 small"></i> EVENT TICKET
                            </span>
                            <h4 class="text-dark fw-bold mb-2">{{ $order->event->title }}</h4>
                            <div class="d-flex flex-wrap gap-3 text-muted small">
                                <span><i class="far fa-calendar-alt me-1 text-primary"></i> {{ \Carbon\Carbon::parse($order->event->date)->format('M d, Y') }}</span>
                                <span><i class="far fa-clock me-1 text-primary"></i> {{ \Carbon\Carbon::parse($order->event->time)->format('h:i A') }}</span>
                                <span><i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $order->event->venue }}</span>
                            </div>
                        @elseif($order->merchandise)
                             <span class="badge bg-soft-warning text-warning border border-warning border-opacity-25 px-2 py-1 mb-2 fw-medium">
                                <i class="fas fa-shopping-bag me-1 small"></i> MERCHANDISE
                            </span>
                            <h4 class="text-dark fw-bold mb-2">{{ $order->merchandise->name }}</h4>
                            <p class="text-muted small mb-0 lh-sm">{{ Str::limit($order->merchandise->description, 120) }}</p>
                        @endif
                    </div>
                </div>

                <div class="table-responsive px-4 pb-4">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="border-bottom">
                            <tr class="text-muted small text-uppercase">
                                <th class="ps-3 py-3">Description</th>
                                <th class="text-center py-3">Unit Price</th>
                                <th class="text-center py-3">Quantity</th>
                                <th class="text-end pe-3 py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="border-bottom">
                            <tr>
                                <td class="ps-3 py-4 fw-bold text-dark">
                                    {{ $order->event->title ?? ($order->merchandise->name ?? 'Unavailable Item') }}
                                </td>
                                <td class="text-center text-muted">
                                    @if($order->event)
                                        ₹{{ number_format($order->event->ticket_price, 2) }}
                                    @elseif($order->merchandise)
                                        ₹{{ number_format($order->merchandise->price, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border px-3 py-2 fs-6">{{ $order->quantity }}</span>
                                </td>
                                <td class="text-end pe-3 fw-bold text-dark">
                                    @if($order->event)
                                        ₹{{ number_format($order->event->ticket_price * $order->quantity, 2) }}
                                    @elseif($order->merchandise)
                                        ₹{{ number_format($order->merchandise->price * $order->quantity, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            @if($order->discount_code)
                            <tr>
                                <td colspan="3" class="text-end pt-4 pb-2 text-muted">
                                    Discount (<span class="badge bg-dark fw-normal font-monospace px-2">{{ $order->discount_code }}</span>)
                                </td>
                                <td class="text-end pt-4 pb-2 text-success fw-bold">
                                    -₹{{ number_format((($order->event ? $order->event->ticket_price : ($order->merchandise ? $order->merchandise->price : 0)) * $order->quantity) - $order->total_amount, 2) }}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="3" class="text-end py-3 fw-bold text-uppercase fs-5">Final Total</td>
                                <td class="text-end py-3 fw-bold text-primary fs-4">₹{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        @if($order->stripe_session_id)
        <div class="card shadow-sm border-0 border-start border-4 border-info">
            <div class="card-body py-3 px-4">
                 <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-bold text-dark"><i class="fab fa-stripe me-2 text-info fs-5 align-middle"></i>Payment Gateway Reference</h6>
                        <span class="font-monospace text-muted small bg-light p-1 px-2 rounded">{{ $order->stripe_session_id }}</span>
                    </div>
                    <span class="badge bg-soft-info text-info"><i class="fas fa-link me-1"></i>SECURE</span>
                 </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Customer Info -->
        <div class="card shadow-sm border-0 mb-4 bg-light">
            <div class="card-header bg-transparent py-3 border-bottom">
                <h6 class="card-title mb-0 fw-bold"><i class="far fa-address-card mx-2 text-primary"></i>Customer Profile</h6>
            </div>
            <div class="card-body py-4 text-center">
                @if($order->user)
                    <div class="position-relative d-inline-block mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($order->user->name) }}&size=90&background=random" class="rounded-circle shadow-sm border border-white border-3">
                        @if($order->user->role === 'admin')
                            <span class="position-absolute bottom-0 end-0 p-1 bg-danger border border-light rounded-circle" title="Admin User"></span>
                        @else
                            <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle" title="Regular User"></span>
                        @endif
                    </div>
                    <h5 class="mb-1 text-dark fw-bold">{{ $order->user->name }}</h5>
                    <p class="text-muted small mb-4"><i class="far fa-envelope me-1"></i>{{ $order->user->email }}</p>
                    
                    <div class="d-flex justify-content-center gap-2">
                        <a href="mailto:{{ $order->user->email }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm bg-white">
                            <i class="fas fa-paper-plane me-2"></i>Email User
                        </a>
                        <a href="{{ route('admin.users.edit', $order->user->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm bg-white">
                            <i class="fas fa-user-cog me-2"></i>Profile
                        </a>
                    </div>
                @else
                    <div class="mb-3">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-sm border border-white border-3" style="width: 90px; height: 90px;">
                            <i class="fas fa-user-times fa-3x text-muted opacity-25"></i>
                        </div>
                    </div>
                    <h5 class="mb-1 text-muted fw-bold">Account Deleted</h5>
                    <p class="small text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i>Owner information unavailable</p>
                @endif
            </div>
        </div>

        <!-- Order Logs -->
        <div class="card shadow-sm border-0">
             <div class="card-header bg-white py-3">
                <h6 class="card-title mb-0 fw-bold"><i class="fas fa-history mx-2 text-secondary"></i>Transaction Status</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="mb-4 pb-4 border-bottom">
                    @csrf
                    @method('PUT')
                    <label class="form-label small text-muted text-uppercase fw-bold mb-2">Current State</label>
                    <select name="status" class="form-select form-select-lg shadow-none cursor-pointer mb-3 {{ 
                        $order->status === 'completed' ? 'border-success text-success bg-soft-success fw-bold' : 
                        ($order->status === 'pending' ? 'border-warning text-dark bg-soft-warning fw-bold' : 'border-danger text-danger bg-soft-danger fw-bold') 
                    }}" onchange="this.form.submit()">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }} class="fw-medium text-dark">🟡 Pending Processing</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }} class="fw-medium text-dark">🟢 Payment Completed</option>
                        <option value="failed" {{ $order->status === 'failed' ? 'selected' : '' }} class="fw-medium text-dark">🔴 Transaction Failed</option>
                    </select>
                    <div class="form-text small lh-sm">Updating the status here manually overrides the gateway webhook. Use with caution.</div>
                </form>

                <div class="position-relative ps-4 border-start border-2 border-primary border-opacity-25 pb-3">
                    <span class="position-absolute top-0 start-0 translate-middle p-2 bg-primary border border-light rounded-circle"></span>
                    <div class="small fw-bold text-dark mt-n1">Order Created</div>
                    <div class="small text-muted mb-1">{{ $order->created_at->format('M d, Y') }} at {{ $order->created_at->format('h:i A') }}</div>
                    <div class="small text-secondary fw-medium">By {{ $order->user->name ?? 'Unknown' }}</div>
                </div>

                @if($order->updated_at > $order->created_at)
                    <div class="position-relative ps-4 border-start border-2 border-secondary border-opacity-25 pt-3">
                        <span class="position-absolute top-50 start-0 translate-middle p-2 bg-secondary border border-light rounded-circle mt-3"></span>
                        <div class="small fw-bold text-dark mt-n1">Last Modified</div>
                        <div class="small text-muted">{{ $order->updated_at->format('M d, Y') }} at {{ $order->updated_at->format('h:i A') }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); }
    .cursor-pointer { cursor: pointer; }
    .object-fit-cover { object-fit: cover; }
    
    /* Custom vertical timeline dotted style */
    .border-start {
        border-right-style: dashed !important;
    }
</style>

@endsection
