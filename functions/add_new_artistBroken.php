<?php

session_start();
require '../secrets/spotifySecrets.php';
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
$thisArtist = '4VCZkmckTZMDFU0WsaepBe';
echo $thisArtist;

function addArtist ($thisArtist) {

    echo $thisArtist . '<br>';

    $artist = $GLOBALS['api']->getArtist($thisArtist);

    echo $artist . '<br>';
			
    $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

    if(!$connekt){
        echo 'Fiddlesticks! Could not connect to database.<br>';
    }

    $artistID = $artist->id;
    echo $artistID . '<br>';
    $artistNameYucky = $artist->name;
    $artistName = mysqli_real_escape_string($connekt,$artistNameYucky);
    echo $artistName . '<br>';
    $artistArt = $artist->images[0]->url;
    echo $artistArt . '<br>';
    $artistPop = $artist->popularity;
    echo $artistPop . '<br>';
    $insertArtistsInfo = "INSERT INTO artists (artistID,artistName, artistArt) VALUES('$artistID','$artistName', '$artistArt')";
    $rockout = $connekt->query($insertArtistsInfo);

    if(!$rockout){
        echo 'Cursed-Crap. Could not insert artist ' . $artistName . '<br>';
    }

    $insertArtistsPop = "INSERT INTO popArtists (artistID,pop) VALUES('$artistID','$artistPop')";
    $rockpop = $connekt->query($insertArtistsPop);

    if(!$rockpop){
        echo 'Cursed-Crap. Could not insert artists popularity.<br>';
    }

    else {
        echo 'Their pretty face<br><table><tr><td><img src="' . $artistArt . '"></td></tr><tr><td><td>Their name is ' . $artistName . '</td></tr><tr><td> Current popularity is ' . $artistPop . '</td></tr></table>';
    }
};

addArtist ($thisArtist);
die();

?>