<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request) {
        User::create($request->only('name','email') + [
            'password' => bcrypt('password'),
            'is_admin' => $request->is_admin ?? 0
        ]);
        return back()->with('success','Utilisateur créé');
    }

    public function update(Request $request, User $user) {
        $user->update($request->only('name','email','is_admin'));
        return back()->with('success','Utilisateur mis à jour');
    }

    public function destroy(User $user) {
        $user->delete();
        return back()->with('success','Utilisateur supprimé');
    }
}
