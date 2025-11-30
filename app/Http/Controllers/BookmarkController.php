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
        $posts = Post::query()
            ->whereIn('id', Auth::user()->bookmarks()->pluck('id'))
            ->latest()
            ->simplePaginate(10);

        foreach($posts as $i => $post) {
            $posts[$i]->liked = Auth::user()->likesPost($post);
            $posts[$i]->bookmarked = Auth::user()->hasBookmarked($post);
            $posts[$i]->reposted = Auth::user()->hasReposted($post);
        }

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
