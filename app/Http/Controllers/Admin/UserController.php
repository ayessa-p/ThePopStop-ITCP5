<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query()->withCount('orders');
            return DataTables::eloquent($query)
                ->addColumn('actions', function (User $u) {
                    $buttons = '<div class="action-stack">';
                    $buttons .= '<a href="' . route('admin.users.show', $u) . '" class="btn-action view">View</a>';
                    $buttons .= '<a href="' . route('admin.users.edit', $u) . '" class="btn-action edit">Update</a>';
                    $buttons .= '<form action="' . route('admin.users.toggle-active', $u) . '" method="POST" style="margin:0;">' .
                        csrf_field() .
                        '<button type="submit" class="btn-action deactivate">' . ($u->is_active ? 'Deactivate' : 'Activate') . '</button></form>';
                    if ($u->id !== auth()->id()) {
                        $buttons .= '<form action="' . route('admin.users.destroy', $u) . '" method="POST" style="margin:0;">' .
                            csrf_field() . method_field('DELETE') .
                            '<button type="submit" class="btn-action delete" onclick="return confirm(\'Delete user?\')">Delete</button></form>';
                    }
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['actions'])
                ->toJson();
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('username', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('full_name', 'like', "%{$s}%");
            });
        }

        $query = User::withCount('orders')->orderByDesc('created_at');
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('username', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('full_name', 'like', "%{$s}%");
            });
        }
        $users = $query->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'role' => 'required|in:customer,admin',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['name'] = $validated['full_name'];
        $validated['is_active'] = true;

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'role' => 'required|in:customer,admin',
            'password' => 'nullable|min:8|confirmed',
        ]);

        unset($validated['password']);
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }
        $validated['name'] = $validated['full_name'];

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }
        $user->orders()->delete();
        $user->reviews()->delete();
        $user->cartItems()->delete();
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => ! $user->is_active]);
        $message = $user->is_active ? 'User activated.' : 'User deactivated.';
        return back()->with('success', $message);
    }
}
