<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PackType;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the packType can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list packtypes');
    }

    /**
     * Determine whether the packType can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PackType  $model
     * @return mixed
     */
    public function view(User $user, PackType $model)
    {
        return $user->hasPermissionTo('view packtypes');
    }

    /**
     * Determine whether the packType can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create packtypes');
    }

    /**
     * Determine whether the packType can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PackType  $model
     * @return mixed
     */
    public function update(User $user, PackType $model)
    {
        return $user->hasPermissionTo('update packtypes');
    }

    /**
     * Determine whether the packType can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PackType  $model
     * @return mixed
     */
    public function delete(User $user, PackType $model)
    {
        return $user->hasPermissionTo('delete packtypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PackType  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete packtypes');
    }

    /**
     * Determine whether the packType can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PackType  $model
     * @return mixed
     */
    public function restore(User $user, PackType $model)
    {
        return false;
    }

    /**
     * Determine whether the packType can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\PackType  $model
     * @return mixed
     */
    public function forceDelete(User $user, PackType $model)
    {
        return false;
    }
}
