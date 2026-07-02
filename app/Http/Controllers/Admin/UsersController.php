<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withTrashed();

        if ($request->filled('status')) {
            match ($request->status) {
                'Active'   => $query->whereNull('deleted_at')->whereNull('email_verified_at'),
                'Inactive' => $query->whereNull('deleted_at')->whereNotNull('email_verified_at'),
                'Banned'   => $query->whereNotNull('deleted_at'),
                default    => null,
            };
        }

        $roleMap = ['Admin' => 1, 'Member' => 2, 'Premium-Member' => 3];
        if ($request->filled('role') && isset($roleMap[$request->role])) {
            $query->where('role', $roleMap[$request->role]);
        }

        $all_users = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        $totalUsers = User::withTrashed()->count();
        $newUsers7d = User::where('created_at', '>=', now()->subDays(7))->count();

        // 反転：email_verified_atに値がある = 手動でInactive化された、とみなす
        $bannedOrDeactivated = User::onlyTrashed()->count()
            + User::whereNull('deleted_at')->whereNotNull('email_verified_at')->count();

        return view('admin.users.index', compact('all_users', 'totalUsers', 'newUsers7d', 'bannedOrDeactivated'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|integer|in:1,2,3',
        ]);

        $user = User::withTrashed()->findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'success' => true,
            'role' => $user->role,
            'role_name' => $user->role_name,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Active,Inactive,Banned',
        ]);

        $user = User::withTrashed()->findOrFail($id);

        switch ($request->status) {
            case 'Banned':
                if (! $user->trashed()) {
                    $user->delete();
                }
                break;

            case 'Active':
                if ($user->trashed()) {
                    $user->restore();
                }
                $user->email_verified_at = null;   // ← 反転：Activeはnullに戻す
                $user->save();
                break;

            case 'Inactive':
                if ($user->trashed()) {
                    $user->restore();
                }
                $user->email_verified_at = now();  // ← 反転：Inactiveは値を入れる
                $user->save();
                break;
        }

        return response()->json([
            'success' => true,
            'status' => $user->fresh()->status,
        ]);
    }
}
