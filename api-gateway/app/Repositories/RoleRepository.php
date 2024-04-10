<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RoleRepository
{
    public function __construct(protected Role $role)
    {
    }

    public function getAllRoles(): Collection
    {
        try {
            DB::beginTransaction();

            $roles = Role::orderBy('role_name', 'asc')->get();

            DB::commit();

            return $roles;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function createRole(array $roleData): Role
    {
        try {
            DB::beginTransaction();

            $role = Role::create([
                'role_name' => $roleData['role_name'],
            ]);

            DB::commit();

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getRoleById(int $id): Role
    {
        try {
            DB::beginTransaction();

            $role = Role::find($id);

            DB::commit();

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateRole(Role $role, array $roleData): bool
    {
        try {
            DB::beginTransaction();

            $result = $role->update([
                'role_name' => $roleData['role_name'],
            ]);

            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteRole(Role $role): void
    {
        try {
            DB::beginTransaction();

            $role->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}