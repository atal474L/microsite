<?php

return [
    /*
     * The client_id from registering your app on Instagram
     */
    'client_id' => env('INSTAGRAM_CLIENT_ID'),

    /*
     * The client secret from registering your app on Instagram,
     * This is not the same as an access token.
     */
    'client_secret' => env('INSTAGRAM_CLIENT_SECRET'),

    'access_token_url' => 'https://api.instagram.com/oauth/access_token',

    'authorize_url' => 'https://api.instagram.com/oauth/authorize',

    'scopes' => 'user_profile, user_media',

    /*
     * The base url used to generate to auth callback route for instagram.
     * This defaults to your APP_URL, so normally you may leave it as null
     */
    'base_url' => 'https://graph.instagram.com',

    'version' => 'v3.2',

    /*
     * The route that will respond to the Instagram callback during the OAuth process.
     * Only enter the path without the leading slash. You need to ensure that you have registered
     * a redirect_uri for your instagram app that is equal to combining the
     *  app url (from config) and this route
     */
    //'auth_callback_route' => route('instagram.callback'),

    /*
     * On success of the OAuth process you will be redirected to this route.
     * You may use query strings to carry messages
     */
    'redirect_url' => 'instagram.redirect',
];
