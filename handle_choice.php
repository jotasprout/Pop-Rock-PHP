<?php
session_start();

require 'vendor/autoload.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

$api = new SpotifyWebAPI\SpotifyWebAPI();
$api->setAccessToken($accessToken);

$artistID = $_POST['artist'];

// It's now possible to request data from the Spotify catalog
print_r(
    $api->getArtist($artistID)
);
    

// echo "<script>console.log('artistID is " . $aliceCooper->get_artistID() . " and artistName is " . $aliceCooper->get_artistName() . "')</script>";
// echo "<script>console.log('Case Number " . $assignedCase . " is assigned to " . $username . "')</script>";

?>