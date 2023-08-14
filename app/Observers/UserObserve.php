<?php

namespace App\Observers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use Illuminate\Support\Facades\Mail;

class UserObserve
{
    public function created($user)
    {
        retry(5, function () use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);
    }

    public function updated($user)
    {
        retry(5, function () use ($user) {
            if ($user->isDirty('email')) {
                Mail::to($user)->send(new UserMailChanged($user));
            }
        }, 100);
    }
}
