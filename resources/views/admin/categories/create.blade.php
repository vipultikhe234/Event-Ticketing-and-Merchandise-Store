@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Create New Category</h1>
        <p class="text-muted small">Define a new classification for your events and performers.</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="row justify-content-center mt-4">
    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="card-title mb-0 text-primary"><i class="fas fa-tag me-2"></i>Category Information</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-heading text-muted"></i></span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror border-start-0" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Music Festival" required autofocus>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="slug" class="form-label fw-bold">Slug / URL <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted small">/category/</span>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror border-start-0 font-monospace" id="slug" name="slug" value="{{ old('slug') }}" placeholder="music-festival" required>
                        </div>
                        <div class="form-text small"><i class="fas fa-info-circle me-1"></i> Unique URL identifier. Usually auto-generated.</div>
                        @error('slug')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Briefly describe what this category includes...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4 opacity-10">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                            <i class="fas fa-save me-2"></i> Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Quick Help / Information Sidebar -->
    <div class="col-md-4">
        <div class="card bg-light border-0 shadow-none mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fas fa-lightbulb text-warning me-2"></i>Quick Tips</h6>
                <ul class="small text-muted ps-3 mb-0">
                    <li class="mb-2">Choose a concise, descriptive name.</li>
                    <li class="mb-2">The <strong>Slug</strong> is used in the website URL. Avoid special characters.</li>
                    <li>Descriptions help users understand what types of events they'll find.</li>
                </ul>
            </div>
        </div>
        
        <div class="alert alert-info border-0 bg-soft-info p-3 mb-0">
            <div class="d-flex">
                <i class="fas fa-shield-alt mt-1 me-3 fs-5"></i>
                <div>
                    <h6 class="alert-heading fw-bold mb-1">Administrative Action</h6>
                    <p class="small mb-0 opacity-75">This action will create a new category that will be immediately available across the site.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); color: #087990; }
    .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05); }
    .input-group-text { border-color: #dee2e6; }
</style>
@endsection

@section('scripts')
<script>
    document.getElementById('name').addEventListener('input', function() {
        const name = this.value;
        const slugField = document.getElementById('slug');
        if (!slugField.dataset.userEdited) {
            slugField.value = name.toLowerCase()
                .trim()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
        }
    });

    document.getElementById('slug').addEventListener('input', function() {
        this.dataset.userEdited = true;
    });
</script>
@endsection
