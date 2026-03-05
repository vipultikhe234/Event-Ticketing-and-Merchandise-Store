@extends('layouts.app')

@section('content')
<style>
    body { background: #f9fafb !important; }
    .order-card { border: 1px solid #e5e7eb !important; border-radius: 12px; background: #fff; transition: box-shadow 0.2s ease; }
    .order-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.08) !important; }
</style>

<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color:#111827;">My Bookings</h1>
            <p class="mb-0" style="color:#6b7280;">Your complete purchase history.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4">
            Browse Events
        </a>
    </div>

    @forelse($orders as $order)
        <div class="order-card shadow-sm mb-3 p-4 position-relative overflow-hidden">
            {{-- Status stripe --}}
            <div class="position-absolute top-0 start-0 bottom-0" style="width:4px; background: {{ $order->status === 'completed' ? '#22c55e' : ($order->status === 'pending' ? '#f59e0b' : '#ef4444') }};"></div>

            <div class="ms-2 row align-items-center g-3">
                {{-- Order ID --}}
                <div class="col-md-2">
                    <div style="color:#9ca3af; font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.06em;">Order ID</div>
                    <div class="fw-bold" style="color:#111827; font-family:monospace; font-size:1rem;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                    <div style="color:#9ca3af; font-size:0.8rem;">{{ $order->created_at->format('M d, Y') }}</div>
                </div>

                {{-- Item --}}
                <div class="col-md-5">
                    @if($order->event)
                        <span class="badge rounded-pill mb-1" style="background:#eff6ff; color:#2563eb; font-size:0.72rem;">EVENT TICKET</span>
                        <h6 class="fw-bold mb-1" style="color:#111827;">{{ $order->event->title }}</h6>
                        <div style="color:#9ca3af; font-size:0.8rem;">
                            <i class="far fa-calendar-alt me-1" style="color:#3b82f6;"></i>{{ \Carbon\Carbon::parse($order->event->date)->format('M d, Y') }}
                            &middot; <i class="fas fa-map-marker-alt me-1" style="color:#ef4444;"></i>{{ $order->event->venue }}
                        </div>
                    @elseif($order->merchandise)
                        <span class="badge rounded-pill mb-1" style="background:#fef9c3; color:#92400e; font-size:0.72rem;">MERCHANDISE</span>
                        <h6 class="fw-bold mb-1" style="color:#111827;">{{ $order->merchandise->name }}</h6>
                        <div style="color:#9ca3af; font-size:0.8rem;">Physical item purchase</div>
                    @else
                        <h6 class="fw-medium mb-0" style="color:#9ca3af;">Product unavailable</h6>
                    @endif
                </div>

                {{-- Stats --}}
                <div class="col-md-3 d-flex gap-4">
                    <div>
                        <div style="color:#9ca3af; font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.06em;">Qty</div>
                        <div class="fw-bold fs-5" style="color:#111827;">{{ $order->quantity }}</div>
                    </div>
                    <div>
                        <div style="color:#9ca3af; font-size:0.75rem; font-weight:600; text-transform:uppercase; letter-spacing:0.06em;">Total</div>
                        <div class="fw-bold fs-5" style="color:#16a34a;">₹{{ number_format($order->total_amount, 0) }}</div>
                    </div>
                </div>

                {{-- Status Badge --}}
                <div class="col-md-2 text-md-end">
                    @if($order->status === 'completed')
                        <span class="badge rounded-pill px-3 py-2" style="background:#dcfce7; color:#15803d;">✓ Paid</span>
                    @elseif($order->status === 'pending')
                        <span class="badge rounded-pill px-3 py-2" style="background:#fef3c7; color:#b45309;">Pending</span>
                    @else
                        <span class="badge rounded-pill px-3 py-2" style="background:#fee2e2; color:#b91c1c;">Failed</span>
                    @endif
                    @if($order->discount_code)
                        <div class="mt-2">
                            <span style="background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; border-radius:6px; padding:2px 10px; font-size:0.75rem; font-family:monospace;">{{ $order->discount_code }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5 rounded-3" style="background:#fff; border:1px solid #e5e7eb;">
            <i class="fas fa-receipt fa-3x mb-3 d-block" style="color:#d1d5db;"></i>
            <h4 style="color:#374151;">No purchases yet</h4>
            <p class="mb-4" style="color:#9ca3af;">You haven't booked any events or bought merchandise yet.</p>
            <a href="{{ url('/dashboard') }}" class="btn btn-primary rounded-pill px-5">Browse Events</a>
        </div>
    @endforelse
</div>
@endsection
