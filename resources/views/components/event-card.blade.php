@props(['event' => null])

@php
    $booked = $event->orders()->where('status', 'completed')->sum('quantity') ?? 0;
    $remaining = max(0, $event->capacity - $booked);
    $percentBooked = $event->capacity > 0 ? min(100, ($booked / $event->capacity) * 100) : 0;
@endphp

<div class="card border shadow-sm h-100 overflow-hidden event-card" style="border-color: #e5e7eb !important; border-radius: 12px;">
    {{-- Image --}}
    @if($event->image_url)
        <img src="{{ $event->image_url }}" class="card-img-top" alt="{{ $event->title }}" style="height: 190px; object-fit: cover;">
    @else
        <div class="d-flex align-items-center justify-content-center" style="height: 190px; background: #f3f4f6;">
            <i class="fas fa-calendar-alt fa-2x" style="color: #d1d5db;"></i>
        </div>
    @endif

    <div class="card-body d-flex flex-column p-4" style="background: #fff;">
        {{-- Category + Badge --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            @if($event->category)
                <span class="badge rounded-pill px-3 py-1" style="background:#eff6ff; color:#2563eb; font-size:0.75rem; font-weight:600;">{{ $event->category->name }}</span>
            @else
                <span></span>
            @endif
            @if($remaining <= 0)
                <span class="badge rounded-pill bg-danger px-3 py-1" style="font-size:0.75rem;">Sold Out</span>
            @elseif($remaining <= 20)
                <span class="badge rounded-pill px-3 py-1" style="background:#fef3c7; color:#b45309; font-size:0.75rem;">{{ $remaining }} left</span>
            @endif
        </div>

        {{-- Title --}}
        <h5 class="fw-bold mb-2" style="color: #111827;">{{ $event->title }}</h5>

        {{-- Meta --}}
        <div class="mb-3" style="color: #6b7280; font-size: 0.875rem;">
            <div class="mb-1"><i class="far fa-calendar-alt me-2" style="color:#3b82f6;"></i>{{ $event->date->format('M d, Y') }} &middot; {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</div>
            <div><i class="fas fa-map-marker-alt me-2" style="color:#ef4444;"></i>{{ $event->venue }}</div>
        </div>

        {{-- Description --}}
        <p class="mb-4 flex-grow-1" style="color:#9ca3af; font-size:0.875rem; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $event->description }}</p>

        {{-- Availability Bar --}}
        <div class="mb-4">
            <div class="d-flex justify-content-between mb-1">
                <small style="color:#9ca3af;">Availability</small>
                <small style="color: {{ $remaining > 20 ? '#16a34a' : ($remaining > 0 ? '#d97706' : '#dc2626') }}; font-weight:600;">
                    {{ $remaining > 0 ? $remaining . ' seats left' : 'Fully Booked' }}
                </small>
            </div>
            <div style="height:5px; background:#f3f4f6; border-radius:5px; overflow:hidden;">
                <div style="height:100%; width:{{ $percentBooked }}%; background:{{ $remaining > 20 ? '#22c55e' : ($remaining > 0 ? '#f59e0b' : '#ef4444') }}; border-radius:5px; transition:width 0.4s;"></div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="d-flex justify-content-between align-items-center mt-auto pt-3" style="border-top: 1px solid #f3f4f6;">
            <div>
                <span class="fw-bold fs-5" style="color:#111827;">₹{{ number_format($event->ticket_price, 0) }}</span>
                <span class="ms-1" style="color:#9ca3af; font-size:0.8rem;">/ ticket</span>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-sm view-performers"
                        style="border: 1px solid #d1d5db; color:#374151; border-radius:8px; font-size:0.85rem;"
                        data-id="{{ $event->id }}">
                    Lineup
                </button>
                <button class="btn btn-sm book-ticket {{ $remaining > 0 ? '' : 'disabled' }}"
                        style="background:#2563eb; color:#fff; border-radius:8px; font-size:0.85rem; border:none;"
                        data-id="{{ $event->id }}"
                        data-price="{{ $event->ticket_price }}"
                        {{ $remaining <= 0 ? 'disabled' : '' }}>
                    {{ $remaining > 0 ? 'Book Now' : 'Sold Out' }}
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .event-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .event-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; }
</style>
