<?php 
namespace App\Repositories\Interfaces;

interface ThemeRepositoryInterface {
    public function getThemeById(int $theme_id);
}