<?php

require_once '../rockdb.php';

/*
$artistsMatchSpotifyMBID_Lookup = 'artistsMatchSpotifyMBID';
$artistListenersPlaycount = 'artistListenersPlaycount';
$albumListenersPlaycount = 'albumListenersPlaycount';
$trackListenersPlaycount = 'trackListenersPlaycount';
$relatedAlbums = 'relatedAlbums';
$relatedArtists = 'relatedArtists';
*/

$filenames1 = array (
    '../data_text/jsonLastFM/BuckinghamNicks_Group_03-25-19.json',
    '../data_text/jsonLastFM/DefLeppard_Group_03-25-19.json',
    '../data_text/jsonLastFM/FleetwoodMac_Group_03-25-19.json', 
    '../data_text/jsonLastFM/JanetJackson_Person_03-25-19.json', 
    '../data_text/jsonLastFM/Journey_Group_03-25-19.json', 
    '../data_text/jsonLastFM/LindseyBuckingham_Person_03-25-19.json', 
    '../data_text/jsonLastFM/Radiohead_Group_03-25-19.json', 
    '../data_text/jsonLastFM/RoxyMusic_Group_03-25-19.json', 
    '../data_text/jsonLastFM/StevieNicks_Person_03-25-19.json', 
    '../data_text/jsonLastFM/TheCure_Group_03-25-19.json', 
    '../data_text/jsonLastFM/TheZombies_Group_03-25-19.json'
);


$filenames = $filenames1;

$x = ceil((count($filenames)));

for ($i=0; $i<$x; ++$i) {
    $jsonFile = $filenames[$i];
    $fileContents = file_get_contents($jsonFile);
    $artistData = json_decode($fileContents,true);
    
    $artistMBID = $artistData['mbid'];
    $artistName = $artistData['name'];
    
    $dataDate = $artistData['date'];
    
    $artistListeners = $artistData['stats']['listeners'];
    $artistPlaycount = $artistData['stats']['playcount'];
    
    $insertArtistStats = "INSERT INTO artistsLastFM (artistMBID, dataDate, artistListeners, artistPlaycount) VALUES('$artistMBID','$dataDate','$artistListeners', '$artistPlaycount')";
    
    $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
    
    if(!$connekt){
        echo '<p>Fiddlesticks! Could not connect to database.</p>';
    }
    
    $rockout = $connekt->query($insertArtistStats);
    
    if(!$rockout){
    echo 'Shickety Brickety! Could not insert stats for ' . $artistName . '.<br>';
    }
    else {
        echo '<p>Inserted ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays for ' . $artistName . ' on ' . $dataDate . '.</p>';
    } 
    
};

?>