<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExploreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $posts = Inertia::scroll(function () {
            return Post::query()
                ->latest()
                ->paginate(10)
                ->through(function($post) {
                    $post->liked = Auth::user()->likesPost($post); 
                    $post->bookmarked = Auth::user()->hasBookmarked($post);
                    $post->reposted = Auth::user()->hasReposted($post);
                    
                    return $post;
                });
        })->matchOn('id');

        return Inertia::render('Explore', compact('posts'));
    }
}
