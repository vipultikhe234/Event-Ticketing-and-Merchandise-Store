@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Upcoming Events</h1>

        @if ($events->isNotEmpty())
            @foreach ($events as $event)
                <x-event-card :event="$event" />
            @endforeach
            <p>No events found.</p>
        @endif
    </div>
@endsection
