
@extends('layouts.admin')

@section('title', 'Add Property')
@section('page-heading', 'Add New Property')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="fw-bold">Add New Property</h4>
        <p class="text-muted">Enter property information and upload images.</p>
    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form action="{{ route('admin.properties.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row g-3">

                    <!-- Property Title -->
                    <div class="col-md-6">
                        <label class="form-label">Property Title</label>

                        <input type="text"
                               name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}"
                               placeholder="Enter property title">

                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="col-md-6">
                        <label class="form-label">Price</label>

                        <input type="number"
                               name="price"
                               step="0.01"
                               min="0"
                               class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price') }}"
                               placeholder="Enter property price">

                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label class="form-label">Category</label>

                        <select name="category_id"
                                class="form-select @error('category_id') is-invalid @enderror">

                            <option value="">Select Category</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>

                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Agent -->
                    <div class="col-md-6">
                        <label class="form-label">Agent</label>

                        <select name="agent_id"
                                class="form-select @error('agent_id') is-invalid @enderror">

                            <option value="">Select Agent</option>

                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}"
                                    {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->name }}
                                </option>
                            @endforeach

                        </select>

                        @error('agent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="col-md-12">
                        <label class="form-label">Location</label>

                        <input type="text"
                               name="location"
                               class="form-control @error('location') is-invalid @enderror"
                               value="{{ old('location') }}"
                               placeholder="Enter property location">

                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <label class="form-label">Description</label>

                        <textarea name="description"
                                  rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Enter property description">{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label">Status</label>

                        <select name="status"
                                class="form-select @error('status') is-invalid @enderror">

                            <option value="available"
                                {{ old('status', 'available') == 'available' ? 'selected' : '' }}>
                                Available
                            </option>

                            <option value="sold"
                                {{ old('status') == 'sold' ? 'selected' : '' }}>
                                Sold
                            </option>

                            <option value="rented"
                                {{ old('status') == 'rented' ? 'selected' : '' }}>
                                Rented
                            </option>

                        </select>

                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Images -->
                    <div class="col-md-6">
                        <label class="form-label">Property Images</label>

                        <input type="file"
                               name="images[]"
                               multiple
                               accept="image/jpeg,image/png,image/webp"
                               class="form-control @error('images') is-invalid @enderror">

                        <small class="text-muted">
                            JPG, PNG or WEBP. Maximum 5 MB per image, up to 10 images.
                        </small>

                        @error('images')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror

                        @error('images.*')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <!-- Buttons -->
                <div class="mt-4 d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>
                        Save Property
                    </button>

                    <a href="{{ route('admin.properties.index') }}"
                       class="btn btn-outline-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection
