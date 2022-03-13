<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductSite;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductSitePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the productSite can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list productcategories');
    }

    /**
     * Determine whether the productSite can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductSite  $model
     * @return mixed
     */
    public function view(User $user, ProductSite $model)
    {
        return $user->hasPermissionTo('view productcategories');
    }

    /**
     * Determine whether the productSite can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create productcategories');
    }

    /**
     * Determine whether the productSite can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductSite  $model
     * @return mixed
     */
    public function update(User $user, ProductSite $model)
    {
        return $user->hasPermissionTo('update productcategories');
    }

    /**
     * Determine whether the productSite can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductSite  $model
     * @return mixed
     */
    public function delete(User $user, ProductSite $model)
    {
        return $user->hasPermissionTo('delete productcategories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductSite  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete productcategories');
    }

    /**
     * Determine whether the productSite can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductSite  $model
     * @return mixed
     */
    public function restore(User $user, ProductSite $model)
    {
        return false;
    }

    /**
     * Determine whether the productSite can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\ProductSite  $model
     * @return mixed
     */
    public function forceDelete(User $user, ProductSite $model)
    {
        return false;
    }
}
