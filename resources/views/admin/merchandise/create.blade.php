@extends('layouts.admin')

@section('title', 'Create Merchandise')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Add Merchandise</h1>
        <p class="text-muted small">List a new product in your official merchandise store.</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.merchandise.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to Catalog
        </a>
    </div>
</div>

<div class="row justify-content-center mt-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="card-title mb-0 text-primary"><i class="fas fa-box-open me-2"></i>Product Information</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.merchandise.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Festival T-Shirt 2026">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-bold">Retail Price <span class="text-danger">*</span></label>
                            <div class="input-group border rounded p-1 bg-light">
                                <span class="input-group-text bg-transparent border-0 fw-bold">₹</span>
                                <input type="number" step="0.01" class="form-control border-0 bg-transparent fw-bold text-success fs-5 @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required placeholder="0.00">
                            </div>
                            @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="stock" class="form-label fw-bold">Initial Inventory <span class="text-danger">*</span></label>
                            <div class="input-group border rounded p-1 bg-light">
                                <span class="input-group-text bg-transparent border-0"><i class="fas fa-warehouse text-muted"></i></span>
                                <input type="number" class="form-control border-0 bg-transparent fw-bold @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}" required placeholder="100">
                            </div>
                            @error('stock') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label fw-bold">Product Image URL</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="fas fa-link"></i></span>
                            <input type="url" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{ old('image') }}" placeholder="https://example.com/product.jpg">
                        </div>
                        <div id="image-preview-container" class="mt-3 text-center bg-light rounded border p-2" style="display: none;">
                            <img id="image-preview" src="" class="img-fluid rounded" style="max-height: 250px;">
                        </div>
                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Highlight key features, material, sizes, etc.">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr class="my-4 opacity-10">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.merchandise.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                            <i class="fas fa-save me-2"></i> Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-primary text-white mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="fas fa-info-circle me-2"></i>Inventory Tip</h6>
                <p class="small mb-0 opacity-75">Keep your stock levels updated. Customers will see "Out of Stock" labels and purchase buttons will be disabled automatically when inventory hits zero.</p>
            </div>
        </div>

        <div class="alert alert-info border-0 shadow-sm">
            <h6 class="fw-bold"><i class="fas fa-shopping-cart me-2"></i>Store Integration</h6>
            <p class="small mb-0">This item will be featured in the "Official Merchandise" section on the main dashboard for all users.</p>
        </div>
    </div>
</div>

<style>
    .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05); }
    .input-group-text { border-color: #dee2e6; }
</style>

@endsection

@section('scripts')
<script>
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('image-preview-container');
    const previewImg = document.getElementById('image-preview');

    imageInput.addEventListener('input', function() {
        if (this.value) {
            previewImg.src = this.value;
            previewContainer.style.display = 'block';
        } else {
            previewContainer.style.display = 'none';
        }
    });

    if (imageInput.value) {
        previewImg.src = imageInput.value;
        previewContainer.style.display = 'block';
    }
</script>
@endsection
