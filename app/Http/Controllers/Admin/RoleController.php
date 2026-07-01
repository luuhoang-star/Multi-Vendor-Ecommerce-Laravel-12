<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AlertService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log; // ✅ Thêm dòng này


class RoleController extends Controller implements HasMiddleware
{

    static function Middleware(): array {
        return [
            new Middleware('permission:Role Management')
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $roles = Role::withCount('permissions')->get(); //withCount('permissions') = đếm xem mỗi role có bao nhiêu permission được gán
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permissions = Permission::all()->groupBy('group_name');
        return view('admin.role.create', compact('permissions'));
    }

    /** 
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => ['required', 'string', 'max:255', 'unique:roles,name'], //unique:roles,name : ko đc trùng tên trong bảng roles
            'permissions' => ['required', 'array']
        ]);
        $role = Role::create(['name' => $request->role, 'guard_name' => 'admin']);
        $role->syncPermissions($request->permissions);

        AlertService::created();
        return to_route('admin.role.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy('group_name');
        return view('admin.role.edit', compact('role', 'permissions'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if($role->name == 'Super Admin') {
            AlertService::error('Bạn không thể thay đổi quyền của Super Admin.');
            return to_route('admin.role.index');
        }


        $request->validate([
            'role' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role->id], //unique:roles,name : ko đc trùng tên trong bảng roles
            'permissions' => ['required', 'array']
        ]);
        $role->update(['name' => $request->role]);
        $role->syncPermissions($request->permissions);

        AlertService::updated();
        return to_route('admin.role.index');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Role $role)
    {
        if ($role->name == 'Super Admin') {
            AlertService::error('Bạn không thể xóa vai trò Super Admin.');
            return to_route('admin.role.index');
        }
        try {
            DB::beginTransaction();

            $role->users()->detach();
            $role->permissions()->detach();
            $role->delete();

            DB::commit();
            AlertService::deleted();

            return response()->json(['status' => 'success', 'message' => 'Đã xóa vai trò thành công']); // ✅ Thêm (

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Xóa vai trò thất bại: ', [$th]); // ✅ Log cần array

            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }
}
