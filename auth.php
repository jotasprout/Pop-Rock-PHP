<?php

session_start();
require 'spotifySecrets.php';
require 'vendor/autoload.php';

$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

// Store access token 
// $_SESSION['accessToken'] = $accessToken;
// the above line worked in auth8, auth9, and authX

$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

// Rock on!
// header('Location: choose_artist.php');
die();

?>