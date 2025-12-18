<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
            'message' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        if($request->image) {
            $request->file('image')->store('images', 'public');
        }

        $filename = ($request->image) ? $request->image->hashName() : null;

        $request->user()->posts()->create([
            'message' => $validated['message'],
            'image' => $filename,
        ]);

        return redirect(route('home'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->liked = Auth::user()->likesPost($post);
        $post->bookmarked = Auth::user()->hasBookmarked($post);
        $post->reposted = Auth::user()->hasReposted($post);

        $replies = Inertia::scroll(fn () =>
            Reply::query()
                ->where('post_id', '=', $post->id)
                ->latest()
                ->paginate(10)
        );

        return Inertia::render('Posts/Show', [
            'post' => $post,
            'replies' => $replies,
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
            'message' => 'required|string|max:500',
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

        if($post->image) {
            $path = 'storage/images/' . $post->image;

            if(File::exists($path)) {
                File::delete($path);
            }
        }

        $post->delete();

        return redirect(route('home'));
    }
}
