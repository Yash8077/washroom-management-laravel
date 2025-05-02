<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
// Add FormRequests for validation

class UserController extends Controller
{
    /**
     * Display a listing of users (staff, admins).
     */
    public function index(Request $request)
    {
        // --- Filtering logic ---
        $query = User::query();
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        $users = $query->orderBy('name')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Pass roles if dynamic
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request) // Use FormRequest
    {
        // --- Validation ---
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,staff'], // Adjust roles as needed
            // Add other fields like staffId if needed
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            // map other fields
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        // Load related data like tasks assigned, etc.
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
         return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user) // Use FormRequest
    {
        // --- Validation (handle password optionality) ---
         $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,staff'], // Adjust roles
            // Add other fields
        ]);

        $data = $request->only(['name', 'email', 'role' /* , other fields */]);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage (or deactivate).
     */
    public function destroy(User $user)
    {
        // --- Authorization check ---
        // Prevent deleting own account or last admin
        // Consider deactivating instead of deleting if user has history
        // if ($user->id === auth()->id()) return back()->with('error', 'Cannot delete yourself.');

        $user->delete(); // Or $user->update(['is_active' => false]);

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}