<?php 
namespace App\Repositories\Interfaces;

interface ThemeRepositoryInterface {
    public function getThemes();
    public function getThemeById(int $theme_id);
}