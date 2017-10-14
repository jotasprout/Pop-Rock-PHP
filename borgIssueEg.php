<?php

define('CLIENT_ID', 'xxxxxxxxxxxxxxxxxxxxxx');
define('CLIENT_SECRET', 'xxxxxxxxxxxxxxxxxxxxxxxx');
define('REDIRECT_URI', "http" . (!empty($_SERVER['HTTPS']) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']);
define('SESSION', 'spotify_access_token');

...

$session = new SpotifyWebAPI\Session(CLIENT_ID, CLIENT_SECRET, REDIRECT_URI);

if (isset($_GET['code'])):
    $session->requestAccessToken($_GET['code']);
    $accessToken = $session->getAccessToken();
    $_SESSION[SESSION] = $accessToken;
    header('Location: index.php');
    die();
elseif (!isset($_SESSION[SESSION])):
    $options = ['scope' =>
        [
            'user-read-private',
            'user-read-email',
            'user-read-birthdate',
            'user-top-read',
            'playlist-read-private',
            'playlist-modify-private',
            'playlist-read-collaborative',
            'playlist-modify-public',
            'ugc-image-upload'
        ]
    ];
    header('Location: ' . $session->getAuthorizeUrl($options));
    die();
else:
    $accessToken = $_SESSION[SESSION];
endif;

try {
    $api = new SpotifyWebAPI\SpotifyWebAPI();
    $api->setAccessToken($accessToken);
    $api->setReturnType(SpotifyWebAPI\SpotifyWebAPI::RETURN_ASSOC);

    $me = $api->me();
    $userName = $me['display_name'];
    $userId = $me['id'];
    $userPicture = $me['images'][0]['url'];
}
catch (Exception $ex) {
    unset($_SESSION[SESSION]);
    header('Location: index.php');
    die();
}


?>