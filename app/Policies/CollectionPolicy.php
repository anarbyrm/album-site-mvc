<?php

namespace App\Policies;

use App\Models\Collection;
use App\Models\User;

class CollectionPolicy
{
    public function __construct()
    {
        //
    }

    public function view(User $user, Collection $collection)
    {
        return $user->id === $collection->user_id;
    }
}
