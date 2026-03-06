@extends('layouts.admin')

@section('title', 'Edit Discount Code')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Edit Coupon: <span class="text-primary font-monospace">{{ $discountCode->code }}</span></h1>
        <p class="text-muted small">Update the promotional code rules and settings.</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.discount-codes.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="row justify-content-center mt-4">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="card-title mb-0 text-primary"><i class="fas fa-edit me-2"></i>Coupon Configuration</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.discount-codes.update', $discountCode->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4 text-center">
                        <label for="code" class="form-label fw-bold d-block">Coupon Code <span class="text-danger">*</span></label>
                        <div class="input-group input-group-lg justify-content-center">
                            <input type="text" class="form-control text-center font-monospace fw-bold @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $discountCode->code) }}" required style="text-transform: uppercase; letter-spacing: 2px; max-width: 400px; border-radius: 12px;">
                        </div>
                        <div class="form-text small mt-2">Example: FESTIVAL50, WELCOME2026</div>
                        @error('code') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="percentage" class="form-label fw-bold">Discount (%) <span class="text-danger">*</span></label>
                            <div class="input-group border rounded p-1 bg-light">
                                <input type="number" min="0" max="100" class="form-control border-0 bg-transparent fw-bold text-center text-success fs-4 @error('percentage') is-invalid @enderror" id="percentage" name="percentage" value="{{ old('percentage', $discountCode->percentage) }}" required>
                                <span class="input-group-text bg-transparent border-0 fs-4">%</span>
                            </div>
                            @error('percentage') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="expires_at" class="form-label fw-bold">Expiry Date</label>
                            <div class="input-group border rounded p-1 bg-light">
                                <span class="input-group-text bg-transparent border-0"><i class="far fa-calendar-alt text-muted"></i></span>
                                <input type="date" class="form-control border-0 bg-transparent @error('expires_at') is-invalid @enderror" id="expires_at" name="expires_at" value="{{ old('expires_at', $discountCode->expires_at ? \Carbon\Carbon::parse($discountCode->expires_at)->format('Y-m-d') : '') }}">
                            </div>
                            @error('expires_at') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="card bg-light border-0 mb-4 p-3 border-start border-4 border-info">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input ms-0 me-3" type="checkbox" name="single_use" value="1" id="single_use" {{ old('single_use', $discountCode->single_use) ? 'checked' : '' }} style="width: 2.5em; height: 1.25em;">
                            <label class="form-check-label fw-bold" for="single_use">Single Use Security?</label>
                            <p class="small text-muted mb-0 mt-1">If enabled, each registered user can only apply this code to one successful order.</p>
                        </div>
                    </div>

                    <hr class="my-4 opacity-10">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.discount-codes.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm">
                            <i class="fas fa-save me-2"></i> Update Coupon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Usage Statistics</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Used Count</span>
                    <span class="badge bg-soft-primary text-primary px-2 py-1 rounded-pill">{{ $discountCode->orders()->where('status', 'completed')->count() }} orders</span>
                </div>
                <div class="d-flex justify-content-between mb-0">
                    <span class="text-muted small">Status</span>
                    @if($discountCode->expires_at && \Carbon\Carbon::parse($discountCode->expires_at)->isPast())
                        <span class="badge bg-danger">Expired</span>
                    @else
                        <span class="badge bg-success">Active</span>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="alert alert-warning border-0 shadow-sm">
            <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Live Updates</h6>
            <p class="small mb-0">Changes take effect immediately. Anyone currently checking out with this code might be affected depending on the changes made.</p>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.05); }
    .input-group-text { border-color: transparent; }
</style>

@endsection

@section('scripts')
<script>
    document.getElementById('code').addEventListener('input', function() {
        this.value = this.value.toUpperCase().replace(/\s/g, '');
    });
</script>
@endsection
