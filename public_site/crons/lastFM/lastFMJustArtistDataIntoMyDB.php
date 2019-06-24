<?php

require_once '../../rockdb.php';

$filenames = array (
    'data/justDaily_06-23-19.json',
    'data/justDaily_06-24-19.json'
	/*
    'data/justDaily_06-03-19.json',
    'data/justDaily_06-04-19.json',
    'data/justDaily_06-05-19.json',
    'data/justDaily_06-06-19.json',
    'data/justDaily_06-07-19.json',
    'data/justDaily_06-08-19.json',
	'data/justDaily_06-09-19.json',
    'data/justDaily_06-10-19.json',
    'data/justDaily_06-11-19.json',
    'data/justDaily_06-12-19.json',
    'data/justDaily_06-13-19.json',
    'data/justDaily_06-14-19.json',
    'data/justDaily_06-15-19.json',
    'data/justDaily_06-16-19.json',
    'data/justDaily_06-17-19.json',
    'data/justDaily_06-18-19.json'
	*/

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
            $artistName = $artist['name'];
            $artistListeners = $artist['stats']['listeners'];
            $artistPlaycount = $artist['stats']['playcount'];
    
            $tryInsertArtistData = "INSERT INTO artistsMB (artistMBID, artistName) VALUES ('$artistMBID', '$artistName')";
    
            $rockin = $connekt->query($tryInsertArtistData);
    
            if(!$rockin){
                echo 'Could not insert ' . $artistName . ' into artistsMB table.<br>';
                }
                else {
                    echo '<p>Inserted ' . $artistName . ' in table.</p>';
                }; 
    
            $insertArtistStats = "INSERT INTO artistsLastFM (artistMBID, dataDate, artistListeners, artistPlaycount) VALUES('$artistMBID','$dataDate','$artistListeners', '$artistPlaycount')";
                
            $rockout = $connekt->query($insertArtistStats);
    
            if(!$rockout){
            echo 'Shickety Brickety! Could not insert stats for ' . $artistName . '.<br>';
            }
            else {
                echo '<p>Inserted ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays for ' . $artistName . ' on ' . $dataDate . '.</p>';
            } 
        }
    };
}

?>