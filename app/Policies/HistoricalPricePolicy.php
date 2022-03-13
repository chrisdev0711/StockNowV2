<?php

namespace App\Policies;

use App\Models\User;
use App\Models\HistoricalPrice;
use Illuminate\Auth\Access\HandlesAuthorization;

class HistoricalPricePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the historicalPrice can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list historicalprices');
    }

    /**
     * Determine whether the historicalPrice can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HistoricalPrice  $model
     * @return mixed
     */
    public function view(User $user, HistoricalPrice $model)
    {
        return $user->hasPermissionTo('view historicalprices');
    }

    /**
     * Determine whether the historicalPrice can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create historicalprices');
    }

    /**
     * Determine whether the historicalPrice can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HistoricalPrice  $model
     * @return mixed
     */
    public function update(User $user, HistoricalPrice $model)
    {
        return $user->hasPermissionTo('update historicalprices');
    }

    /**
     * Determine whether the historicalPrice can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HistoricalPrice  $model
     * @return mixed
     */
    public function delete(User $user, HistoricalPrice $model)
    {
        return $user->hasPermissionTo('delete historicalprices');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HistoricalPrice  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete historicalprices');
    }

    /**
     * Determine whether the historicalPrice can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HistoricalPrice  $model
     * @return mixed
     */
    public function restore(User $user, HistoricalPrice $model)
    {
        return false;
    }

    /**
     * Determine whether the historicalPrice can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\HistoricalPrice  $model
     * @return mixed
     */
    public function forceDelete(User $user, HistoricalPrice $model)
    {
        return false;
    }
}
