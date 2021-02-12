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
        Curso::truncate();
       // User::factory(10)->create();
        Grupo::factory(20)->create();
        Matricula::factory(15)->create();
        Curso::factory(10)->create();
        self::seedUsers();

       /* $user = User::factory()
            ->has(Grupo::factory()->count(3))
            ->create();
            */
    }

    public static function seedUsers(){
        $user = new User;

        $user->nombre = 'David';
        $user->email = '8818473@alu.murciaeduca.es';
        $user->password = '123456';
		$user->save();
    }

}
