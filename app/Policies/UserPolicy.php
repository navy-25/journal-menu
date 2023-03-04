<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function isRoot($user)
    {
        return $user->role == 0;
    }
    public function isOwner($user)
    {
        return $user->role == 1;
    }
    public function isPartner($user)
    {
        return $user->role == 2;
    }
}
