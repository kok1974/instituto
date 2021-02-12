<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Grupo;
use App\Models\Matricula;
use App\Models\Curso;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	User::truncate();
    	Grupo::truncate();
    	Matricula::truncate();
        Grupo::factory(20)->create();
        Matricula::factory(15)->create();

        $user = User::create([
            'name' => 'Alberto Sierra',
            'email' => 'alberto.sierra@murciaeduca.es',
            'password' => bcrypt('password'),
            'usuario_av' => 12585,
        ])->cursos()->attach(\Illuminate\Support\Arr::pluck(Curso::factory()->count(3)->create(), 'id'));
    }

}
