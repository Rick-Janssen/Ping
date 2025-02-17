<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\ProviderSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HostSeeder::class,
            ProviderSeeder::class,
            SettingsSeeder::class,
        ]);
        // Define sample user data
        $userData = [
            [
                'name' => 'Stefan',
                'email' => 'stefanrmars@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('123456'),
                'rank' => 'admin',
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'Rick',
                'email' => '97096664@st.deltion.nl',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('adminrick'),
                'rank' => 'admin',
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'Justin',
                'email' => 'jussieburgmeijer@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('Inloggen123'),
                'rank' => 'admin',
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Add more user data entries as needed
        ];

        // Insert the user data into the 'users' table
       User::insert($userData);
    }
}
