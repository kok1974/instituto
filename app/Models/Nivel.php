<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;

    protected $table = 'niveles';

      protected $fillable = [
        'nombre',
        'nivelsuperior'
    ];

    /**
     * Devuelve los grupos de un nivel determinado.
     */
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'nivel');
    }
}
