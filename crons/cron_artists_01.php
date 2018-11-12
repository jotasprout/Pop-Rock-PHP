<?php

session_start();
require '../secrets/spotifySecrets.php';
require '../vendor/autoload.php';
require_once '../rockdb.php';
require_once '../functions/artists.php';
require_once '../data_text/artists_arrays.php';

$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

// I don't think the cron needs this next line 
$_SESSION['accessToken'] = $accessToken;
// and I don't think the cron needs this next line either
$accessToken = $_SESSION['accessToken'];

$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

// getArtistsPopCron2 ($allArtists);

divideCombineArtists ($allArtists);

die();

?>