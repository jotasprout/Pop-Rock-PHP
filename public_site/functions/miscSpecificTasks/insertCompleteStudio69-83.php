<?php

require_once '../rockdb.php';
require_once '../page_pieces/navbar_rock.php';
require_once '../page_pieces/stylesAndScripts.php';

$jsonFile = '../data_text/studioComplete.json';
$fileContents = file_get_contents($jsonFile);
$artistData = json_decode($fileContents,true);

$albumID = $artistData['albumID'];

$tracks = $artistData['tracks'];

$x = ceil((count($tracks)));

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if(!$connekt){
    echo 'Fiddlesticks! Could not connect to database.<br>';
} else {
    for ($i=0; $i<$x; ++$i) {

        $trackID = $tracks[$i]['id'];
        $trackNameYucky = $tracks[$i]['name'];
        $trackName = mysqli_real_escape_string($connekt,$trackNameYucky);
        $insertCompleteStudioTracks = "INSERT INTO tracks (trackID, trackName, albumID) VALUES('$trackID','$trackName','$albumID')";
        $rockout = $connekt->query($insertCompleteStudioTracks);
        if(!$rockout){
        echo 'Shickety Brickety! Could not insert data for ' . $trackName . '.<br>';
        }
        else {
            echo '<p>Inserted track: ' . $trackName . ' \(' . $trackID . '\)</p>';
        }; 
    };
};

/*
$artistListeners = $artistData['stats']['listeners'];
$artistPlaycount = $artistData['stats']['playcount'];
*/

?>