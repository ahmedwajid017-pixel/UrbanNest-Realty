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
    public function __construct()
    {
        $this->authorizeResource(Property::class, 'property');
    }

    public function index()
    {
        $user = auth()->user();

        $query = Property::with(['category', 'agent'])->latest();

        // Agents can only see their own properties.
        if ($user->role->name === 'Agent') {
            $query->where('agent_id', $user->agent_id);
        }

        $properties = $query->paginate(10);

        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        $user = auth()->user();

        if ($user->role->name === 'Agent') {
            $agents = Agent::whereKey($user->agent_id)->get();
        } else {
            $agents = Agent::orderBy('name')->get();
        }

        return view('admin.properties.create', compact(
            'categories',
            'agents'
        ));
    }

    public function store(StorePropertyRequest $request)
    {
        $validated = $request->validated();

        $images = $validated['images'] ?? [];
        unset($validated['images']);

        // Never trust an Agent to choose another agent_id.
        if ($request->user()->role->name === 'Agent') {
            $validated['agent_id'] = $request->user()->agent_id;
        }

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

    public function show(Property $property)
    {
        $property->load(['category', 'agent', 'images']);

        return view('admin.properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $categories = Category::orderBy('name')->get();

        $user = auth()->user();

        if ($user->role->name === 'Agent') {
            $agents = Agent::whereKey($user->agent_id)->get();
        } else {
            $agents = Agent::orderBy('name')->get();
        }

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

        // Agents cannot transfer their properties to another agent.
        if ($request->user()->role->name === 'Agent') {
            $validated['agent_id'] = $property->agent_id;
        }

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