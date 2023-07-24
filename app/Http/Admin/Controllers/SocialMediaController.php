<?php

namespace App\Http\Admin\Controllers;

use App\Http\Admin\Requests\SocialMediaUpdateHashtagRequest;
use App\Http\Controller;
use App\Jobs\SynchronizeInstagramPosts;
use App\Models\SocialMedia;
use App\Models\SocialMediaAccount;
use Illuminate\Http\RedirectResponse;

class SocialMediaController extends Controller
{
    public function index()
    {
        $socialMedias = SocialMedia::all();

        return view('admin.socialMedias.index', [
            'socialMedias' => $socialMedias,
        ]);
    }

    public function update(SocialMediaUpdateHashtagRequest $request, SocialMedia $socialMedia): RedirectResponse
    {
        $socialMedia->update($request->validated());

        return redirect()->route('admin.socialMedias.index');
    }

    public function synchronize(SocialMedia $socialMedia): RedirectResponse
    {
        SynchronizeInstagramPosts::dispatch($socialMedia->accounts()
            ->whereNotNull('profile_id')
            ->whereNotNull('access_token')
            ->get()
            ->each(fn (SocialMediaAccount $account) => $account->setRelation('socialMedia', $socialMedia))
        );

        return redirect()->back();
    }
}
