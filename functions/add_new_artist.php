<?php

session_start();
// require '../secrets/spotifySecrets.php';
require '../secrets/auth.php';
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

// $artistID = $_POST['artist'];
$thisArtist = '20ge6LnG4KYzVj0Ecj7yDv';
echo $thisArtist;



function addArtist ($thisArtist) {

    echo $thisArtist;

    $artist = $GLOBALS['api']->getArtist($thisArtist);
			
    $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

    if(!$connekt){
        echo 'Fiddlesticks! Could not connect to database.<br>';
    }

    $artistID = $artist->id;
    echo $artistID;
    $artistNameYucky = $artist->name;
    $artistName = mysqli_real_escape_string($connekt,$artistNameYucky);
    echo $artistName;
    $artistArt = $artist->images[0]->url;
    echo $artistArt;
    $artistPop = $artist->popularity;
    echo $artistPop;
    $insertArtistsInfo = "INSERT INTO artists (artistID,artistName, artistArt) VALUES('$artistID','$artistName', '$artistArt')";
    $rockout = $connekt->query($insertArtistsInfo);

    if(!$rockout){
        echo 'Cursed-Crap. Could not insert artist ' . $artistName . '.<br>';
    }

    $insertArtistsPop = "INSERT INTO popArtists (artistID,pop) VALUES('$artistID','$artistPop')";
    $rockpop = $connekt->query($insertArtistsPop);

    if(!$rockpop){
        echo 'Cursed-Crap. Could not insert artists popularity.';
    }

    else {
        echo '<tr><td>' . $artistArt . '</td><td>' . $artistName . '</td><td>' . $artistPop . '</td></tr>';
    }
};

addArtist ($thisArtist);
die();

?>