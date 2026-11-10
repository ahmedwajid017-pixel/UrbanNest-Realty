@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Property Details</h3>

        <div>
            <a href="{{ route('admin.properties.edit', $property) }}"
               class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>

            <a href="{{ route('admin.properties.index') }}"
               class="btn btn-secondary">
                Back to Properties
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h4>{{ $property->title }}</h4>

            <p><strong>Price:</strong>
                {{ number_format($property->price, 2) }}
            </p>

            <p><strong>Category:</strong>
                {{ $property->category->name ?? 'N/A' }}
            </p>

            <p><strong>Agent:</strong>
                {{ $property->agent->name ?? 'N/A' }}
            </p>

            <p><strong>Location:</strong>
                {{ $property->location }}
            </p>

            <p><strong>Status:</strong>
                {{ ucfirst($property->status) }}
            </p>

            <p><strong>Description:</strong></p>
            <p>{{ $property->description ?? 'No description available.' }}</p>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Property Images</h5>
        </div>

        <div class="card-body">
            <div class="row">

                @forelse($property->images as $image)
                    <div class="col-md-4 mb-3">
                        <img
                            src="{{ asset('storage/' . $image->image_path) }}"
                            alt="Property Image"
                            class="img-fluid rounded shadow-sm"
                            style="height: 220px; width: 100%; object-fit: cover;"
                        >
                    </div>
                @empty
                    <p class="text-muted">No images uploaded for this property.</p>
                @endforelse

            </div>
        </div>
    </div>

</div>
@endsection