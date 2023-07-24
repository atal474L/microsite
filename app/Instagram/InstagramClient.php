<?php

namespace App\Instagram;

use App\Instagram\Api\Media;
use App\Instagram\Exceptions\InstagramClientException;
use App\Models\SocialMediaAccount;
use Illuminate\Support\Facades\Http;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;

class InstagramClient
{
    private ?string $token;

    public function media(SocialMediaAccount $account): ?Media
    {
        return new Media($this->getAccessToken($account));
    }

    protected function getAccessToken(SocialMediaAccount $account): ?string
    {
        return $account->refresh_token ?? $account->access_token;
    }

    private function getOauthProvider(): GenericProvider
    {
        return new GenericProvider([
            'clientId' => config('instagram.client_id'),
            'clientSecret' => config('instagram.client_secret'),
            'redirectUri' => route(config('instagram.redirect_url')),
            'urlAccessToken' => config('instagram.access_token_url'),
            'urlAuthorize' => config('instagram.authorize_url'),
            'urlResourceOwnerDetails' => '',
            'scopes' => config('instagram.scopes'),
        ]);
    }

    public function getAuthorizationUrl(): string
    {
        return $this->getOauthProvider()->getAuthorizationUrl();
    }

    /**
     * @param string $code
     * @param SocialMediaAccount $account
     * @return string
     * @throws InstagramClientException
     */
    public function requestAccessToken(string $code, SocialMediaAccount $account): string
    {
        try {
            // Get short-lived access token
            $token = $this->getOauthProvider()->getAccessToken('authorization_code', [
                'code' => $code,
            ]);

            $values = $token->getValues();

            if (empty($values['user_id'])) {
                throw new InstagramClientException('Unable to fetch user_id', 2);
            }

            $accesToken = $token->getToken();
            $profileId = (int)$values['user_id'];

            // Get long-lived access token
            $response = Http::get('https://graph.instagram.com/access_token', [
               'grant_type' => 'ig_exchange_token',
                'client_secret' => config('instagram.client_secret'),
                'access_token' => $accesToken,
            ]);

            $token = json_decode($response->body());

            $account = $this->storeToken($account, $profileId, $accesToken, $token->access_token, $token->expires_in);

            return $account->access_token;
        } catch (IdentityProviderException $ex) {
            throw new InstagramClientException('Unable to fetch access token', 1, $ex);
        }
    }

    public function storeToken(SocialMediaAccount $account, int $profileId, string $accessToken, string $refreshToken, int $expires): SocialMediaAccount
    {
        $account->update([
            'profile_id' => $profileId,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires' => $expires,
        ]);

        return $account;
    }
}
