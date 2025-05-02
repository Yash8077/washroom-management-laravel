<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class DashboardController extends Controller
{
    /**
     * Display the staff dashboard (likely focused on assigned tasks).
     */
    public function index()
    {
        $user = auth()->user();
        $assignedTasks = Task::where('assigned_user_id', $user->id)
                             ->whereIn('status', ['pending', 'in-progress']) // Show active tasks
                             ->with('washroom.floor.building')
                             ->orderBy('priority', 'desc') // Or by due_at
                             ->orderBy('created_at')
                             ->get();

        // Fetch other relevant info if needed (e.g., recent issues reported by staff)

        return view('staff.dashboard', compact('assignedTasks'));
    }
}