<?php
session_start();

require 'vendor/autoload.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

$api = new SpotifyWebAPI\SpotifyWebAPI();
$api->setAccessToken($accessToken);

$artistID = $_POST['artist'];

// It's now possible to request data from the Spotify catalog
    
$artist = $api->getArtist($artistID);
$artistName = $artist->name;
$artistPop = $artist->popularity;

echo "<script>console.log('artist Name is " . $artistName . " and artist popularity is " . $artistPop . "')</script>";

?>