<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\Task; // To potentially create linked tasks
use Illuminate\Http\Request;
// Add FormRequests for validation

class IssueController extends Controller
{
    /**
     * Display a listing of reported issues.
     */
    public function index(Request $request)
    {
        // --- Add filtering/sorting logic ---
        $query = Issue::with(['washroom.floor.building', 'reportedByUser', 'resolvedByUser']);

        // Example filter:
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // Add more filters (type, location etc.)

        $issues = $query->latest()->paginate(15);
        return view('admin.issues.index', compact('issues'));
    }

    // Admin might not create issues directly, but rather manage reported ones
    // public function create() { ... }
    // public function store() { ... }

    /**
     * Display the specified issue.
     */
    public function show(Issue $issue)
    {
         $issue->load(['washroom.floor.building', 'reportedByUser', 'resolvedByUser', 'linkedTask']); // Assuming relationship to Task
         return view('admin.issues.show', compact('issue'));
    }

    /**
     * Show the form for editing/managing the specified issue.
     * (e.g., change status, link to task)
     */
    public function edit(Issue $issue)
    {
        // Get tasks that could be linked, or staff to assign resolution
        return view('admin.issues.edit', compact('issue'));
    }

    /**
     * Update the specified issue in storage.
     * (e.g., acknowledge, mark resolved, link task)
     */
    public function update(Request $request, Issue $issue) // Use FormRequest
    {
        // --- Validation ---
        $validated = $request->validate([
            'status' => 'required|in:reported,acknowledged,in_progress,resolved,rejected',
            'resolution_notes' => 'nullable|string',
            // Potentially field to link to an existing task_id
        ]);

        // Handle status change logic
        if ($validated['status'] === 'resolved' && $issue->status !== 'resolved') {
            $validated['resolved_at'] = now();
            $validated['resolved_by_user_id'] = auth()->id();
        }

        $issue->update($validated);

        // --- Optionally create/update a linked task ---

        return redirect()->route('admin.issues.index')->with('success', 'Issue updated successfully.');
    }

    /**
     * Remove the specified issue from storage.
     */
    public function destroy(Issue $issue)
    {
        // --- Authorization check ---
        // Consider soft deletes or archiving
        $issue->delete();
        return redirect()->route('admin.issues.index')->with('success', 'Issue deleted successfully.');
    }