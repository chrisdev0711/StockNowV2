<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ingredient;
use Illuminate\Auth\Access\HandlesAuthorization;

class IngredientPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the ingredient can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list ingredients');
    }

    /**
     * Determine whether the ingredient can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Ingredient  $model
     * @return mixed
     */
    public function view(User $user, Ingredient $model)
    {
        return $user->hasPermissionTo('view ingredients');
    }

    /**
     * Determine whether the product can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create ingredients');
    }

    /**
     * Determine whether the ingredient can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Ingredient  $model
     * @return mixed
     */
    public function update(User $user, Ingredient $model)
    {
        return $user->hasPermissionTo('update ingredients');
    }

    /**
     * Determine whether the ingredient can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Ingredient  $model
     * @return mixed
     */
    public function delete(User $user, Ingredient $model)
    {
        return $user->hasPermissionTo('delete ingredients');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Ingredient  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete ingredients');
    }

    /**
     * Determine whether the ingredient can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Ingredient  $model
     * @return mixed
     */
    public function restore(User $user, Ingredient $model)
    {
        return false;
    }

    /**
     * Determine whether the ingredient can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Ingredient  $model
     * @return mixed
     */
    public function forceDelete(User $user, Ingredient $model)
    {
        return false;
    }
}
