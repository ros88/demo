<?php 
namespace App\Repositories;
use App\Repositories\Interfaces\ThemeRepositoryInterface;
use App\Models\Theme;

class ThemeRepository implements ThemeRepositoryInterface {
    public function getThemeById(int $theme_id)
    {
        return Theme::find($theme_id);
    }
}