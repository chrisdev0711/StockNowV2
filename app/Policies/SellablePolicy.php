<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Sellable;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellablePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the sellable can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list sellables');
    }

    /**
     * Determine whether the sellable can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Sellable  $model
     * @return mixed
     */
    public function view(User $user, Sellable $model)
    {
        return $user->hasPermissionTo('view sellables');
    }

    /**
     * Determine whether the sellable can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create sellables');
    }

    /**
     * Determine whether the sellable can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Sellable  $model
     * @return mixed
     */
    public function update(User $user, Sellable $model)
    {
        return $user->hasPermissionTo('update sellables');
    }

    /**
     * Determine whether the sellable can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Sellable  $model
     * @return mixed
     */
    public function delete(User $user, Sellable $model)
    {
        return $user->hasPermissionTo('delete sellables');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Sellable  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete sellables');
    }

    /**
     * Determine whether the sellable can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Sellable  $model
     * @return mixed
     */
    public function restore(User $user, Sellable $model)
    {
        return false;
    }

    /**
     * Determine whether the sellable can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Sellable  $model
     * @return mixed
     */
    public function forceDelete(User $user, Sellable $model)
    {
        return false;
    }
}
