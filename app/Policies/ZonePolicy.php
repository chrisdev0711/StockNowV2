<?php

namespace App\Policies;

use App\Models\Zone;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ZonePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the zone can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list zones');
    }

    /**
     * Determine whether the zone can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Zone  $model
     * @return mixed
     */
    public function view(User $user, Zone $model)
    {
        return $user->hasPermissionTo('view zones');
    }

    /**
     * Determine whether the zone can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create zones');
    }

    /**
     * Determine whether the zone can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Zone  $model
     * @return mixed
     */
    public function update(User $user, Zone $model)
    {
        return $user->hasPermissionTo('update zones');
    }

    /**
     * Determine whether the zone can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Zone  $model
     * @return mixed
     */
    public function delete(User $user, Zone $model)
    {
        return $user->hasPermissionTo('delete zones');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Zone  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete zones');
    }

    /**
     * Determine whether the zone can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Zone  $model
     * @return mixed
     */
    public function restore(User $user, Zone $model)
    {
        return false;
    }

    /**
     * Determine whether the zone can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Zone  $model
     * @return mixed
     */
    public function forceDelete(User $user, Zone $model)
    {
        return false;
    }
}
