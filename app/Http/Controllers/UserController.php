<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function check(User $user)
    {
        $user->subscribed('default'); // آیا اشتراک فعال دارد؟

        $user->subscription('default')->onGracePeriod(); // آیا در دوره‌ی مهلت بعد از کنسل کردن است؟

        $user->subscription('default')->cancelled(); // آیا کنسل شده؟

    }
}
