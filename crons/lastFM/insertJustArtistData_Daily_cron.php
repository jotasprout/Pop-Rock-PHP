<?php
require_once '../../rockdb.php';
/*
$filename = '';

function makeFilenameForDailyJSON () {
*/
    $baseURL = '/home/roxorsox/public_html/poprock/crons/lastFM/data/justDaily_';
    $today = date("m-d-y");
    $endURL = '.json';
	$filenameForDisplay = $baseURL . $today . $endURL;
    echo "<p>" . $filenameForDisplay . "</p>"; 
	$filename = $baseURL . $today . $endURL;
    echo $filename;  
/*    
};

makeFilenameForDailyJSON ();
*/
$jsonFile = $filename;
$jsonFileForDisplay = $jsonFile;
echo "<p> I found " . $jsonFileForDisplay . ".</p>";

$fileContents = file_get_contents($jsonFile);
$artistData = json_decode($fileContents,true);

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

?>