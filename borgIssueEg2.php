<?php

$session = new SpotifyWebAPI\Session(CLIENT_ID, CLIENT_SECRET, REDIRECT_URI);

if (isset($_POST['logout'])):
    unset($_SESSION[SESSION]);
endif;

if (isset($_POST['login'])):
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
endif;

if (isset($_GET['code'])):
    $session->requestAccessToken($_GET['code']);
    $_SESSION[SESSION] = $session->getAccessToken();
    header('Location: /');
    die();
endif;

$accessToken = isset($_SESSION[SESSION]) ? $_SESSION[SESSION] : false;

// what is this next line?
// ...

                    if ($accessToken !== false):
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
                            header('Location: /');
                            die();
                        }

                        // Code for showing user info...
                    else:
                        print "<input class=\"btn btn-primary btn-lg\" type=\"submit\" name=\"login\" value=\"Login to Spotify\" />";
                    endif;

?>