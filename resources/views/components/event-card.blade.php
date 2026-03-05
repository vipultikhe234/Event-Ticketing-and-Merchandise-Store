@props(['event' => null])

@php
    $eventDateTime = $event->date->format('M j, Y');
@endphp

<div class="card p-0 mb-3">
    <div class="card-header">
        <h5 class="card-title">{{ $event->title }}</h5>
        <div class="meta">
            <div class="meta-item">
                <span class="icon"><i class="fa-regular fa-calendar text-white"></i></span>
                {{$eventDateTime }}
            </div>
            <div class="meta-item">
                <span class="icon"><i class="fa-solid fa-location-dot text-white"></i></span>
                {{$event->venue}}
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="countdown">
            <x-countdown-timer :event="$event" />
        </div>
        <div class="actions">
               <button class="btn btn-primary view-performers" data-id="{{ $event->id }}">
                                    View Performers
                                </button>
                                            <button class="btn btn-success book-ticket" data-id="{{ $event->id }}"
                                    data-price="{{ $event->ticket_price }}">
                                    Book Ticket
                                </button>
        </div>
    </div>
</div>

