<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the order_item can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list order_items');
    }

    /**
     * Determine whether the order_item can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OrderItem  $model
     * @return mixed
     */
    public function view(User $user, OrderItem $model)
    {
        return $user->hasPermissionTo('view order_items');
    }

    /**
     * Determine whether the order_item can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create order_items');
    }

    /**
     * Determine whether the order_item can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OrderItem  $model
     * @return mixed
     */
    public function update(User $user, OrderItem $model)
    {
        return $user->hasPermissionTo('update order_items');
    }

    /**
     * Determine whether the order_item can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OrderItem  $model
     * @return mixed
     */
    public function delete(User $user, OrderItem $model)
    {
        return $user->hasPermissionTo('delete order_items');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OrderItem  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete order_items');
    }

    /**
     * Determine whether the order_item can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OrderItem  $model
     * @return mixed
     */
    public function restore(User $user, OrderItem $model)
    {
        return false;
    }

    /**
     * Determine whether the order_item can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\OrderItem  $model
     * @return mixed
     */
    public function forceDelete(User $user, OrderItem $model)
    {
        return false;
    }
}
