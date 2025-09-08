<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-users');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->can('view-users') || $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Anyone can register
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, $model): bool
    {
        return $user->can('edit-users') || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, $model): bool
    {
        // User with delete-users permission can delete anyone except themselves
        if ($user->can('delete-users') && $user->id !== $model->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can change role.
     */
    public function changeRole(User $user, $model): bool
    {
        return $user->can('manage-roles') && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can view admin panel.
     */
    public function viewAdmin(User $user): bool
    {
        return $user->can('view-admin-dashboard');
    }

    /**
     * Determine whether the user can manage users.
     */
    public function manageUsers(User $user): bool
    {
        return $user->can('manage-roles');
    }
}
