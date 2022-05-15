<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $user)
    {
        $user->handle = $user->handle ?? uniqid();
    }
}
