<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\GrupoResource;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gruposDelUsuarioAutenticado = Auth::user()->grupos;
        return GrupoResource::collection($gruposDelUsuarioAutenticado);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $grupo = json_decode($request->getContent(), true);

        $grupo = Grupo::create($grupo);

        return new GrupoResource($grupo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function show(Grupo $grupo)
    {
        return new GrupoResource($grupo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grupo $grupo)
    {
        $grupoData = json_decode($request->getContent(), true);
        $grupo->update($grupoData);

        return new GrupoResource($grupo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grupo $grupo)
    {
        $grupo->delete();
    }
}
