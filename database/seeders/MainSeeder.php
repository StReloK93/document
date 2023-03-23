<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Models\RejectTypes;
use App\Models\Organization;
use App\Models\Position;
use App\Models\Roll;


class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::factory()->count(5)
        ->state(new Sequence(
            ['name' => 'SHKB Direktori'],
            ['name' => "MM bo'yicha direktor o'rinbosari"],
            ['name' => "Kadrlar bo'limi boshlig'i"],
            ['name' => 'Inspektor'],
            ['name' => 'Korxona rahbari'],
        ))
        ->create();

        Organization::factory()->count(21)->state(new Sequence(
            ['bool' => false],
            ['bool' => true],
        ))
        ->create();

        RejectTypes::factory()->count(3)->state(new Sequence(
            ['name' => 'Ishga kirish'],
            ['name' => "Ishdan ketish"],
            ['name' => "Lavozimni o'zgartirish"],
        ))
        ->create();


        Roll::factory()->count(4)->state(new Sequence(
            ['name' => 'Kiritish'],
            ['name' => "O'zgartirish"],
            ['name' => "O'chirish"],
            ['name' => "Admin"],
        ))
        ->create();
    }
}
