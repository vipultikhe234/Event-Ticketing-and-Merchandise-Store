@extends('layouts.admin')

@section('title', 'Create Event')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Schedule New Event</h1>
        <p class="text-muted small">Plan a new music experience and manage ticket availability.</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-primary"><i class="fas fa-info-circle me-2"></i>Event Details</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Event Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Bollywood Summer Fest 2026">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="8" required placeholder="Describe the experience, the lineup, and any special instructions for attendees...">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="venue" class="form-label fw-bold">Venue / Location <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" class="form-control @error('venue') is-invalid @enderror" id="venue" name="venue" value="{{ old('venue') }}" required placeholder="e.g. JIIT Grounds, Noida">
                                </div>
                                @error('venue') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-4">
                                <label for="date" class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" required>
                                @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-4">
                                <label for="time" class="form-label fw-bold">Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('time') is-invalid @enderror" id="time" name="time" value="{{ old('time') }}" required>
                                @error('time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-primary"><i class="fas fa-ticket-alt me-2"></i>Pricing & Capacity</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <label for="ticket_price" class="form-label fw-bold">Ticket Price <span class="text-danger">*</span></label>
                            <div class="input-group border rounded p-1 bg-light">
                                <span class="input-group-text bg-transparent border-0 fw-bold">₹</span>
                                <input type="number" step="0.01" class="form-control border-0 bg-transparent fw-bold text-success fs-5 @error('ticket_price') is-invalid @enderror" id="ticket_price" name="ticket_price" value="{{ old('ticket_price') }}" required placeholder="0.00">
                            </div>
                            @error('ticket_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-2 text-center text-muted">
                            <div class="h3 mb-0">×</div>
                        </div>
                        <div class="col-md-5">
                            <label for="capacity" class="form-label fw-bold">Maximum Capacity <span class="text-danger">*</span></label>
                            <div class="input-group border rounded p-1 bg-light">
                                <span class="input-group-text bg-transparent border-0"><i class="fas fa-users text-muted"></i></span>
                                <input type="number" class="form-control border-0 bg-transparent fw-bold @error('capacity') is-invalid @enderror" id="capacity" name="capacity" value="{{ old('capacity') }}" required placeholder="500">
                            </div>
                            @error('capacity') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-primary"><i class="fas fa-cog me-2"></i>Classification</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-4">
                        <label for="category_id" class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Assigned Performers <span class="text-danger">*</span></label>
                        <div class="border rounded p-3 bg-light scrollable-selection" style="max-height: 250px; overflow-y: auto;">
                            @forelse($performers as $performer)
                                <div class="form-check custom-checkbox mb-2">
                                    <input class="form-check-input" type="checkbox" name="performers[]" value="{{ $performer->id }}" id="performer_{{ $performer->id }}" {{ is_array(old('performers')) && in_array($performer->id, old('performers')) ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex align-items-center" for="performer_{{ $performer->id }}">
                                        @if($performer->image)
                                            <img src="{{ $performer->image }}" class="rounded-circle me-2" style="width: 24px; height: 24px; object-fit: cover;">
                                        @endif
                                        <span>{{ $performer->name }}</span>
                                    </label>
                                </div>
                            @empty
                                <div class="text-center py-3 text-muted">
                                    <small>No performers found. Please create one first.</small>
                                </div>
                            @endforelse
                        </div>
                        @error('performers') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-primary"><i class="fas fa-image me-2"></i>Event Media</h5>
                </div>
                <div class="card-body p-4 pt-3">
                    {{-- Current image preview --}}
                    <div class="mb-3 text-center" id="image-preview-wrapper" style="display: none;">
                        <img id="image-preview" 
                             src=""
                             class="img-fluid rounded border" 
                             style="max-height: 220px; width: 100%; object-fit: cover;"
                             alt="Preview">
                    </div>

                    {{-- Upload local file --}}
                    <div class="mb-3">
                        <label for="image_file" class="form-label fw-bold">Upload from Computer</label>
                        <input type="file" class="form-control @error('image_file') is-invalid @enderror" id="image_file" name="image_file" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewLocalFile(this)">
                        <div class="form-text">JPG, PNG or WebP. Max 2MB. <strong>This overrides the URL below.</strong></div>
                        <div id="image_file_error" class="invalid-feedback" style="display:none;">File must be less than 2MB.</div>
                        @error('image_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Divider --}}
                    <div class="d-flex align-items-center gap-2 mb-3 text-muted small">
                        <hr class="flex-grow-1 my-0"> OR <hr class="flex-grow-1 my-0">
                    </div>

                    {{-- URL fallback --}}
                    <div class="mb-0">
                        <label for="image_url" class="form-label fw-bold">Image URL</label>
                        <input type="url" class="form-control @error('image_url') is-invalid @enderror" id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="https://example.com/banner.jpg" oninput="previewUrl(this.value)">
                        @error('image_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow">
                    <i class="fas fa-calendar-check me-2"></i> Publish Event
                </button>
                <a href="{{ route('admin.events.index') }}" class="btn btn-light rounded-pill">Cancel</a>
            </div>
        </div>
    </div>
</form>

<style>
    .scrollable-selection::-webkit-scrollbar { width: 5px; }
    .scrollable-selection::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 10px; }
    .custom-checkbox .form-check-input:checked { background-color: #0d6efd; border-color: #0d6efd; }
    .form-control:focus, .form-select:focus { box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05); }
    .input-group-text { border-color: #dee2e6; }
</style>
@endsection

@section('scripts')
<script>
    const previewWrapper = document.getElementById('image-preview-wrapper');
    const previewImg = document.getElementById('image-preview');

    function previewUrl(url) {
        const fileInput = document.getElementById('image_file');
        if (fileInput.files && fileInput.files[0]) return;
        
        if (url) {
            previewImg.src = url;
            previewWrapper.style.display = 'block';
            previewImg.onerror = function() {
                this.src = 'https://placehold.co/600x300?text=Invalid+Image+URL';
            };
        } else {
            previewWrapper.style.display = 'none';
        }
    }

    function previewLocalFile(input) {
        const errorDiv = document.getElementById('image_file_error');
        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Check file size (2MB = 2 * 1024 * 1024 bytes)
            if (file.size > 2 * 1024 * 1024) {
                input.classList.add('is-invalid');
                errorDiv.style.display = 'block';
                input.value = ''; // clear selection
                previewUrl(document.getElementById('image_url').value);
                return;
            } else {
                input.classList.remove('is-invalid');
                errorDiv.style.display = 'none';
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewWrapper.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            input.classList.remove('is-invalid');
            errorDiv.style.display = 'none';
            previewUrl(document.getElementById('image_url').value);
        }
    }

    // Initialize if URL exists (from old input)
    if (document.getElementById('image_url').value) {
        previewUrl(document.getElementById('image_url').value);
    }
</script>
@endsection
