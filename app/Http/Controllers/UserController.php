<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => Inertia::scroll(fn () =>
                User::query()
                    ->select('name', 'username', 'avatar', 'bio')
                    ->withCount('followers')
                    ->orderBy('followers_count', 'DESC')
                    ->latest()
                    ->paginate(10)
            )
        ]);
    }

    public function follow(User $user)
    {
        $follower = Auth::user();

        $follower->following()->attach($user);

        return redirect()->back();
    }

    public function unfollow(User $user)
    {
        $follower = Auth::user();

        $follower->following()->detach($user);

        return redirect()->back();
    }
}
