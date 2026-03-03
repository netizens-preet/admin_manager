<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        $users = User::where('role', User::customer)->latest()->paginate(15);
        return view('user.index', compact('users'));
    }

    /**
     * Toggle the active status of a customer.
     */
    public function toggleStatus(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot manage admin status through this interface.');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'reactivated' : 'banned';

        return back()->with('success', "Customer {$user->name} has been {$status}.");
    }
}
