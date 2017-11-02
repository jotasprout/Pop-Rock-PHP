<?php

require 'spotifySecrets.php';
require 'vendor/autoload.php';

$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

// Store access token 
$_SESSION['accessToken'] = $accessToken;

// Rock on!
die();

?>