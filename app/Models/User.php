<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DB;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdministrator() {
        return $this->id == 1;
    }

    public function isProfesor() {
        return DB::table('materiasimpartidas')::where('docente', Auth::userId())->count() > 0;
    }

    public function isAlumno() {
        return Matricula::where('alumno', Auth::userId());
    }

    /**
     * Devolver el centro que coordina.
     */
    public function centroCoordinado()
    {
        return $this->hasOne(Centro::class, 'coordinador');
    }

    /**
     * Los grupos en los que está matriculado un determinado alumno.
     */
    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'matriculas', 'alumno', 'grupo');
    }

    public function notas()
    {
        return $this->hasMany(Nota::class, 'user_id');
    }


}
