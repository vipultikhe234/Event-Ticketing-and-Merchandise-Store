@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Categories</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary px-3 rounded-pill shadow-sm">
            <i class="fas fa-plus me-1"></i> Add New Category
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3">ID</th>
                        <th class="py-3">Name</th>
                        <th class="py-3">Slug</th>
                        <th class="py-3">Description</th>
                        <th class="text-end pe-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="align-middle">
                        <td class="ps-4 text-muted small">#{{ $category->id }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $category->name }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fw-normal px-2 py-1">
                                <i class="fas fa-link me-1 opacity-50 small"></i> {{ $category->slug }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ Str::limit($category->description, 60) ?: 'No description' }}</td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-outline-primary border-0 bg-light-hover" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger border-0 bg-light-hover" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-tags display-4 text-muted opacity-25 mb-3 d-block"></i>
                            <p class="text-muted mb-0">No categories found in the system.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-light-hover:hover { background-color: rgba(0,0,0,0.05) !important; }
</style>
@endsection
