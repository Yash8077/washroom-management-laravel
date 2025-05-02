<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\Washroom;
use Illuminate\Http\Request;
// Add FormRequests for validation

class IssueController extends Controller
{
    /**
     * Display a list of issues reported by the logged-in staff member.
     */
    public function index()
    {
        $issues = Issue::where('reported_by_user_id', auth()->id())
                       ->with('washroom.floor.building')
                       ->latest()
                       ->paginate(10);
        return view('staff.issues.index', compact('issues'));
    }

    /**
     * Show the form for reporting a new issue.
     */
    public function create()
    {
        // Get locations staff might be working in, or all locations
        $washrooms = Washroom::orderBy('identifier')->get();
        return view('staff.issues.create', compact('washrooms'));
    }

    /**
     * Store a newly reported issue.
     */
    public function store(Request $request) // Use FormRequest
    {
        // --- Validation ---
         $validated = $request->validate([
            'washroom_id' => 'required|exists:washrooms,id',
            'issue_type' => 'required|string|max:255', // Maybe use predefined types
            'description' => 'nullable|string|max:1000',
            // Add photo upload validation if needed
        ]);

        Issue::create([
            'washroom_id' => $validated['washroom_id'],
            'reported_by_user_id' => auth()->id(),
            'issue_type' => $validated['issue_type'],
            'description' => $validated['description'],
            'status' => 'reported', // Initial status
            'reported_at' => now(),
            // Handle photo storage if applicable
        ]);

        // --- Notify Admin ---

        return redirect()->route('staff.dashboard')->with('success', 'Issue reported successfully.');
    }
}