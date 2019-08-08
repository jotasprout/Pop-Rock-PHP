<?php
session_start();
require '../secrets/spotifySecrets.php';
// require '../secrets/auth.php';
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

function addArtist ($thisArtist) {

    $artist = $GLOBALS['api']->getArtist($thisArtist);
			
    $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

    if(!$connekt){
        echo 'Fiddlesticks! Could not connect to database.<br>';
    }

    $artistSpotID = $artist->id;
    // echo $artistSpotID;
    $artistNameYucky = $artist->name;
    $artistNameSpot = mysqli_real_escape_string($connekt,$artistNameYucky);
    // echo $artistName;
    $artistArtSpot = $artist->images[0]->url;
    // echo $artistArt;
    $artistPop = $artist->popularity;
    // echo $artistPop;
    $artistInfo = '{"artistSpotID": "' . $artistSpotID . '", "artistNameSpot": "' . $artistNameSpot . '", "artistArtSpot": "' . $artistArtSpot . '", "artistPop": "' . $artistPop . '"}';

    $insertArtistsInfo = "INSERT INTO artistsSpot (artistSpotID,artistNameSpot, artistArtSpot) VALUES('$artistSpotID','$artistNameSpot', '$artistArtSpot')";

    $rockout = $connekt->query($insertArtistsInfo);

    if(!$rockout){
        echo 'Cursed-Crap. Could not insert artist ' . $artistNameSpot . '.<br>';
    }
    $insertArtistsPop = "INSERT INTO popArtists (artistSpotID,pop) VALUES('$artistSpotID','$artistPop')";
    $rockpop = $connekt->query($insertArtistsPop);
    if(!$rockpop){
        echo 'Cursed-Crap. Could not insert artists popularity.';
    }
   else {
     echo json_encode($artist);
   }
};

addArtist ($thisArtist);

die();

?>