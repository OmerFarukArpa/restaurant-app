<?php

namespace Database\Seeders;

use App\Models\ReservationStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReservationStatus::create([
            'status' =>'pending'
        ]);
        ReservationStatus::create([
           'status' =>'approval'
        ]);
        ReservationStatus::create([
            'status' =>'cancel'
        ]);
    }
}
