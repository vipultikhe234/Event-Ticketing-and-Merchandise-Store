@props(['performers'])

<div class="featured-performers">
    <h3 class="mb-4">Featured Performers</h3>
    <div class="row">
        @foreach($performers as $performer)
            <div class="col-md-4 mb-4">
                <div class="card performer-card h-100">
                    <img src="{{ $performer->image_url }}" class="card-img-top" alt="{{ $performer->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $performer->name }}</h5>
                        <p class="card-text text-muted">{{ $performer->genre }}</p>
                        <p class="card-text">{{ Str::limit($performer->bio, 150) }}</p>

                        @if($performer->spotify_id)
                            <button class="btn btn-outline-success btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#spotifyModal"
                                    data-performer="{{ $performer->name }}"
                                    data-spotify-id="{{ $performer->spotify_id }}">
                                <i class="fab fa-spotify"></i> Top Tracks
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
