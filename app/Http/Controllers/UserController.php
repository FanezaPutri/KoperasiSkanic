<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Method index untuk menampilkan halaman form & daftar user
    public function index()
    {
        $users = User::whereIn('role', ['admin', 'buyer'])->latest()->get();
        return view('users.index', compact('users'));
    }

    // Method store untuk memproses simpan akun
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,buyer',
            'kelas'    => 'nullable|string|max:50',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'kelas'    => $request->role === 'buyer' ? $request->kelas : null,
        ]);

        return redirect()->back()->with('success', 'Akun berhasil ditambahkan!');
    }
}