@extends('layouts.admin')

@section('title', 'Edit Merchandise')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Edit Item: <span class="text-primary">{{ $merchandise->name }}</span></h1>
        <p class="text-muted small">Update the product catalog item details.</p>
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
                <h5 class="card-title mb-0 text-primary"><i class="fas fa-edit me-2"></i>Update Product Details</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.merchandise.update', $merchandise->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $merchandise->name) }}" required placeholder="e.g. Festival T-Shirt 2026">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="price" class="form-label fw-bold">Retail Price <span class="text-danger">*</span></label>
                            <div class="input-group border rounded p-1 bg-light">
                                <span class="input-group-text bg-transparent border-0 fw-bold">₹</span>
                                <input type="number" step="0.01" class="form-control border-0 bg-transparent fw-bold text-success fs-5 @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $merchandise->price) }}" required>
                            </div>
                            @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="stock" class="form-label fw-bold">Inventory Level <span class="text-danger">*</span></label>
                            <div class="input-group border rounded p-1 bg-light">
                                <span class="input-group-text bg-transparent border-0"><i class="fas fa-warehouse text-muted"></i></span>
                                <input type="number" class="form-control border-0 bg-transparent fw-bold @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $merchandise->stock) }}" required>
                            </div>
                            @error('stock') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label fw-bold">Product Image URL</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="fas fa-link"></i></span>
                            <input type="url" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{ old('image', $merchandise->image) }}" placeholder="https://example.com/product.jpg">
                        </div>
                        <div id="image-preview-container" class="mt-3 text-center bg-light rounded border p-2">
                            <img id="image-preview" src="{{ $merchandise->image ?: 'https://via.placeholder.com/300?text=No+Image' }}" class="img-fluid rounded" style="max-height: 250px;">
                        </div>
                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $merchandise->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr class="my-4 opacity-10">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.merchandise.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm">
                            <i class="fas fa-save me-2"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Sales Stats</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Total Orders</span>
                    <span class="badge bg-soft-info text-info border px-2 py-1">Coming Soon</span>
                </div>
                <div class="d-flex justify-content-between mb-0">
                    <span class="text-muted small">Current Stock</span>
                    <span class="badge {{ $merchandise->stock > 0 ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} border px-2 py-1">
                        {{ $merchandise->stock }} units
                    </span>
                </div>
            </div>
        </div>

        <div class="alert alert-warning border-0 shadow-sm d-flex">
             <i class="fas fa-exclamation-triangle mt-1 me-3 text-warning fs-4"></i>
             <div class="small">
                <strong>Notice:</strong> Changing the price will affect all future orders instantly. Orders already placed will retain the previous price.
             </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); }
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.05); }
    .input-group-text { border-color: #dee2e6; }
</style>

@endsection

@section('scripts')
<script>
    const imageInput = document.getElementById('image');
    const previewImg = document.getElementById('image-preview');

    imageInput.addEventListener('input', function() {
        if (this.value) {
            previewImg.src = this.value;
        } else {
            previewImg.src = 'https://via.placeholder.com/300?text=No+Image';
        }
    });

</script>
@endsection
