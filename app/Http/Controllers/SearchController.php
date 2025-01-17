<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('q');

        return Inertia::render('Search', [
            'posts' => Post::where('message', 'like', '%' . $query . '%')->latest()->simplePaginate(10)->withQueryString(),
        ]);
    }
}
