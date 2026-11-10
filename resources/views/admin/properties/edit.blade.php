
@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4">Edit Property</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.properties.update', $property) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Property Title</label>
                    <input type="text" name="title"
                           class="form-control"
                           value="{{ old('title', $property->title) }}" required>
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" name="price"
                           class="form-control" step="0.01"
                           value="{{ old('price', $property->price) }}" required>
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $property->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Agent</label>
                    <select name="agent_id" class="form-select" required>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}"
                                {{ old('agent_id', $property->agent_id) == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location"
                           class="form-control"
                           value="{{ old('location', $property->location) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $property->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        @foreach(['available', 'sold', 'rented'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $property->status) == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Existing Images</label>

                    <div class="row">
                        @forelse($property->images as $image)
                            <div class="col-md-3 mb-3">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                     class="img-fluid rounded"
                                     style="height: 140px; width: 100%; object-fit: cover;"
                                     alt="Property Image">
                            </div>
                        @empty
                            <p class="text-muted">No images uploaded.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Additional Images</label>
                    <input type="file" name="images[]" class="form-control"
                           accept="image/jpeg,image/png,image/webp" multiple>
                    <small class="text-muted">You can upload up to 10 images per request. Maximum 5 MB each.</small>
                    @error('images')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Update Property
                </button>

                <a href="{{ route('admin.properties.index') }}"
                   class="btn btn-secondary">Cancel</a>

            </form>

        </div>
    </div>

</div>
@endsection
