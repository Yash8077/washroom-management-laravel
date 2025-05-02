<?php

namespace App\Http\Controllers;

use App\Models\Washroom;
use Illuminate\Http\Request;

class WashroomStatusController extends Controller
{
    /**
     * Display a public or general user view of washroom statuses.
     * Might require authentication depending on requirements.
     */
    public function index(Request $request)
    {
        // --- Add filtering (e.g., by building, floor) ---
         $query = Washroom::with('floor.building'); // Eager load relationships

        // Example filter by building
        if ($request->filled('building_id')) {
            $query->whereHas('floor.building', function ($q) use ($request) {
                $q->where('id', $request->building_id);
            });
        }

        $washrooms = $query->orderBy('identifier')->get();

        // Fetch Buildings/Floors for filtering UI
        // $buildings = Building::orderBy('name')->get();

        return view('washrooms.status', compact('washrooms' /*, 'buildings' */));
    }

    /**
     * Display details for a specific washroom (potentially public view).
     */
    public function show(Washroom $washroom)
    {
        $washroom->load(['floor.building', 'issues' => function ($query) {
            // Only show open issues maybe?
            $query->whereIn('status', ['reported', 'acknowledged', 'in-progress'])->latest();
        }]);

        return view('washrooms.show-public', compact('washroom')); // Specific public view
    }

    // Potentially add an API endpoint for fetching status via JS/Sensors
    public function apiGetStatus()
    {
        $statuses = Washroom::select('id', 'identifier', 'current_status', 'occupancy_status', 'supply_status', 'last_cleaned_at')
                            ->get()
                            ->keyBy('identifier'); // Or format as needed
        return response()->json($statuses);
    }
}