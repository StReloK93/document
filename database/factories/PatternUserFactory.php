<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PatternUser;
use App\Models\Pattern;
use App\Models\Position;


class PatternUserFactory extends Factory
{
    protected $model = PatternUser::class;


    public function definition()
    {
        return [
            'pattern_id' => Pattern::all()->random(),
            'position_id' => Position::all()->random(),
        ];
    }
}
