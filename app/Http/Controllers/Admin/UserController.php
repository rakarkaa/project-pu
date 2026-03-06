<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,user',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'is_active' => true,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // PERBAIKAN: Tambahkan validasi email dan password opsional
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id, // Abaikan email milik user ini sendiri
            'role'      => 'required|in:admin,user',
            'is_active' => 'required|boolean',
            'password'  => 'nullable|min:6', // Nullable berarti boleh kosong
        ]);

        // Admin tidak boleh menonaktifkan dirinya sendiri
        if (auth()->id() === $user->id && !$request->is_active) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri');
        }

        // PERBAIKAN: Persiapkan data update
        $updateData = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'is_active' => $request->is_active,
        ];

        // Jika form password diisi, maka update passwordnya
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        // Proteksi ganda agar tidak bisa hapus diri sendiri lewat endpoint
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}