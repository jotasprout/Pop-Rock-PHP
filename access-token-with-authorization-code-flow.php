<?php

require 'vendor/autoload.php';

$session = new SpotifyWebAPI\Session(
    'CLIENT_ID',
    'CLIENT_SECRET',
    'REDIRECT_URI'
);

$options = [
    'scope' => [
        'playlist-read-private',
        'user-read-private',
    ],
];

header('Location: ' . $session->getAuthorizeUrl($options));
die();


// Step 2
// When the user has approved your app, Spotify will redirect the user together with a `code` to the specifed redirect URI. You'll need to use this code to request a access token from Spotify and tell the API wrapper about the access token to use, like this:


$session = new SpotifyWebAPI\Session('CLIENT_ID', 'CLIENT_SECRET', 'REDIRECT_URI');
$api = new SpotifyWebAPI\SpotifyWebAPI();

// Request a access token using the code from Spotify
$session->requestAccessToken($_GET['code']);
$accessToken = $session->getAccessToken();

// Set the access token on the API wrapper
$api->setAccessToken($accessToken);

// The API can now be used!
// When requesting a access token, a **refresh token** will also be included. This can be used to extend the validity of access tokens.

## Refreshing an access token
// Start by fetching the refresh token from the Session instance

$refreshToken = $session->getRefreshToken();

// When the access token has expired, request a new one using the refresh token:

$session->refreshAccessToken($refreshToken);

$accessToken = $session->getAccessToken();

// Set our new access token on the API wrapper
$api->setAccessToken($accessToken);


?>