<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleService
{
    public function __construct(private RoleRepository $roleRepository) {}
   
    public function getAllRoles() : Collection
    {
        return $this->roleRepository->getAllRoles();
    }

    public function createRole(array $roleData) : Role
    {
        return $this->roleRepository->createRole($roleData);
    }

    public function getRoleById(int $id) : Role
    {
        return $this->roleRepository->getRoleById($id);
    }

    public function updateRole(Role $role, array $roleData) : bool
    {
       return $this->roleRepository->updateRole($role, $roleData);
    }

    public function deleteRole(Role $role) : void
    {
       $this->roleRepository->deleteRole($role);
    }
}