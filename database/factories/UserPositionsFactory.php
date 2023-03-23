<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserPositions;
use App\Models\Position;

class UserPositionsFactory extends Factory
{
    protected $model = UserPositions::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'position_id' => Position::all()->random(),
        ];
    }
}
