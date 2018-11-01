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
// Do I need this next line?
$baseURL = "https://api.spotify.com/v1/artists/";

// $thisArtist = '5a2EaR3hamoenG9rDuVn8j';

function getAndStoreSpotifyGenres ($thisArtist) {
    $artist = $GLOBALS['api']->getArtist($thisArtist);
    $artistID = $artist->id;
    $artistNameYucky = $artist->name;
    $artistName = mysqli_real_escape_string($connekt,$artistNameYucky);
    $jsonArtistGenres = $artist->genres;
    $howmany = (count($jsonArtistGenres));
    echo $artistNameYucky . ' has ' . $howmany . ' genres:<br>';
    for ($i=0; $i<(count($jsonArtistGenres)); ++$i) {
        echo $jsonArtistGenres[$i] . '<br>'; 
    };  
    addGenres ($artistID, $jsonArtistGenres, $artistNameYucky);
}

function getAndStoreSpotifyGenresForAllArtists ($alltheseArtists) {
    for ($i=0; $i<(count($alltheseArtists)); ++$i) {
        getAndStoreSpotifyGenres ($alltheseArtists[$i]);
    };  
}

function addGenres ($artistID, $jsonArtistGenres, $artistNameYucky) {

    $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

    if(!$connekt){
        echo 'Fiddlesticks! Could not connect to database.<br>';
    } else {
        echo 'Yay! We are connected to the database!<br>';

        for ($i=0; $i<(count($jsonArtistGenres)); ++$i) {
            $insertArtistGenres = "INSERT INTO genres (artistID,genre) VALUES('$artistID','$jsonArtistGenres[$i]')";

            $rockout = $connekt->query($insertArtistGenres);

            if(!$rockout){
                echo 'Cursed-Crap! Could NOT insert genre of ' . $jsonArtistGenres[$i] . ' for <b>' . $artistNameYucky . '</b>.<br>';
            } else {
                echo  'Inserted genre of ' . $jsonArtistGenres[$i] . ' for <b>' . $artistNameYucky . '</b>.<br>';
            }
        }  
    }
}

// getAndStoreSpotifyGenresForAllArtists ($allArtists);

die();

?>