<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
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
