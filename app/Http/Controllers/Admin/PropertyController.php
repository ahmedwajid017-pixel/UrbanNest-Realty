<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Models\Property;
use App\Models\Category;
use App\Models\Agent;
use Illuminate\Support\Facades\Storage;


class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
public function index()
{
    $properties = \App\Models\Property::latest()->paginate(10);

    return view('admin.properties.index', compact('properties'));
}


    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    $categories = Category::orderBy('name')->get();
    $agents = Agent::orderBy('name')->get();

    return view('admin.properties.create', compact(
        'categories',
        'agents'
    ));
}

    /**
     * Store a newly created resource in storage.
     */
  public function store(StorePropertyRequest $request)
{
    $validated = $request->validated();

    $images = $validated['images'] ?? [];

    unset($validated['images']);

    $property = Property::create($validated);

    foreach ($images as $image) {
        $path = $image->store('properties', 'public');

        $property->images()->create([
            'image_path' => $path,
        ]);
    }

    return redirect()
        ->route('admin.properties.show', $property)
        ->with('success', 'Property created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
{
    $property->load(['category', 'agent', 'images']);

    return view('admin.properties.show', compact('property'));
}

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Property $property)
{
    $categories = Category::orderBy('name')->get();
    $agents = Agent::orderBy('name')->get();

    $property->load('images');

    return view('admin.properties.edit', compact(
        'property',
        'categories',
        'agents'
    ));
}

public function update(StorePropertyRequest $request, Property $property)
{
    $validated = $request->validated();

    $images = $validated['images'] ?? [];

    unset($validated['images']);

    $property->update($validated);

    foreach ($images as $image) {
        $path = $image->store('properties', 'public');

        $property->images()->create([
            'image_path' => $path,
        ]);
    }

    return redirect()
        ->route('admin.properties.show', $property)
        ->with('success', 'Property updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Property $property)
{
    foreach ($property->images as $image) {
        Storage::disk('public')->delete($image->image_path);
    }

    $property->delete();

    return redirect()
        ->route('admin.properties.index')
        ->with('success', 'Property deleted successfully.');
}
}
