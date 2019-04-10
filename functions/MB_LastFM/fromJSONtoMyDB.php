<?php
/*
$filename = $_POST['filename'];
echo $filename;
*/
require_once '../rockdb.php';
require_once '../page_pieces/navbar_rock.php';
require_once '../page_pieces/stylesAndScripts.php';
/*
$artistsMatchSpotifyMBID_Lookup = 'artistsMatchSpotifyMBID';

$artistListenersPlaycount = 'artistListenersPlaycount';
$albumListenersPlaycount = 'albumListenersPlaycount';
$trackListenersPlaycount = 'trackListenersPlaycount';

$relatedAlbums = 'relatedAlbums';
$relatedArtists = 'relatedArtists';
*/
// $jsonFile="../data_text/Anvil_Group_03-01-19.json";

$jsonFile = $filename;

$fileContents = file_get_contents($jsonFile);
$artistData = json_decode($fileContents,true);

$artistMBID = $artistData['mbid'];
$artistName = $artistData['name'];
// Below doesn't work -- find out why
// $artistNameYucky = $artistData['name'];
// $artistName = mysqli_real_escape_string($artistNameYucky);

$dataDate = $artistData['date'];

$artistListeners = $artistData['stats']['listeners'];
$artistPlaycount = $artistData['stats']['playcount'];

echo $artistName . ' had ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays on ' . $dataDate . '.<br>';

$insertArtistStats = "INSERT INTO artistListenersPlaycount (artistMBID, dataDate, artistListeners, artistPlaycount) VALUES('$artistMBID','$dataDate','$artistListeners', '$artistPlaycount')";

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if(!$connekt){
    echo 'Fiddlesticks! Could not connect to database.<br>';
}

$rockout = $connekt->query($insertArtistStats);

if(!$rockout){
echo 'Shickety Brickety! Could not insert stats for ' . $artistName . '.<br>';
}
else {
    echo ' Inserted ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays for ' . $artistName;
} 



$filenames = array ();

$x = ceil((count($filenames)));


for ($i=0; $i<$x; ++$i) {

    
};

?>