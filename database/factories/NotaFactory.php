<?php

namespace Database\Factories;

use App\Models\Nota;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nota::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

      //  $countUser = User::count();
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'materia_id' => $this->faker->numberBetween(1, 5),
            'evaluacion' => $this->faker->randomElement(array ('Primera','Segunda','Tercera')),
            'nota' => $this->faker->numberBetween(1, 10),

        ];
    }
}
