@props(['event' => null])

@php
    $eventDateTime = $event->date->format('M j, Y');
    $booked = $event->orders()->where('status', 'completed')->sum('quantity') ?? 0;
    $remaining = $event->capacity - $booked;
    $percentBooked = $event->capacity > 0 ? ($booked / $event->capacity) * 100 : 0;
@endphp

<div class="card event-card border-0 overflow-hidden mb-4 shadow-sm bg-dark position-relative">
    @if($remaining <= 0)
        <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
            <span class="badge bg-danger fw-bold tracking-wide shadow-sm py-2 px-3">SOLD OUT</span>
        </div>
    @elseif($remaining <= 20)
        <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
            <span class="badge bg-warning text-dark fw-bold tracking-wide shadow-sm py-2 px-3">ALMOST FULL</span>
        </div>
    @endif

    <div class="row g-0">
        <!-- Event Image (Col 4) -->
        <div class="col-md-4 position-relative">
            @if($event->image_url)
                <img src="{{ $event->image_url }}" class="img-fluid h-100 w-100 object-fit-cover" alt="{{ $event->title }}" loading="lazy">
            @else
                <div class="h-100 w-100 bg-secondary bg-opacity-25 d-flex align-items-center justify-content-center" style="min-height: 200px;">
                    <i class="fas fa-image fa-3x text-white-50 opacity-25"></i>
                </div>
            @endif
            <!-- Gradient Overlay -->
            <div class="position-absolute top-0 bottom-0 start-0 end-0" style="background: linear-gradient(to right, transparent, rgba(33, 37, 41, 1));"></div>
        </div>

        <!-- Event Details (Col 8) -->
        <div class="col-md-8">
            <div class="card-body p-4 d-flex flex-column h-100">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        @if($event->category)
                            <span class="badge bg-primary bg-opacity-25 text-primary border border-primary border-opacity-50 mb-2">{{ strtoupper($event->category->name) }}</span>
                        @endif
                        <h4 class="card-title text-white fw-bold mb-1">{{ $event->title }}</h4>
                    </div>
                    <div class="text-end">
                        <span class="d-block fs-4 fw-bold text-success mb-0">₹{{ number_format($event->ticket_price, 0) }}</span>
                        <small class="text-white-50">per ticket</small>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-3 text-white-50 small mb-3">
                    <span title="Date & Time"><i class="far fa-calendar-alt text-primary me-2"></i>{{ $eventDateTime }} at {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}</span>
                    <span title="Venue"><i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $event->venue }}</span>
                </div>

                <p class="card-text text-white-50 small mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ $event->description }}
                </p>

                <div class="d-flex align-items-center justify-content-between mt-auto bg-dark border-top border-secondary pt-3">
                    <div class="flex-grow-1 pe-4">
                        <div class="d-flex justify-content-between align-items-end mb-1">
                            <span class="small text-white-50 fw-medium">Availability</span>
                            <span class="small fw-bold {{ $remaining > 20 ? 'text-success' : ($remaining > 0 ? 'text-warning' : 'text-danger') }}">{{ $remaining > 0 ? $remaining . ' left' : 'Full' }}</span>
                        </div>
                        <div class="progress bg-secondary bg-opacity-50" style="height: 6px; border-radius: 3px;">
                            <div class="progress-bar {{ $remaining > 20 ? 'bg-success' : ($remaining > 0 ? 'bg-warning' : 'bg-danger') }}" 
                                 role="progressbar" 
                                 style="width: {{ $percentBooked }}%"
                                 aria-valuenow="{{ $percentBooked }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-light view-performers rounded-pill px-3" data-id="{{ $event->id }}">
                            <i class="fas fa-info-circle me-1"></i> Lineup
                        </button>
                        <button class="btn btn-primary book-ticket rounded-pill px-4 fw-bold shadow-sm" 
                                data-id="{{ $event->id }}"
                                data-price="{{ $event->ticket_price }}"
                                {{ $remaining <= 0 ? 'disabled' : '' }}>
                            {{ $remaining > 0 ? 'Book Ticket' : 'Sold Out' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .tracking-wide { letter-spacing: 0.05em; }
    .z-index-1 { z-index: 1; }
    .object-fit-cover { object-fit: cover; }
    .event-card { transition: transform 0.2s ease, box-shadow 0.2s ease; border: 1px solid rgba(255,255,255,0.05) !important; }
    .event-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.4) !important; border-color: rgba(13, 110, 253, 0.3) !important; }
</style>
