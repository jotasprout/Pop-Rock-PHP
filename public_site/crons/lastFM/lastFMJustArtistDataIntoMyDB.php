<?php

require_once '../../rockdb.php';

$filenames = array (
    'data/justDaily_07-06-19.json',
    'data/justDaily_07-07-19.json',
    'data/justDaily_07-08-19.json',
    'data/justDaily_07-09-19.json',
    'data/justDaily_07-10-19.json',
    'data/justDaily_07-11-19.json',
    'data/justDaily_07-12-19.json',
    'data/justDaily_07-13-19.json',
);

$filenames = $filenames;

$x = ceil((count($filenames)));

for ($i=0; $i<$x; ++$i) {

    $jsonFile = $filenames[$i];
    $fileContents = file_get_contents($jsonFile);
    $artistData = json_decode($fileContents,true);
    echo "<p> I found " . $jsonFile . ".</p>";
    
    $dataDate = $artistData['date'];
    $artists = $artistData['myArtists'];
    $artistsNum = ceil((count($artists)));
    
    $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
    
    if(!$connekt){
        echo '<p>Fiddlesticks! Could not connect to database.</p>';
    } else {
    
        for ($j=0; $j<$artistsNum; ++$j) {
            $artist = $artists[$j];
            $artistMBID = $artist['mbid'];
            $artistNameMB = $artist['name'];
            $artistListeners = $artist['stats']['listeners'];
            $artistPlaycount = $artist['stats']['playcount'];
    
            $tryInsertArtistData = "INSERT INTO artistsMB (artistMBID, artistNameMB) VALUES ('$artistMBID', '$artistNameMB')";
    
            $rockin = $connekt->query($tryInsertArtistData);
    
            if(!$rockin){
                echo 'Could not insert ' . $artistNameMB . ' into artistsMB table.<br>';
                }
                else {
                    echo '<p>Inserted ' . $artistNameMB . ' in table.</p>';
                }; 
    
            $insertArtistStats = "INSERT INTO artistsLastFM (artistMBID, dataDate, artistListeners, artistPlaycount) VALUES('$artistMBID','$dataDate','$artistListeners', '$artistPlaycount')";
                
            $rockout = $connekt->query($insertArtistStats);
    
            if(!$rockout){
            echo 'Shickety Brickety! Could not insert stats for ' . $artistNameMB . '.<br>';
            }
            else {
                echo '<p>Inserted ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays for ' . $artistNameMB . ' on ' . $dataDate . '.</p>';
            } 
        }
    };
}

?>