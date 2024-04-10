<?php

namespace App\Http\Controllers;

use App\Events\RoleEvent;
use App\Http\Requests\RoleFormRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use App\Models\Role;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{
    public function __construct(private RoleService $roleService)
    {
    }

    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        $result[0] = 'Selected';
        $result[1] = 'Role List Data';
        event(new RoleEvent($result));
        return new RoleResource($roles);
    }

    public function store(RoleFormRequest $request)
    {
        $roleData = [
            'role_name' => $request->input('role_name'),
        ];

        $role = $this->roleService->createRole($roleData);
        $result[0] = 'Created';
        $result[1] = $role->role_name;
        event(new RoleEvent($result));
        return Response::success('Success', 200, []);
    }

    public function edit(Role $role)
    {
        $role = $this->roleService->getRoleById($role->id);

        return new roleResource($role);
    }

    public function update(RoleFormRequest $request, Role $role)
    {
        $roleData = [
            'role_name' => $request->input('role_name'),
        ];

        $this->roleService->updateRole($role, $roleData);
        $result[0] = 'Updated';
        $result[1] = $role->role_name;
        event(new RoleEvent($result));
        return Response::success('Success', 200, []);
    }

    public function destroy(Role $role)
    {
        $this->roleService->deleteRole($role);
        $result[0] = 'Deleted';
        $result[1] = $role->role_name;
        event(new RoleEvent($result));
        return Response::success('Success', 200, []);
    }
}
