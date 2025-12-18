<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class HomeController extends Controller
{
    public function __invoke()
    {
        $posts = Inertia::scroll(function () {
            return Post::query()
                ->whereIn('user_id', Auth::user()->following()->pluck('user_id'))
                ->orWhere('user_id', Auth::user()->id)
                ->latest()
                ->paginate(10)
                ->through(function ($post) {
                    $post->liked = Auth::user()->likesPost($post);
                    $post->bookmarked = Auth::user()->hasBookmarked($post);
                    $post->reposted = Auth::user()->hasReposted($post);
                    
                    return $post;
                });
        })->matchOn('id');

        return Inertia::render('Home', compact('posts'));
    }
}
