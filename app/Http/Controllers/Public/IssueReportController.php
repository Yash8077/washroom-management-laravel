<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\Washroom;
use Illuminate\Http\Request;
// Add FormRequests for validation

class IssueReportController extends Controller
{
    /**
     * Show the public form for reporting an issue.
     * May receive location identifier via query param (e.g., from QR code).
     */
    public function create(Request $request)
    {
        $washroomId = $request->query('washroom_id');
        $washroom = $washroomId ? Washroom::find($washroomId) : null;

        $washrooms = Washroom::orderBy('identifier')->get(); // Fallback dropdown if no specific washroom

        return view('public.report-issue', compact('washrooms', 'washroom'));
    }

    /**
     * Store a newly reported issue from a public user.
     */
    public function store(Request $request) // Use FormRequest
    {
        // --- Validation ---
        $validated = $request->validate([
            'washroom_id' => 'required|exists:washrooms,id',
            'issue_type' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
             // Optionally capture reporter info if needed/allowed (e.g., optional email)
            // Add Captcha validation if needed
        ]);

        Issue::create([
            'washroom_id' => $validated['washroom_id'],
            'reported_by_user_id' => null, // Indicate public report
            'reporter_info' => $request->input('reporter_email'), // Example optional field
            'issue_type' => $validated['issue_type'],
            'description' => $validated['description'],
            'status' => 'reported',
            'reported_at' => now(),
        ]);

         // --- Notify Admin ---

        return back()->with('success', 'Thank you! Your issue has been reported.'); // Redirect back to form page
    }
}