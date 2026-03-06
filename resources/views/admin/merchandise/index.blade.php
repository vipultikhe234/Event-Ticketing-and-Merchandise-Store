@extends('layouts.admin')

@section('title', 'Merchandise')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Merchandise</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.merchandise.create') }}" class="btn btn-sm btn-primary px-3 rounded-pill shadow-sm">
            <i class="fas fa-plus me-1"></i> Add New Item
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3">Product</th>
                        <th class="py-3">Price</th>
                        <th class="py-3">Stock Inventory</th>
                        <th class="py-3">Description</th>
                        <th class="text-end pe-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($merchandises as $item)
                    <tr class="align-middle">
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                @if($item->image)
                                    <img src="{{ $item->image }}" alt="{{ $item->name }}" class="rounded shadow-sm me-3 border" width="50" height="50" style="object-fit: cover; background: #f8f9fa;">
                                @else
                                    <div class="rounded bg-light border d-flex align-items-center justify-content-center text-muted me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                @endif
                                <div>
                                    <span class="fw-bold d-block text-dark">{{ $item->name }}</span>
                                    <small class="text-muted">ID: #{{ $item->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold text-success">₹{{ number_format($item->price, 2) }}</td>
                        <td>
                            @if($item->stock > 10)
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-soft-success text-success border border-success border-opacity-10 px-2 py-1 me-2">IN STOCK</span>
                                    <span class="fw-bold small">{{ $item->stock }}</span>
                                </div>
                            @elseif($item->stock > 0)
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-soft-warning text-warning border border-warning border-opacity-10 px-2 py-1 me-2">LOW STOCK</span>
                                    <span class="fw-bold small">{{ $item->stock }}</span>
                                </div>
                            @else
                                <span class="badge bg-soft-danger text-danger border border-danger border-opacity-10 px-2 py-1">SOLD OUT</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ Str::limit($item->description, 60) ?: 'No description' }}</td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.merchandise.edit', $item->id) }}" class="btn btn-outline-primary border-0 bg-light-hover" title="Edit Item">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.merchandise.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger border-0 bg-light-hover" title="Delete product">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-box-open display-4 text-muted opacity-25 mb-3 d-block"></i>
                            <p class="text-muted mb-0">No merchandise found in the catalog.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); }
    .bg-light-hover:hover { background-color: rgba(0,0,0,0.05) !important; }
</style>
@endsection
