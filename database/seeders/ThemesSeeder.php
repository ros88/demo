<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('themes')->insert([
            [
                'value' => 'События'
            ],
            [
                'value' => 'Новости'
            ],
            [
                'value' => 'Московская область'
            ],
            [
                'value' => 'Москва'
            ],
            [
                'value' => 'МГУ'
            ],
            [
                'value' => 'ВУНДЕРКИНДЫ'
            ],
            [
                'value' => 'ЭКЗАМЕНЫ'
            ],
            [
                'value' => 'ЕГЭ'
            ],
            [
                'value' => 'Образование'
            ],
            [
                'value' => 'ВИКТОРСАДОВНИЧИЙ'
            ],
        ]);
    }
}
