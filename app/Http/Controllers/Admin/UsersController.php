<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Role;
use Inertia\Inertia;
use DataTables;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Users/Index');
    }

    public function loadUsers()
    {
        $model = User::with('roles');

        return DataTables::of($model)->toJson();
    }

    public function create()
    {
        $roles = Role::all();
        return Inertia::modal('Admin/Users/Create', ['roles' => $roles])
            ->baseRoute('Admin.users.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->addRole($request->role);
    }

    public function edit($id)
    {
        $user  = User::with('roles')->find($id);
        $roles = Role::all();
        return Inertia::modal('Admin/Users/Edit', ['user' => $user, 'roles' => $roles])
            ->baseRoute('Admin.users.index');
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => 'required',
        ]);

        $user = User::findOrFail($id);
        $input = $request->all();

        if ($input['password'] !== null) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }
        $user->update($input);
        $user->syncRoles([$request->role]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}
