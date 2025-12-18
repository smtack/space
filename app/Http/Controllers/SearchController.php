<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\User;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('q');

        $posts = Inertia::scroll(function () use ($query) {
            return Post::query()
                ->where('message', 'like', '%' . $query . '%')
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(function ($post) {
                    $post->liked = Auth::user()->likesPost($post);
                    $post->bookmarked = Auth::user()->hasBookmarked($post);
                    $post->reposted = Auth::user()->hasReposted($post);

                    return $post;
                });
        })->matchOn('id');

        $users = Inertia::scroll(fn () =>
            User::query()
                ->where('name', 'like', '%' . $query . '%')
                ->orWhere('username', 'like', '%' . $query . '%')
                ->latest()
                ->paginate(10)
                ->withQueryString()
        );

        return Inertia::render('Search', compact('posts', 'users'));
    }
}
