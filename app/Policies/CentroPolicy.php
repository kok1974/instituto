<?php

namespace App\Policies;

use App\Models\Centro;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CentroPolicy
{
    use HandlesAuthorization;

/**
 * Perform pre-authorization checks.
 *
 * @param  \App\Models\User  $user
 * @param  string  $ability
 * @return void|bool
 */
public function before(User $user, $ability)
{
    if ($user->isAdministrator()) {
        return true;
    }
}

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Centro  $centro
     * @return mixed
     */
    public function view(User $user, Centro $centro)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Centro  $centro
     * @return mixed
     */
    public function update(User $user, Centro $centro)
    {
        return $user->id === $centro->coordinador;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Centro  $centro
     * @return mixed
     */
    public function delete(User $user, Centro $centro)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Centro  $centro
     * @return mixed
     */
    public function restore(User $user, Centro $centro)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Centro  $centro
     * @return mixed
     */
    public function forceDelete(User $user, Centro $centro)
    {
        //
    }
}
