<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Building; // Assuming separate models or a unified approach
use App\Models\Floor;
use App\Models\Washroom;
// Add FormRequests for validation

class LocationController extends Controller
{
    /**
     * Display a listing of locations (buildings, floors, washrooms).
     * Could be combined or separated views.
     */
    public function index()
    {
        $buildings = Building::with('floors.washrooms')->orderBy('name')->get();
        // Or fetch Washrooms directly with relationships
        $washrooms = Washroom::with('floor.building')->orderBy('identifier')->paginate(15);

        return view('admin.locations.index', compact('buildings', 'washrooms'));
    }

    /**
     * Show the form for creating a new resource (e.g., a washroom).
     * May need separate methods/routes for buildings/floors.
     */
    public function create()
    {
         $floors = Floor::orderBy('name')->get(); // Needed for creating washrooms
         return view('admin.locations.washrooms.create', compact('floors'));
         // Add create methods/views for Buildings and Floors as needed
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // Replace Request with specific FormRequest
    {
        // --- Validation logic here (use FormRequest) ---
        // --- Logic to create Building/Floor/Washroom ---
        // Example for Washroom:
        // Washroom::create($request->validated());

        // Redirect with success message
        return redirect()->route('admin.locations.index')->with('success', 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Washroom $washroom) // Or Building $building, Floor $floor
    {
        // Load necessary relationships if needed
        $washroom->load(['floor.building', 'tasks', 'issues']);
        return view('admin.locations.washrooms.show', compact('washroom'));
         // Add show methods/views for Buildings and Floors as needed
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Washroom $washroom) // Or Building $building, Floor $floor
    {
         $floors = Floor::orderBy('name')->get(); // Needed for editing washrooms
         return view('admin.locations.washrooms.edit', compact('washroom', 'floors'));
         // Add edit methods/views for Buildings and Floors as needed
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Washroom $washroom) // Replace Request, use specific model
    {
        // --- Validation logic here (use FormRequest) ---
        // --- Logic to update Building/Floor/Washroom ---
        // Example for Washroom:
        // $washroom->update($request->validated());

        // Redirect with success message
        return redirect()->route('admin.locations.index')->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Washroom $washroom) // Or Building $building, Floor $floor
    {
        // --- Authorization check ---
        // --- Logic to delete (check for dependencies first!) ---
        // Example for Washroom:
        // if ($washroom->tasks()->exists() || $washroom->issues()->exists()) {
        //     return back()->with('error', 'Cannot delete location with active tasks or issues.');
        // }
        // $washroom->delete();

        // Redirect with success message
        return redirect()->route('admin.locations.index')->with('success', 'Location deleted successfully.');
    }
}