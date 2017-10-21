<?php

session_start();
require 'spotifySecrets.php';
require 'vendor/autoload.php';

$session = new SpotifyWebAPI\Session(
    $myClientID,
    $myClientSecret
);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

// Store the access token 
$_SESSION['accessToken'] = $accessToken;

// Send the user along and fetch some data!
header('Location: app2.php');
die();

?>