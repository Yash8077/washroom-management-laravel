<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Washroom;
use App\Models\User;
use Illuminate\Http\Request;
// Add FormRequests for validation

class TaskController extends Controller
{
    /**
     * Display a listing of all tasks.
     */
    public function index(Request $request)
    {
        // --- Add filtering/sorting logic based on request parameters ---
        $query = Task::with(['washroom.floor.building', 'assignedUser', 'createdByUser']);

        // Example filter:
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // Add more filters (priority, assignee, location etc.)

        $tasks = $query->latest()->paginate(15);
        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $washrooms = Washroom::orderBy('identifier')->get();
        $staffUsers = User::where('role', 'staff')->orderBy('name')->get(); // Adjust role logic
        return view('admin.tasks.create', compact('washrooms', 'staffUsers'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request) // Use FormRequest
    {
        // --- Validation (use FormRequest) ---
        $validated = $request->validate([ /* rules */ ]);
        $validated['created_by_user_id'] = auth()->id();
        $validated['status'] = $validated['assigned_user_id'] ? 'pending' : 'unassigned';

        Task::create($validated);

        // --- Optionally send notification to assigned staff ---

        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        $task->load(['washroom.floor.building', 'assignedUser', 'createdByUser', 'updates']); // Assuming TaskUpdate model exists
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $washrooms = Washroom::orderBy('identifier')->get();
        $staffUsers = User::where('role', 'staff')->orderBy('name')->get(); // Adjust role logic
        return view('admin.tasks.edit', compact('task', 'washrooms', 'staffUsers'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task) // Use FormRequest
    {
        // --- Validation (use FormRequest) ---
        $validated = $request->validate([ /* rules */ ]);

        // Handle status change logic if assignment changes
        if ($task->assigned_user_id != $validated['assigned_user_id']) {
           $validated['status'] = $validated['assigned_user_id'] ? 'pending' : 'unassigned';
           // Potentially log the reassignment or notify users
        }

        $task->update($validated);

        return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        // --- Authorization check ---
        // Consider if tasks should be soft-deleted or archived instead
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully.');
    }
}