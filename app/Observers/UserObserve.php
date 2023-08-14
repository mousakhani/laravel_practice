<?php

namespace App\Observers;

use App\Mail\UserCreated;
use Illuminate\Support\Facades\Mail;

class UserObserve
{
    public function created($user)
    {
        Mail::to($user)->send(new UserCreated($user));
    }
}
