<?php
session_start();
require '../secrets/MBifySecrets.php';
// require '../secrets/auth.php';
require '../vendor/autoload.php';
require_once '../rockdb.php';
require_once '../functions/artists.php';
// require_once '../data_text/artists_arrays_objects.php';
$session = new MBifyWebAPI\Session($myClientID, $myClientSecret);
$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();
// I don't think the cron needs this next line 
$_SESSION['accessToken'] = $accessToken;
// and I don't think the cron needs this next line either
$accessToken = $_SESSION['accessToken'];
$GLOBALS['api'] = new MBifyWebAPI\MBifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);
$baseURL = "https://api.MBify.com/v1/artists/";

$artistMBID = $_POST['artistMBID'];
// $thisArtist = '3D4qYDvoPn5cQxtBm4oseo';

function addArtistMB ($thisArtist) {

    $artist = $GLOBALS['api']->getArtist($thisArtist);
			
    $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

    if(!$connekt){
        echo 'Fiddlesticks! Could not connect to database.<br>';
    }

    $artistMBID = $artist->id;
    // echo $artistMBID;
    $artistNameYucky = $artist->name;
    $artistNameMB = mysqli_real_escape_string($connekt,$artistNameYucky);
    // echo $artistName;
    $artistArtMB = $artist->images[0]->url;
    // echo $artistArt;
    $artistPop = $artist->popularity;
    // echo $artistPop;
    $artistInfo = '{"artistMBID": "' . $artistMBID . '", "artistNameMB": "' . $artistNameMB . '", "artistArtMB": "' . $artistArtMB . '", "artistPop": "' . $artistPop . '"}';

    $insertArtistsInfo = "INSERT INTO artistsMB (artistMBID, artistNameMB, artistArtMB) VALUES('$artistMBID', '$artistNameMB', '$artistArtMB')";

    $rockout = $connekt->query($insertArtistsInfo);

    if(!$rockout){
        echo 'Cursed-Crap. Could not insert artist ' . $artistNameMB . '.<br>';
    }
    
    $insertArtistsPop = "INSERT INTO popArtists (artistMBID,pop) VALUES ('$artistMBID','$artistPop')";
    
    $rockpop = $connekt->query($insertArtistsPop);
    
    if(!$rockpop){
        echo 'Cursed-Crap. Could not insert artists popularity.';
    } else {
        echo json_encode($artist);
    };
};

addArtistMB ($thisArtistMBID);

die();

?>