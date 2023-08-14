<?php

namespace App\Observers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use Illuminate\Support\Facades\Mail;

class UserObserve
{
    public function created($user)
    {
        Mail::to($user)->send(new UserCreated($user));
    }

    public function updated($user)
    {
        if ($user->isDirty('email')) {
            Mail::to($user)->send(new UserMailChanged($user));
        }
    }
}
