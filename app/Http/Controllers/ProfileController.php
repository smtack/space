<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Post;

class ProfileController extends Controller
{
    public function __invoke(User $user)
    {
        $posts = Inertia::scroll(function () use ($user) {
            return Post::query()
                ->whereIn('id', $user->reposts()->pluck('id'))
                ->orWhere('user_id', '=', $user->id)
                ->latest()
                ->paginate(10)
                ->through(function ($post) {
                    $post->liked = Auth::user()->likesPost($post);
                    $post->bookmarked = Auth::user()->hasBookmarked($post);
                    $post->reposted = Auth::user()->hasReposted($post);

                    return $post;
                });
        })->matchOn('id');

        $user->loadCount(['followers', 'posts', 'replies', 'likes']);

        Auth::user()->follows = Auth::user()->follows($user);

        return Inertia::render('Profile/Index', [
            'profile' => $user,
            'posts' => $posts,
        ]);
    }
}
