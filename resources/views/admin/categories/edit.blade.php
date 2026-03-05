@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Edit Category: <span class="text-primary">{{ $category->name }}</span></h1>
        <p class="text-muted small">Update the classification details for your events and performers.</p>
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
                <h5 class="card-title mb-0 text-primary"><i class="fas fa-edit me-2"></i>Update Category Details</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-heading text-muted"></i></span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror border-start-0" id="name" name="name" value="{{ old('name', $category->name) }}" placeholder="e.g. Music Festival" required autofocus>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="slug" class="form-label fw-bold">Slug / URL <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted small">/category/</span>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror border-start-0 font-monospace" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="music-festival" required>
                        </div>
                        <div class="form-text small"><i class="fas fa-info-circle me-1"></i> Unique URL identifier.</div>
                        @error('slug')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Briefly describe what this category includes...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4 opacity-10">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm">
                            <i class="fas fa-save me-2"></i> Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Stats / Overview Sidebar -->
    <div class="col-md-4">
        <div class="card bg-light border-0 shadow-none mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="fas fa-chart-line text-info me-2"></i>Usage Stats</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Total Events</span>
                    <span class="badge bg-primary rounded-pill">{{ $category->events()->count() }}</span>
                </div>
                <div class="d-flex justify-content-between mb-0">
                    <span class="text-muted small">Total Performers</span>
                    <span class="badge bg-secondary rounded-pill">{{ $category->performers()->count() }}</span>
                </div>
            </div>
        </div>

        <div class="alert alert-warning border-0 bg-soft-warning p-3 mb-0">
            <div class="d-flex">
                <i class="fas fa-exclamation-triangle mt-1 me-3 fs-5 text-warning"></i>
                <div>
                    <h6 class="alert-heading fw-bold mb-1">Impact Analysis</h6>
                    <p class="small mb-0 opacity-75">Changing the <strong>Slug</strong> might break old links indexed by search engines. Proceed with caution.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); color: #856404; }
    .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.05); }
    .input-group-text { border-color: #dee2e6; }
</style>
@endsection
