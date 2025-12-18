<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LikeController extends Controller
{
    public function index()
    {
        $posts = Inertia::scroll(function () {
            return Post::query()
                ->whereIn('id', Auth::user()->likes()->pluck('id'))
                ->latest()
                ->paginate(10)
                ->through(function ($post) {
                    $post->liked = Auth::user()->likesPost($post);
                    $post->bookmarked = Auth::user()->hasBookmarked($post);
                    $post->reposted = Auth::user()->hasReposted($post);

                    return $post;
                });
        })->matchOn('id');

        return Inertia::render('Posts/Likes', compact('posts'));
    }

    public function like(Post $post)
    {
        $user = Auth::user();

        $user->likes()->attach($post);

        return redirect()->back();
    }

    public function unlike(Post $post)
    {
        $user = Auth::user();

        $user->likes()->detach($post);

        return redirect()->back();
    }
}
