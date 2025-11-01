<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{
    public function index(){
        $users = User::paginate(10);
        return view('admin.index', compact('users'));
    }
    public function create(){
        return view('admin.create');
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'is_admin' => 'required|boolean',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin,
        ]);
        return redirect()->route('staff.index')->with('success', 'User created successfully!');
    }
    public function edit($id){
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'is_admin' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_admin = $request->is_admin;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('staff.index')->with('success', 'User updated successfully.');
}

    
    public function delete($id){
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted successfully.');
    }
    public function toggleStatus($id){
        $user = User::findOrFail($id);
        $user->status = !$user->status; //if status=1 alors 0 vice versa 
        $user->save();

        return back()->with('success', 'User status updated.');
    }
   

    
}
