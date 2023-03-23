<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserOrganizations;
use App\Models\Organization;


class UserOrganizationsFactory extends Factory
{
    protected $model = UserOrganizations::class;


    public function definition()
    {
        return [
            'organization_id' => Organization::where('bool', true)->get()->random(),
        ];
    }
}
