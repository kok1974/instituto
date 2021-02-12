<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Curso::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shortname' => $this->faker->word(),
            'fullname' => $this->faker->sentence(),
            'summary' => $this->faker->paragraph(),
            'showgrades' => $this->faker->boolean(),
            'startdate' => $this->faker->date(),
        ];
    }
}
