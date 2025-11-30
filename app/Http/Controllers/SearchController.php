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

        $posts = Post::query()
            ->where('message', 'like', '%' . $query . '%')
            ->latest()
            ->simplePaginate(10)
            ->withQueryString();

        foreach($posts as $i => $post) {
            $posts[$i]->liked = Auth::user()->likesPost($post);
            $posts[$i]->bookmarked = Auth::user()->hasBookmarked($post);
            $posts[$i]->reposted = Auth::user()->hasReposted($post);
        }

        $users = User::query()
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('username', 'like', '%' . $query . '%')
            ->latest()
            ->simplePaginate(10)
            ->withQueryString();

        return Inertia::render('Search', compact('posts', 'users'));
    }
}
