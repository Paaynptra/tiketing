<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $users = User::query()
            ->when($q, fn($query) => $query->where(fn($x) => $x
                ->where('name', 'like', "%$q%")
                ->orWhere('email', 'like', "%$q%")
            ))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();
        return view('admin.users.index', compact('users', 'q'));
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->withErrors('Tidak bisa menghapus akun sendiri.');
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}

