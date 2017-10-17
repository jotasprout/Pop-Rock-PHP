<?php

session_start();

require 'vendor/autoload.php';

$session = new SpotifyWebAPI\Session(
    'boogers',
    'snot'
);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

// Store the access token 
$_SESSION['accessToken'] = $accessToken;

// Send the user along and fetch some data!
header('Location: app.php');
die();

?>