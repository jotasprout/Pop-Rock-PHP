<?php

session_start();

require '../secrets/spotifySecrets.php';
require '../vendor/autoload.php';
require_once '../rockdb.php';
require_once '../functions/artists.php';
require_once '../data_text/artists_arrays_objects.php';

$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);
$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();
// I don't think the cron needs this next line 
$_SESSION['accessToken'] = $accessToken;
// and I don't think the cron needs this next line either
$accessToken = $_SESSION['accessToken'];
$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);
$baseURL = "https://api.spotify.com/v1/artists/";

$thisArtist = '3D4qYDvoPn5cQxtBm4oseo';

function addGenres ($thisArtist) {

    echo $thisArtist . '<br>';

    $artist = $GLOBALS['api']->getArtist($thisArtist);

    $artistID = $artist->id;
    // echo $artistID;
    $artistNameYucky = $artist->name;
    $artistName = mysqli_real_escape_string($connekt,$artistNameYucky);
    echo $artistName . '<br>';
    //$artistGenres = $artist->genres[0]->url;
    // $artistGenresArray = array();

    $thisArtistGenres = $artist->genres;
    echo $thisArtistGenres . '<br>';

    foreach ($thisArtistGenres->genres as $genre) {
				
        $insertArtistGenres = "INSERT INTO genres (artistID,genre) VALUES('$artistID','$genre')";

        $rockout = $connekt->query($insertArtistGenres);

        if(!$rockout){
            echo 'Cursed-Crap. Could not insert genre.<br>';
        } else {
            echo $artistName . ' has the genre of ' . $genre . '<br>';
        }
    }
}

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if(!$connekt){
    echo 'Fiddlesticks! Could not connect to database.<br>';
} else {
    addGenres ($thisArtist);
}

die();

?>