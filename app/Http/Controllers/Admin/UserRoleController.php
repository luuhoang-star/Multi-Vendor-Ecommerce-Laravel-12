<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AlertService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class UserRoleController extends Controller implements HasMiddleware
{ 

static function Middleware(): array {
    return [
        new Middleware('permission:Role Management')
    ];
}
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $admins = Admin::all();
        return view('admin.role-users.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.role-users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'confirmed', 'min:8']
        ]);

        $role = Role::findOrFail($request->role);

        if($role->name == 'Super Admin') {
            AlertService::error('You can not create Super Admin user.');
            return to_route('admin.role-users.index');
        }
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->save();

        
        $admin->assignRole($role);

        AlertService::created();

        return to_route('admin.role-users.index');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $role_user)
    {
        $admin = $role_user;
        $roles = Role::all();
        return view('admin.role-users.edit',compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $role_user)
    {
    if ($role_user->hasRole('Super Admin')) {
        AlertService::error('You can not update Super Admin user');
        return to_route('admin.role-users.index');
    }
            $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email,'. $role_user->id],
        ]);

        $role = Role::findOrFail($request->role);
           if($role->name == 'Super Admin') {
            AlertService::error('You can not create Super Admin user.');
            return to_route('admin.role-users.index');
        }
        
        $admin = $role_user;
        $admin->name = $request->name;
        $admin->email = $request->email;
        if($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'confirmed', 'min:8']
            ]);
            $admin->password = bcrypt($request->password);
        }
        $admin->save();

        $admin->assignRole($role);

        AlertService::updated();

        return to_route('admin.role-users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $role_user): JsonResponse
    {
            if ($role_user->hasRole('Super Admin')) {
            return response()->json(['status' => 'error', 'message' => 'You can not delete Super Admin user.']);
        }
        try {
            foreach($role_user->getRoleNames() as $role) {
                $role_user->removeRole($role);
            }
            $role_user->delete();

            AlertService::deleted();

            return response()->json(['status' => 'success', 'message' => 'Deleted Successfully']);
        } catch (\Throwable $th) {
            Log::error('Role Delete Error: ', $th);
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
