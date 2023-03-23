<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Models\User;
use App\Models\UserPositions;
use App\Models\UserOrganizations;
use App\Models\UserRolls;
use App\Models\Pattern;
use App\Models\PatternUser;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->count(1)
        ->state(new Sequence(
            [
                'login' => 'admin',
                'name' => 'Asosiy admin',
            ],

        ))
        ->has(UserOrganizations::factory()->count(4), 'organizations')
        // ->has(UserPositions::factory()->count(3), 'positions')
        // ->has(UserRolls::factory()->count(3), 'rolls')
        ->create();

        UserRolls::create([
            'user_id' => 1,
            'roll_id' => 4
        ]);
        // Pattern::factory()->count(5)->create();

        // PatternUser::factory()->count(20)->create();
    }
}
