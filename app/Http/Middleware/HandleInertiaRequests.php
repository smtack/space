<?php

namespace App\Http\Middleware;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'appName' => 'Space',
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
            'topUsers' => Cache::remember('topUsers', now()->addMinutes(10), function() {
                return User::query()
                    ->select('name', 'username', 'avatar')
                    ->withCount('followers')
                    ->orderBy('followers_count', 'DESC')
                    ->limit(3)
                    ->get()
                    ->toArray();
            }),
            'trendingTopics' => Cache::remember('trendingTopics', now()->addMinutes(1), function() {
                $posts = Post::query()
                    ->where('created_at', '>=', now()->subHours(12))
                    ->get(['message']);
                
                $wordCounts = [];

                $stopWords = [
                    'the', 'and', 'for', 'are', 'but', 'not', 'you',
                    'your', 'with', 'this', 'that', 'have', 'was',
                    'were', 'from', 'they', 'their', 'what', 'when',
                    'where', 'will', 'would', 'could', 'should',
                    'has', 'had', 'his', 'her', 'she', 'him',
                    'its', 'our', 'out', 'all', 'can', 'get',
                    'got', 'just', 'about', 'into', 'been', 'who',
                    'how', 'why', 'than', 'then', 'there', 'here',
                    'some', 'more', 'one', 'too', 'very', 'like',
                    'don', 'does', 'did', 'doesn', 'isn', 'wasn',
                ];

                foreach ($posts as $post) {
                    preg_match_all(
                        '/[\p{L}\p{N}]{3,}/u',
                        Str::lower($post->message),
                        $matches
                    );

                    $uniqueWords = array_unique($matches[0]);

                    foreach ($uniqueWords as $word) {
                        if (in_array($word, $stopWords) || is_numeric($word)) {
                            continue;
                        }

                        $wordCounts[$word] = ($wordCounts[$word] ?? 0) + 1;
                    }
                }

                arsort($wordCounts);

                return collect($wordCounts)
                    ->take(5)
                    ->map(function ($count, $word) {
                        return [
                            'name' => $word,
                            'count' => $count,
                        ];
                    })
                    ->values()
                    ->toArray();
            }),
        ];
    }
}
