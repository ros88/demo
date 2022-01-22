<?php 
namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface {
    public function getRoleById(int $role_id);
}