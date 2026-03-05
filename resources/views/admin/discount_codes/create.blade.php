@extends('layouts.admin')

@section('title', 'Create Discount Code')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2 mb-0">Create Coupon</h1>
        <p class="text-muted small">Generate a new promotional code for your customers.</p>
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
                <h5 class="card-title mb-0 text-primary"><i class="fas fa-percent me-2"></i>Coupon Configuration</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.discount-codes.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4 text-center">
                        <label for="code" class="form-label fw-bold d-block">Coupon Code <span class="text-danger">*</span></label>
                        <div class="input-group input-group-lg justify-content-center">
                            <input type="text" class="form-control text-center font-monospace fw-bold @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required placeholder="FESTIVAL50" style="text-transform: uppercase; letter-spacing: 2px; max-width: 400px; border-radius: 12px;">
                        </div>
                        <div class="form-text small mt-2">Example: FESTIVAL50, WELCOME2026</div>
                        @error('code') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="percentage" class="form-label fw-bold">Discount (%) <span class="text-danger">*</span></label>
                            <div class="input-group border rounded p-1 bg-light">
                                <input type="number" min="0" max="100" class="form-control border-0 bg-transparent fw-bold text-center fs-4 @error('percentage') is-invalid @enderror" id="percentage" name="percentage" value="{{ old('percentage') }}" required placeholder="0">
                                <span class="input-group-text bg-transparent border-0 fs-4">%</span>
                            </div>
                            @error('percentage') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="expires_at" class="form-label fw-bold">Expiry Date</label>
                            <div class="input-group border rounded p-1 bg-light">
                                <span class="input-group-text bg-transparent border-0"><i class="far fa-calendar-alt text-muted"></i></span>
                                <input type="date" class="form-control border-0 bg-transparent @error('expires_at') is-invalid @enderror" id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                            </div>
                            @error('expires_at') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="card bg-light border-0 mb-4 p-3 border-start border-4 border-info">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input ms-0 me-3" type="checkbox" name="single_use" value="1" id="single_use" {{ old('single_use') ? 'checked' : '' }} style="width: 2.5em; height: 1.25em;">
                            <label class="form-check-label fw-bold" for="single_use">Single Use Security?</label>
                            <p class="small text-muted mb-0 mt-1">If enabled, each registered user can only apply this code to one successful order.</p>
                        </div>
                    </div>

                    <hr class="my-4 opacity-10">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.discount-codes.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                            <i class="fas fa-save me-2"></i> Create Coupon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-dark text-white mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="fas fa-shield-alt text-info me-2"></i>Campaign Security</h6>
                <p class="small mb-3 opacity-75">Coupons are instantly active upon creation. You can revoke them at any time from the management list.</p>
                <div class="alert alert-info py-2 px-3 border-0 bg-secondary bg-opacity-25 small mb-0 d-flex align-items-center">
                    <i class="fas fa-info-circle me-2"></i>
                    <span>Codes are case-insensitive.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus { box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05); }
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
