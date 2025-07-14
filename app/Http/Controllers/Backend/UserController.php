<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('backend.user.index', compact('user'));
    }

    public function create()
    {
        return view('backend.user.create');
    }

    

    public function store(Request $request)

        
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        $user = new User;
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->password = Hash::make($request->password);
        $user->is_admin = $request->has('is_admin');
        $user->save();

        toast('Ges aya tah bagong', 'success');
        return redirect()->route('backend.user.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('backend.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->is_admin = $request->has('is_admin');
        $user->save();

        toast('ges ka ubah tah', 'success');
        return redirect()->route('backend.user.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        toast('ges eweh tah', 'success');
        return redirect()->route('backend.user.index')->with('success', 'User deleted successfully.');
    }
}
