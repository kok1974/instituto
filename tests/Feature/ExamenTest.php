<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Curso;
use Laravel\Sanctum\Sanctum;

class ExamenTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $user = User::find(1);
        Sanctum::actingAs($user);

    }

    public function test_ejercicio1()
    {
        dump('1.- Probando el CRUD');
        dump('====================');

        dump('1.1.- POST /api/cursos');
        $response = $this->postJson('/api/cursos',[
            'shortname' => 'mi curso',
            'fullname' => 'El curso del examen'
        ]);
        $nuevoCurso = json_decode($response->getContent())->data->id;
        $response->assertCreated()
            ->assertJsonCount(1)
            ->assertJsonPath('data.shortname', 'mi curso')
            ->assertJsonPath('data.fullname', 'El curso del examen');

        dump('1.2.- GET /api/cursos');
        $response = $this->get('/api/cursos');
        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [['shortname', 'fullname', 'summary']]]);


        dump('1.3.- GET /api/cursos/' . $nuevoCurso);
        $response = $this->get('/api/cursos/' . $nuevoCurso);
        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonStructure(['data' => ['shortname', 'fullname', 'summary']]);

        dump('1.4.- GET /api/cursos/1000000');
        $response = $this->get('/api/cursos/11000000');
        $response->assertNotFound();

        dump('1.5.- PUT /api/cursos/' . $nuevoCurso);
        $response = $this->putJson('/api/cursos/' . $nuevoCurso,[
            'shortname' => 'mi curso',
            'fullname' => 'El curso del examen'
        ]);
        $response->assertSuccessful()
            ->assertJsonCount(1)
            ->assertJsonPath('data.shortname', 'mi curso')
            ->assertJsonPath('data.fullname', 'El curso del examen');

        dump('1.6.- DELETE /api/cursos/' . $nuevoCurso);
        $response = $this->delete('/api/cursos/' . $nuevoCurso);
        $response->assertSuccessful();
    }

    public function test_ejercicio2()
    {
        dump('2.- Migración curso_user');
        dump('========================');
        $response = $this->postJson('/api/records/curso_user',[
            'user_id' => 1,
            'curso_id' => 1
        ]);
        $response->assertSuccessful();
    }

    public function test_ejercicio3()
    {
        dump('3.- Relaciones User_Curso');
        dump('=========================');
        $user = Auth::user();
        $curso = $user->cursos->first();
        $this->assertDatabaseHas('cursos', [
            'shortname' => $curso->shortname,
            'fullname' => $curso->fullname,
        ]);
        $user = $curso->users->first();
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }

    public function test_ejercicio4()
    {
        dump('4.- Factory del modelo Curso');
        dump('============================');
        $curso = Curso::factory()->create();
        $this->assertDatabaseHas('cursos', [
            'shortname' => $curso->shortname,
            'fullname' => $curso->fullname,
        ]);
    }

    public function test_ejercicio5()
    {
        dump('5.- usuario_av');
        dump('==============');
        $user = User::whereNotNull('usuario_av')->first();
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }

    public function test_ejercicio6()
    {
        dump('6.- Policy GET /api/cursos/{cursoId}');
        dump('====================================');

        $user = User::find(1);
        unset($user->usuario_av);
        Sanctum::actingAs($user);
        $response = $this->get('/api/cursos/1');
        $response->assertForbidden();

        $user = User::whereNotNull('usuario_av')->first();
        Sanctum::actingAs($user);
        $response = $this->get('/api/cursos/1');
        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonStructure(['data' => ['shortname', 'fullname', 'summary']]);
    }

    public function test_ejercicio7()
    {
        dump('7.- Acceso a la API del Aula Virtual');
        dump('============================');

        $response = $this->get('/api/cursos/aulavirtual');
        $response->assertStatus(200)
            ->assertJsonFragment(['shortname' => 'alberto.sierra_ES_DW2_20_21']);
    }
}
