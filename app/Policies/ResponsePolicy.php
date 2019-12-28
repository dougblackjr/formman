<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResponsePolicy
{
    use HandlesAuthorization;

    public function read(User $user, Response $response)
    {
        return $user->id === $response->form->user_id || $user->is_admin;
    }

}
