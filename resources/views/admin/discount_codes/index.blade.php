@extends('layouts.admin')

@section('title', 'Discount Codes')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Discount Codes</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.discount-codes.create') }}" class="btn btn-sm btn-primary px-3 rounded-pill shadow-sm">
            <i class="fas fa-plus me-1"></i> Add New Code
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3">Coupon Code</th>
                        <th class="py-3">Discount Value</th>
                        <th class="py-3">Status / Expiry</th>
                        <th class="py-3 text-center">Usage Limit</th>
                        <th class="text-end pe-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($discountCodes as $code)
                    @php
                        $isExpired = $code->expires_at && \Carbon\Carbon::parse($code->expires_at)->isPast();
                    @endphp
                    <tr class="align-middle">
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-soft-primary text-primary px-3 py-2 rounded fw-bold border border-primary border-opacity-10 me-3 font-monospace">
                                    {{ $code->code }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fs-5 fw-bold text-success">{{ $code->percentage }}%</span>
                            <small class="text-muted d-block mt-n1">Off Total</small>
                        </td>
                        <td>
                            @if($code->expires_at)
                                <div class="d-flex align-items-center {{ $isExpired ? 'text-danger' : 'text-dark' }} small">
                                    <i class="far {{ $isExpired ? 'fa-calendar-times' : 'fa-calendar-check' }} me-2"></i>
                                    <span>{{ \Carbon\Carbon::parse($code->expires_at)->format('M d, Y') }}</span>
                                    @if($isExpired)
                                        <span class="badge bg-danger ms-2 small">EXPIRED</span>
                                    @endif
                                </div>
                            @else
                                <span class="badge bg-soft-secondary text-secondary border px-2 py-1 fw-normal">NEVER EXPIRES</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($code->single_use)
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">
                                    <i class="fas fa-lock me-1 opacity-50 small"></i> SINGLE USE
                                </span>
                            @else
                                <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-bold">
                                    <i class="fas fa-redo me-1 opacity-50 small"></i> MULTI USE
                                </span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.discount-codes.edit', $code->id) }}" class="btn btn-outline-primary border-0 bg-light-hover" title="Edit Policy">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.discount-codes.destroy', $code->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Invalidate this discount code?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger border-0 bg-light-hover" title="Revoke access">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-percent display-4 text-muted opacity-25 mb-3 d-block"></i>
                            <p class="text-muted mb-0">No active discount policies found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.08); }
    .bg-soft-secondary { background-color: rgba(108, 117, 125, 0.05); }
    .bg-light-hover:hover { background-color: rgba(0,0,0,0.05) !important; }
</style>
@endsection
