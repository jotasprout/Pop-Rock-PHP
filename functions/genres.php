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
// Do I need this next line?
$baseURL = "https://api.spotify.com/v1/artists/";

$thisArtist = '5a2EaR3hamoenG9rDuVn8j';

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
                echo 'Cursed-Crap. Could not insert genre.<br>';
            } else {
                echo  'Inserted genre of ' . $jsonArtistGenres[$i] . ' for ' . $artistNameYucky . '<br>';
            }
        }  
    }
}

getAndStoreSpotifyGenres ($thisArtist);

die();



function gaddGenresOriginal ($thisArtist) {

    // echo $thisArtist . '<br>';

    $artist = $GLOBALS['api']->getArtist($thisArtist);
    // echo $artist;

    $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

    if(!$connekt){
        echo 'Fiddlesticks! Could not connect to database.<br>';
    }

    $artistID = $artist->id;
    echo $artistID . '<br>';
    $artistNameYucky = $artist->name;
    $artistName = mysqli_real_escape_string($connekt,$artistNameYucky);
    echo $artistName . '<br>';
    //$artistGenres = $artist->genres[0]->url;
    $artistGenresArray = array();

    $jsonArtistGenres = $artist->genres;
    $phpArtistGenres = json_decode($jsonArtistGenres, true);
    // print_r($phpArtistGenres);

    // echo 'First JSON genre is ' . $jsonArtistGenres[0] . '<br>';
    $howmany = (count($jsonArtistGenres));
    echo $artistName . ' has ' . $howmany . ' genres:<br>';

    for ($i=0; $i<(count($jsonArtistGenres)); ++$i) {
        echo $jsonArtistGenres[$i] . '<br>'; 
    }
/*
    foreach ($phpArtistGenres->genres as $genre) {
        echo $genre;	
	
        $insertArtistGenres = "INSERT INTO genres (artistID,genre) VALUES('$artistID','$genre')";

        $rockout = $connekt->query($insertArtistGenres);

        if(!$rockout){
            echo 'Cursed-Crap. Could not insert genre.<br>';
        } else {
            echo $artistName . ' has the genre of ' . $genre . '<br>';
        }

    }
    // echo $artistGenresArray;
 */   

}

?>