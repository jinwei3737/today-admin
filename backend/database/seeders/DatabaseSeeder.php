<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name'              => 'Jin wei',
            'email'             => '215838961@qq.com',
            'email_verified_at' => '2021-04-30 08:52:34',
            'password'          => Hash::make('admin123'),
        ]);
    }
}
