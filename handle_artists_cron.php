<?php

session_start();

require 'vendor/autoload.php';
require_once 'rockdb.php';
require_once 'artists.php';

$accessToken = $_SESSION['accessToken'];

$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

getArtistsPopCron ($artists);
getArtistsPopCron ($nominees2018);

?>