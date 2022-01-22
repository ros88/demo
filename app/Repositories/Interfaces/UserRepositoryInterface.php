<?php 
namespace App\Repositories\Interfaces;

interface UserRepositoryInterface {
    public function getUserByEmailAndPassword(string $email);
}