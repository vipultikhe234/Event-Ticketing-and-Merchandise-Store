@extends('layouts.admin')

@section('title', 'Edit Performer')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Edit Performer: <span class="text-primary">{{ $performer->name }}</span></h1>
        <p class="text-muted small">Update the artist details and platform integrations.</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.performers.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="row justify-content-center mt-4">
    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="card-title mb-0 text-primary"><i class="fas fa-user-edit me-2"></i>Update Identity</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.performers.update', $performer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Stage Name / Full Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-microphone-alt text-muted"></i></span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror border-start-0" id="name" name="name" value="{{ old('name', $performer->name) }}" placeholder="e.g. Arijit Singh" required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="form-label fw-bold">Primary Category <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-tags text-muted"></i></span>
                            <select class="form-select @error('category_id') is-invalid @enderror border-start-0" id="category_id" name="category_id" required>
                                <option value="">Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $performer->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label fw-bold">Profile Image URL</label>
                        <div class="input-group border rounded overflow-hidden p-1 bg-light">
                            <span class="input-group-text bg-transparent border-0"><i class="fas fa-image text-muted"></i></span>
                            <input type="url" class="form-control border-0 bg-transparent @error('image') is-invalid @enderror" id="image" name="image" value="{{ old('image', $performer->image) }}" placeholder="https://example.com/artist.jpg">
                        </div>
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="spotify_id" class="form-label fw-bold">Spotify Artist ID <small class="text-muted fw-normal">(Optional)</small></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fab fa-spotify text-success"></i></span>
                            <input type="text" class="form-control @error('spotify_id') is-invalid @enderror border-start-0" id="spotify_id" name="spotify_id" value="{{ old('spotify_id', $performer->spotify_id) }}" placeholder="e.g. 4YRxDV8wJF6M6v9YPW9YvU">
                        </div>
                        @error('spotify_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="bio" class="form-label fw-bold">Biography</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="5" placeholder="Write a brief introduction about the artist...">{{ old('bio', $performer->bio) }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4 opacity-10">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.performers.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm">
                            <i class="fas fa-save me-2"></i> Update Performer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0">Current Profile Card</h6>
            </div>
            <div class="card-body text-center py-4">
                <div id="image-preview-container" class="rounded-circle border p-1 d-inline-block bg-white shadow-sm mb-3">
                    <img id="image-preview" src="{{ $performer->image ?: 'https://ui-avatars.com/api/?name=P&size=150' }}" alt="Preview" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <h5 class="fw-bold mb-1">{{ $performer->name }}</h5>
                <span class="badge bg-soft-info text-info mb-3">{{ $performer->category->name ?? 'Uncategorized' }}</span>
                
                <div class="mt-2 pt-2 border-top">
                    <div class="mb-2">
                         @if($performer->spotify_id)
                            <a href="https://open.spotify.com/artist/{{ $performer->spotify_id }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                <i class="fab fa-spotify me-1"></i> View on Spotify
                            </a>
                        @else
                            <button class="btn btn-sm btn-light rounded-pill px-3 disabled">
                                <i class="fab fa-spotify me-1"></i> Not Linked
                            </button>
                        @endif
                    </div>
                    <div class="small text-muted">
                        Performing in <strong>{{ $performer->events()->count() }}</strong> total events.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); color: #087990; }
    .form-control:focus, .form-select:focus { box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.05); }
    .input-group-text { border-color: #dee2e6; }
</style>

@endsection

@section('scripts')
<script>
    const imageInput = document.getElementById('image');
    const previewImage = document.getElementById('image-preview');

    imageInput.addEventListener('input', function() {
        if (this.value) {
            previewImage.src = this.value;
        } else {
            previewImage.src = 'https://ui-avatars.com/api/?name={{ urlencode($performer->name) }}&size=150';
        }
    });
</script>
@endsection
