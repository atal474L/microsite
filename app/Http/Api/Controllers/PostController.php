<?php

namespace App\Http\Api\Controllers;

use App\Dtos\PostDto;
use App\Http\Controller;
use App\Models\Post;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    use ApiResponseHelpers;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->respondWithSuccess(Post::with('photos', 'user')
            ->whereHas('photos')
            ->whereHas('user')
            ->orderByDesc('posted_at')
            ->get()
            ->map(fn (Post $post) => PostDto::fromPost($post))
            ->groupBy(fn (PostDto $post) => $post->posted_at->toDateString())
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function show(Post $post): JsonResponse
    {
        return $this->respondWithSuccess(PostDto::fromPost($post->loadMissing('photos', 'user'))
            ->toArray()
        );
    }
}
