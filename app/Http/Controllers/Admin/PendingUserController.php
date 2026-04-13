<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PendingUserController extends Controller
{
    public function index(): View
    {
        $pendingUsers = User::with('userStatus')
            ->whereHas('userStatus', function ($query) {
                $query->where('code', UserStatus::PENDING);
            })
            ->latest()
            ->paginate(10);

        return view('super_admin.users.pending.index', compact('pendingUsers'));
    }

    public function show(User $user): View
    {
        $user->load(['userStatus', 'roles']);

        return view('super_admin.users.pending.show', compact('user'));
    }

}
