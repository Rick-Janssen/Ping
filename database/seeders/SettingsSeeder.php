<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::insert([
            [
                'maxPing' => '120',
                'max_consecutive_errors' => '3',
            ],
        ]);
    }
}
