<?php 
namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface {
    public function getUserByEmailAndPassword(string $email) 
    {
        return User::where('email', $email)->first();
    }
}