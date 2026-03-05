@props(['event'])

@php
    $eventId = 'countdown-' . $event->id; // unique ID for each event
@endphp

<div class="countdown-timer mb-3" id="{{ $eventId }}" data-event-date="{{ $event->date->format('Y-m-d H:i:s') }}">
    <h6 class="text-center">Event Starts In:</h6>
    <div class="d-flex justify-content-center align-items-center">
        <div class="text-center mx-2">
            <div class="countdown-box bg-dark text-white rounded p-2">
                <div class="countdown-value days">0 Days</div>
            </div>
        </div>
        <div class="time-sep">: </div>
        <div class="text-center mx-2">
            <div class="countdown-box bg-dark text-white rounded p-2">
                <div class="countdown-value hours">0 Hrs</div>
            </div>
        </div>
                <div class="time-sep">: </div>
        <div class="text-center mx-2">
            <div class="countdown-box bg-dark text-white rounded p-2">
                <div class="countdown-value minutes">0 Mis</div>
            </div>
        </div>
                <div class="time-sep">: </div>
        <div class="text-center mx-2">
            <div class="countdown-box bg-dark text-white rounded p-2">
                <div class="countdown-value seconds">0 Sec</div>
            </div>
        </div>
    </div>
</div>

<style>
    .countdown-box {
        min-width: 60px;
    }

    .countdown-value {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .countdown-label {
        font-size: 0.75rem;
        opacity: 0.8;
    }
</style>
