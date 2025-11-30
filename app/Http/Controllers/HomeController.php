<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class HomeController extends Controller
{
    public function __invoke()
    {
        $posts = Post::query()
            ->whereIn('user_id', Auth::user()->following()->pluck('user_id'))
            ->orWhere('user_id', Auth::user()->id)
            ->latest()
            ->simplePaginate(10);

        foreach($posts as $i => $post) {
            $posts[$i]->liked = Auth::user()->likesPost($post);
            $posts[$i]->bookmarked = Auth::user()->hasBookmarked($post);
            $posts[$i]->reposted = Auth::user()->hasReposted($post);
        }

        return Inertia::render('Home', compact('posts'));
    }
}
