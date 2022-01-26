<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleTheme;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Вызов сидеров для первичного наполения БД данными
        $this->call([RolesSeeder::class, ThemesSeeder::class]);

        // Вызов фабрики для создания 20 пользователей(пароль для всех til123456)
        User::factory()->count(20)->create();

        // Вызов фабрики для создания 20 статей
        Article::Factory()->count(20)->create();

        ArticleTheme::Factory()->count(40)->create();

        // Массив ссылок на картинки
        $avatarsUrl = [
            'https://www.gettyimages.com/gi-resources/images/500px/983794168.jpg',
            'https://images.ctfassets.net/hrltx12pl8hq/3MbF54EhWUhsXunc5Keueb/60774fbbff86e6bf6776f1e17a8016b4/04-nature_721703848.jpg?fit=fill&w=480&h=270',
            'https://images.ctfassets.net/hrltx12pl8hq/4NhtYxiAxVzEzQQVFl5c0h/e70608b02fa41bd0841a56824e78bbff/UHP-Abstract-_0_00_00_00_.jpg?fit=fill&w=600&h=400',
            'https://images.unsplash.com/photo-1594289563350-6d2472cdae58?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8Ymx1fGVufDB8fDB8fA%3D%3D&w=1000&q=80',
        ];

        // Устанавливаем аватарки для пользователей
        $users = User::select(['id'])->get();
        $users->each(function ($user) use ($avatarsUrl) {
            $index = rand(0, (count($avatarsUrl) - 1));
            $user->addMediaFromUrl($avatarsUrl[$index])
                 ->toMediaCollection('user_avatar');
        });
    }
}
