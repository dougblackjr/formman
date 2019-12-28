<?php

namespace App\Policies;

use App\Form;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormPolicy
{
    use HandlesAuthorization;

    public function read(User $user, Form $form)
    {
        return $user->id === $form->user_id || $user->is_admin;
    }

    public function edit(User $user, Form $form)
    {
        return $user->id === $form->user_id || $user->is_admin;
    }

    public function delete(User $user, Form $form)
    {
        return $user->id === $form->user_id || $user->is_admin;
    }
}
