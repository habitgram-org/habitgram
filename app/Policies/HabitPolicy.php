<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Habit;
use App\Models\User;

final class HabitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Habit $habit): bool
    {
        return $this->isParticipant($user, $habit);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Habit $habit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Habit $habit): bool
    {
        return $this->isLeader($user, $habit);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Habit $habit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Habit $habit): bool
    {
        return false;
    }

    public function isParticipant(User $user, Habit $habit): bool
    {
        return $habit->participants()->where('user_id', $user->id)->exists();
    }

    private function isLeader(User $user, Habit $habit): bool
    {
        return $habit->leader->id === $user->id;
    }
}
