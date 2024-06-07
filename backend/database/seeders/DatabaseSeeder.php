<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            //CategorySeeder::class,
            //MealSeeder::class,
            ReservationStatusSeeder::class,
            //ReservationSeeder::class,
            //FavoriteSeeder::class,
            //TopicSeeder::class,
            //MessageSeeder::class,
            SettingSeeder::class


        ]);
    }
}
