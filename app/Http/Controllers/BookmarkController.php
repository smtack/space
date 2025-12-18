<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookmarkController extends Controller
{
    public function index()
    {
        $posts = Inertia::scroll(function () {
            return Post::query()
                ->whereIn('id', Auth::user()->bookmarks()->pluck('id'))
                ->latest()
                ->paginate(10)
                ->through(function ($post) {
                    $post->liked = Auth::user()->likesPost($post);
                    $post->bookmarked = Auth::user()->hasBookmarked($post);
                    $post->reposted = Auth::user()->hasReposted($post);

                    return $post;
                });
        })->matchOn('id');

        return Inertia::render('Posts/Bookmarks', compact('posts'));
    }

    public function bookmark(Post $post)
    {
        $user = Auth::user();

        $user->bookmarks()->attach($post);

        return redirect()->back();
    }

    public function removeBookmark(Post $post)
    {
        $user = Auth::user();

        $user->bookmarks()->detach($post);

        return redirect()->back();
    }
}
