<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pattern;
use App\Models\RejectTypes;

class PatternFactory extends Factory
{

    protected $model = Pattern::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'reject_type_id' => RejectTypes::all()->random(),
            'user_id' => RejectTypes::all()->random(),
        ];
    }
}
