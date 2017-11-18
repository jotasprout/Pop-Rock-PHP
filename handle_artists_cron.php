<?php

session_start();
require 'spotifySecrets.php';
require 'vendor/autoload.php';
require_once 'rockdb.php';
require_once 'artists.php';

$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

// I don't think the cron needs this next line 
$_SESSION['accessToken'] = $accessToken;
// and I don't think the cron needs this next line either
$accessToken = $_SESSION['accessToken'];

$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

getArtistsPopCron ($artists);
getArtistsPopCron ($nominees2018);

die();

?>