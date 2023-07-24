<?php

namespace App\Http\Admin\Controllers;

use App\Actions\ResizePhotoAction;
use App\Http\Admin\Requests\PostStoreRequest;
use App\Http\Controller;
use App\Models\Photo;
use App\Models\Post;
use App\Models\SocialMediaAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Image\Exceptions\InvalidManipulation;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('photos', 'socialMediaAccount')
            ->whereHas('photos')
            ->whereRelation('socialMediaAccount', 'user_id', $request->user()->id)
            ->orderByDesc('posted_at')
            ->get();

        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }

    public function create(SocialMediaAccount $account)
    {
        return view('admin.posts.create', [
            'account' => $account,
        ]);
    }

    /**
     * @throws InvalidManipulation
     */
    public function store(PostStoreRequest $request, SocialMediaAccount $account, ResizePhotoAction $resizeImageAction): RedirectResponse
    {
        /** @var Post $post */
        $post = $account->posts()->create([
            'type' => count($request->file('images')) > 1 ? 'CAROUSEL_ALBUM' : 'PHOTO',
            'caption' => $request->caption ?? null,
            'posted_at' => $request->posted_at ?? now(),
        ]);

        foreach ($request->file('images') as $file)
        {
            /** @var Photo $photo */
            $photo = $post->photos()->create([
                'path' => $file->storeAs('', time() . '_' . pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $file->extension(), ['disk' => 'posts']),
            ]);

            $resizeImageAction($photo);
        }

        return redirect()->route('admin.index');
    }

    public function destroy(SocialMediaAccount $account, Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->back();
    }
}
