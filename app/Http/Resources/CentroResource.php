<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CentroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        // El siguiente código diferencia la respuesta en función del usuario autenticado
        // No es necesario para que funcione el Gate
        // En primer lugar recogemos al usuario autenticado
        $user = Auth::user();
            // Devolución de este método por defecto
            // return parent::toArray($request);
        // Los datos que se van a mostrar por defecto son: id y nombre
            $datos = array (
                'id' => $this->id,
                'nombre' => $this->nombre
            );
        // Si el identificador del usuario es el 1, además de los datos generales
        if($user->id == 1) {
            $datos['web'] = $this->web;
        }
        return $datos;
    }
}
