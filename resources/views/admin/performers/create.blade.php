@extends('layouts.admin')

@section('title', 'Create Performer')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Add New Performer</h1>
        <p class="text-muted small">Register a new artist, speaker, or group for your upcoming events.</p>
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
                <h5 class="card-title mb-0 text-primary"><i class="fas fa-user-plus me-2"></i>Performer Identity</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.performers.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Stage Name / Full Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-microphone-alt text-muted"></i></span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror border-start-0" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Arijit Singh" required autofocus>
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
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                            <input type="url" class="form-control border-0 bg-transparent @error('image') is-invalid @enderror" id="image" name="image" value="{{ old('image') }}" placeholder="https://example.com/artist.jpg">
                        </div>
                        <div class="form-text small">Provide a high-quality square image for best results.</div>
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="spotify_id" class="form-label fw-bold">Spotify Artist ID <small class="text-muted fw-normal">(Optional)</small></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fab fa-spotify text-success"></i></span>
                            <input type="text" class="form-control @error('spotify_id') is-invalid @enderror border-start-0" id="spotify_id" name="spotify_id" value="{{ old('spotify_id') }}" placeholder="e.g. 4YRxDV8wJF6M6v9YPW9YvU">
                        </div>
                        <div class="form-text small">Integrate artist's top tracks into event pages automatically.</div>
                        @error('spotify_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="bio" class="form-label fw-bold">Biography</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="5" placeholder="Write a brief introduction about the artist...">{{ old('bio') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4 opacity-10">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.performers.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                            <i class="fas fa-save me-2"></i> Save Performer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fas fa-info-circle text-info me-2"></i>Integration Info</h6>
                <div class="bg-light p-3 rounded mb-3">
                    <p class="small text-muted mb-0">Adding a <strong>Spotify Artist ID</strong> allows the system to fetch and display the artist's top 10 tracks on event pages where they perform.</p>
                </div>
                <div class="text-center">
                    <div id="image-preview-container" class="rounded border p-1 d-inline-block bg-white shadow-sm" style="display: none !important;">
                        <img id="image-preview" src="" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: 4px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus { box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05); }
    .input-group-text { border-color: #dee2e6; }
</style>

@endsection

@section('scripts')
<script>
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('image-preview-container');
    const previewImage = document.getElementById('image-preview');

    imageInput.addEventListener('input', function() {
        if (this.value) {
            previewImage.src = this.value;
            previewContainer.style.setProperty('display', 'inline-block', 'important');
        } else {
            previewContainer.style.setProperty('display', 'none', 'important');
        }
    });

    // Initial check
    if (imageInput.value) {
        previewImage.src = imageInput.value;
        previewContainer.style.setProperty('display', 'inline-block', 'important');
    }
</script>
@endsection
