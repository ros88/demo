<?php 
namespace App\Repositories;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface {
    public function getRoleById(int $role_id)
    {
        return Role::find($role_id);
    }
}