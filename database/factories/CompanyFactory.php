<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'phone' => $this->faker->e164PhoneNumber(),
            'description' => $this->faker->realText(50),
        ];
    }
}
