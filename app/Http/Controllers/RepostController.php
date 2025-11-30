<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class RepostController extends Controller
{
    public function repost(Post $post)
    {
        $user = Auth::user();

        $user->reposts()->attach($post);

        return redirect()->back();
    }

    public function removeRepost(Post $post)
    {
        $user = Auth::user();

        $user->reposts()->detach($post);

        return redirect()->back();
    }
}
