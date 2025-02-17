<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Host;
use Illuminate\Database\Seeder;

class HostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'Google',
                'ip' => '8.8.8.8',
                'location' => 'US',
                'type' => 'Medium',
                'provider_id' => '1',
                'provider_name' => 'KPN',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Cloudflare',
                'ip' => '1.1.1.1',
                'location' => 'AU',
                'type' => 'Fast',
                'provider_id' => '2',
                'provider_name' => 'Ziggo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Nu.nl',
                'ip' => '92.123.26.200',
                'location' => 'UK',
                'type' => 'Slow',
                'provider_id' => '3',
                'provider_name' => 'T-Mobile',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'stefanmars.nl',
                'ip' => '81.169.145.66',
                'location' => 'DE',
                'type' => 'Fast',
                'provider_id' => '2',
                'provider_name' => 'Ziggo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'trello.com',
                'ip' => '18.244.114.79',
                'location' => 'UK',
                'type' => 'Medium',
                'provider_id' => '3',
                'provider_name' => 'T-Mobile',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ChatGPT',
                'ip' => '104.18.37.228',
                'location' => 'CA',
                'type' => 'Fast',
                'provider_id' => '1',
                'provider_name' => 'KPN',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Youtube',
                'ip' => '209.85.202.93',
                'location' => 'US',
                'type' => 'Slow',
                'provider_id' => '3',
                'provider_name' => 'T-Mobile',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'rickjanssenic1e.nl',
                'ip' => '81.169.145.151',
                'location' => 'DE',
                'type' => 'Medium',
                'provider_id' => '1',
                'provider_name' => 'KPN',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'github.com',
                'ip' => '140.82.121.3',
                'location' => 'DE',
                'type' => 'Medium',
                'provider_id' => '2',
                'provider_name' => 'Ziggo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ];

        // Insert the user data into the 'users' table
        Host::insert($userData);
    }
}
