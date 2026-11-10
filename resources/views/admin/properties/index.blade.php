
@extends('layouts.admin')

@section('title', 'Properties')
@section('page-heading', 'Properties Management')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">Properties</h4>
            <p class="text-muted mb-0">
                Manage all property listings.
            </p>
        </div>

        <a href="{{ route('admin.properties.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Add Property
        </a>

    </div>

    <!-- Properties Table -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-semibold">All Properties</h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Property Title</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($properties as $property)

                            <tr>
                                <td>{{ $properties->firstItem() + $loop->index }}</td>

                                <td class="fw-semibold">
                                    {{ $property->title }}
                                </td>

                                <td>{{ $property->location }}</td>

                                <td>
                                    {{ number_format($property->price, 2) }}
                                </td>

                                <td>
                                    @if($property->status === 'available')
                                        <span class="badge bg-success">
                                            Available
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($property->status) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end">

                                    <a href="{{ route('admin.properties.show', $property) }}"
                                       class="btn btn-sm btn-outline-info"
                                       title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.properties.edit', $property) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.properties.destroy', $property) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this property?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center py-5">

                                    <i class="bi bi-house-x fs-1 text-secondary"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        No properties found.
                                    </p>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $properties->links() }}
            </div>

        </div>
    </div>

</div>

@endsection
