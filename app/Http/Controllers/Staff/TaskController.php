<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskUpdate; // Optional model to log status changes/notes
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a list of tasks assigned to the logged-in staff member.
     */
    public function index()
    {
        $user = auth()->user();
        // Maybe include completed tasks for recent history
        $tasks = Task::where('assigned_user_id', $user->id)
                     ->with('washroom.floor.building')
                     ->latest()
                     ->paginate(10); // Paginate for potentially long lists

        return view('staff.tasks.index', compact('tasks'));
    }

    /**
     * Display the details of a specific assigned task.
     */
    public function show(Task $task)
    {
        // --- Authorization: Ensure task belongs to logged-in staff ---
        if ($task->assigned_user_id !== auth()->id()) {
            abort(403);
        }
        $task->load(['washroom.floor.building', 'updates']);
        return view('staff.tasks.show', compact('task'));
    }

    /**
     * Update the status of a task (e.g., start, complete, blocked).
     */
    public function updateStatus(Request $request, Task $task)
    {
        // --- Authorization: Ensure task belongs to logged-in staff ---
         if ($task->assigned_user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403); // Or redirect back with error
        }

        $request->validate([
            'status' => 'required|in:in-progress,completed,blocked', // Define valid statuses staff can set
            'notes' => 'nullable|string|max:1000',
            // Potentially add photo upload validation if needed
        ]);

        $oldStatus = $task->status;
        $newStatus = $request->status;

        // Update task status
        $updateData = ['status' => $newStatus];
        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
             $updateData['completed_at'] = now();
        } elseif ($newStatus === 'in-progress' && $oldStatus === 'pending') {
             $updateData['started_at'] = now(); // Track start time
        }
        $task->update($updateData);

        // --- Optionally log the update with notes/photos ---
        if ($request->filled('notes')) {
            TaskUpdate::create([
                'task_id' => $task->id,
                'user_id' => auth()->id(),
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'notes' => $request->notes,
            ]);
        }

        // --- Update Washroom last_cleaned_at if task type is cleaning and status is completed ---
         if ($newStatus === 'completed' && $task->type === 'Routine Cleaning') { // Adjust task type string
             $task->washroom()->update(['last_cleaned_at' => now()]);
         }

        // Redirect back or return JSON for AJAX requests
        return redirect()->route('staff.tasks.show', $task)->with('success', 'Task status updated.');
    }
}