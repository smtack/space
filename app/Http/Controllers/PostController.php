<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->simplePaginate(10);

        foreach($posts as $i => $post) {
            $posts[$i]->liked = Auth::user()->likesPost($post);
        }

        return Inertia::render('Posts/Index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:300',
        ]);

        $request->user()->posts()->create($validated);

        return redirect(route('home'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->liked = Auth::user()->likesPost($post);

        return Inertia::render('Posts/Show', [
            'post' => $post,
            'replies' => Reply::query()
                ->where('post_id', '=', $post->id)
                ->latest()
                ->simplePaginate(10),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        Gate::authorize('update', $post);

        $validated = $request->validate([
            'message' => 'required|string|max:300',
        ]);

        $post->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect(route('home'));
    }
}
