@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="text-white fw-bold mb-0">Booking History</h2>
            <p class="text-white-50">View all your event tickets and merchandise purchases</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @forelse($orders as $order)
                <div class="card bg-dark border-secondary mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center border-end border-secondary">
                                <div class="text-white-50 small mb-1">ORDER ID</div>
                                <div class="text-white fw-bold">#{{ $order->id }}</div>
                            </div>
                            <div class="col-md-4">
                                @if($order->event)
                                    <h5 class="text-info mb-1"><i class="fas fa-ticket-alt me-2"></i>{{ $order->event->title }}</h5>
                                    <div class="text-white-50 small">
                                        <i class="fas fa-calendar-day me-1"></i> {{ \Carbon\Carbon::parse($order->event->date)->format('M d, Y') }}
                                        <span class="mx-2">|</span>
                                        <i class="fas fa-map-marker-alt me-1"></i> {{ $order->event->venue }}
                                    </div>
                                @elseif($order->merchandise)
                                    <h5 class="text-warning mb-1"><i class="fas fa-shopping-bag me-2"></i>{{ $order->merchandise->name }}</h5>
                                    <div class="text-white-50 small">Merchandise Purchase</div>
                                @else
                                    <h5 class="text-white mb-1">Unknown Product</h5>
                                @endif
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="text-white-50 small mb-1">QUANTITY</div>
                                <div class="text-white fs-5 fw-bold">{{ $order->quantity }}</div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="text-white-50 small mb-1">TOTAL AMOUNT</div>
                                <div class="text-success fs-5 fw-bold">₹{{ number_format($order->total_amount, 2) }}</div>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="badge {{ $order->status === 'completed' ? 'bg-success' : ($order->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }} px-3 py-2">
                                    {{ strtoupper($order->status) }}
                                </span>
                                <div class="mt-2 text-white-50 small">
                                    {{ $order->created_at->format('M d, H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($order->discount_code)
                        <div class="card-footer bg-black bg-opacity-25 border-top border-secondary py-1 text-center">
                            <small class="text-info">Applied Coupon: <strong>{{ $order->discount_code }}</strong></small>
                        </div>
                    @endif
                </div>
            @empty
                <div class="alert alert-info bg-dark border-info text-white text-center py-5">
                    <i class="fas fa-calendar-times mb-3 display-4 d-block text-white-50"></i>
                    <h4>No bookings found</h4>
                    <p class="text-white-50 mb-4">You haven't booked any events or bought merchandise yet.</p>
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-info">Explore Featured Events</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
