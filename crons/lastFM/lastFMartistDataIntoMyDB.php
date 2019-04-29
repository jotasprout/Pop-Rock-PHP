<?php

/*
$artistsMatchSpotifyMBID_Lookup = 'artistsMatchSpotifyMBID';
$artistListenersPlaycount = 'artistListenersPlaycount';
$albumListenersPlaycount = 'albumListenersPlaycount';
$trackListenersPlaycount = 'trackListenersPlaycount';
$relatedAlbums = 'relatedAlbums';
$relatedArtists = 'relatedArtists';
*/

require_once '../../rockdb.php';

$filenames = array (
    'data/AliceCooper_Combined_04-29-19.json',
    'data/Anvil_Group_04-29-19.json',
    'data/BlackSabbath_Group_04-29-19.json',
    'data/LindseyBuckingham_Person_04-29-19.json',
    'data/DefLeppard_Group_04-29-19.json',
    'data/Dio_Group_04-29-19.json', 
    'data/Elf_Group_04-29-19.json', 
    'data/EvilStig_Group_04-29-19.json', 
    'data/FleetwoodMac_Group_04-29-19.json',
    'data/Heaven&Hell_Group_04-29-19.json', 
    'data/JanetJackson_Person_04-29-19.json', 
    'data/JoanJett_Combined_04-29-19.json', 
    'data/Journey_Group_04-29-19.json', 
    'data/MeatLoaf_Person_04-29-19.json', 
    'data/MötleyCrüe_Group_04-29-19.json', 
    'data/StevieNicks_Person_04-29-19.json',
    'data/OzzyOsbourne_Person_04-29-19.json', 
    'data/Queen_Group_04-29-19.json', 
    'data/QuietRiot_Group_04-29-19.json', 
    'data/Radiohead_Group_04-29-19.json',
    'data/Rainbow_Group_04-29-19.json', 
    'data/RonnieDioandtheProphets_Group_04-29-19.json', 
    'data/RonnieDioandtheRedCaps_Group_04-29-19.json', 
    'data/RoxyMusic_Group_04-29-19.json',
    'data/Saxon_Group_04-29-19.json', 
    'data/Stoney&Meatloaf_Group_04-29-19.json',
    'data/TedNugent_Person_04-29-19.json', 
    'data/TheAmboyDukes_Group_04-29-19.json',
    'data/TheCure_Group_04-29-19.json',
    'data/TheElectricElves_Group_04-29-19.json', 
    'data/TheRunaways_Group_04-29-19.json',
    'data/TheZombies_Group_04-29-19.json'
);

$filenames = $filenames;

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