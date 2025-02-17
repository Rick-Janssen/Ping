<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Provider::insert([
            [
                'name' => 'KPN',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ziggo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'T-Mobile',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], 
        ]);
    }
}
