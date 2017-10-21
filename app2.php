<?php
session_start();

require 'vendor/autoload.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

$api = new SpotifyWebAPI\SpotifyWebAPI();
$api->setAccessToken($accessToken);

// It's now possible to request data from the Spotify catalog
print_r(
    $api->getArtist('3EhbVgyfGd7HkpsagwL9GS')
);

// as always, starting off dev with Alice Cooper for testing
$artistID = '3EhbVgyfGd7HkpsagwL9GS';

$artistName = '';
$artistPop = '';
$artistAlbumsURL = '';
$artistAlbums = array ();
$artistAlbumsStr = '';
$albumArray = '';
$albumsArrays = array ();
$severalAlbumsURL = '';

$albumID = '';
$albumName = '';
$albumReleased = '';
$albumPop = '';
$albumTracks = array ();
$trackID = '';
$trackName = '';
$trackPop = '';

$albumTracksURL = '';
$albumTracksIDs = array ();

?>