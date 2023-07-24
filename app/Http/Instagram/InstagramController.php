<?php

namespace App\Http\Instagram;

use App\Instagram\Exceptions\InstagramClientException;
use App\Instagram\InstagramClient;
use App\Models\SocialMediaAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InstagramController
{
    private const SESSION_ACCOUNT_ID = 'social_media_account_id';

    public function login(Request $request, InstagramClient $client, SocialMediaAccount $account)
    {
        $request->session()->flash(static::SESSION_ACCOUNT_ID, $account->id);

        return redirect($client->getAuthorizationUrl());
    }

    /**
     * @throws InstagramClientException
     */
    public function redirect(Request $request, InstagramClient $client): RedirectResponse
    {
        if (!$request->has('code')) {
            return redirect()->route('index'); // @todo error handeling
        }

        $account = SocialMediaAccount::findOrFail($request->session()->get(static::SESSION_ACCOUNT_ID));

        $client->requestAccessToken($request->get('code'), $account);

        return redirect()->route('admin.index');
    }
}
