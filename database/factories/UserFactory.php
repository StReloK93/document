<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Hash;
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'login' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('strelok'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ];
    }
}
