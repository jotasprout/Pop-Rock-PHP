<?php

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

$filenames = array (
    '../data_text/AliceCooper_Combined_03-03-19.json',
    '../data_text/Anvil_Group_03-03-19.json',
    '../data_text/BlackSabbath_Group_03-03-19.json',
    '../data_text/Dio_Group_03-03-19.json', 
    '../data_text/Elf_Group_03-03-19.json', 
    '../data_text/EvilStig_Group_03-03-19.json', 
    '../data_text/Heaven&Hell_Group_03-03-19.json', 
    '../data_text/JoanJett_Combined_03-03-19.json', 
    '../data_text/MeatLoaf_Person_03-03-19.json', 
    '../data_text/MötleyCrüe_Group_03-03-19.json', 
    '../data_text/OzzyOsbourne_Person_03-03-19.json', 
    '../data_text/Queen_Group_03-03-19.json', 
    '../data_text/QuietRiot_Group_03-03-19.json', 
    '../data_text/Rainbow_Group_03-03-19.json', 
    '../data_text/RonnieDioandtheProphets_Group_03-03-19.json', 
    '../data_text/RonnieDioandtheRedCaps_Group_03-03-19.json', 
    '../data_text/Saxon_Group_03-03-19.json', 
    '../data_text/Stoney&Meatloaf_Group_03-03-19.json',
    '../data_text/TedNugent_Person_03-03-19.json', 
    '../data_text/TheAmboyDukes_Group_03-03-19.json',
    '../data_text/TheElectricElves_Group_03-03-19.json', 
    '../data_text/TheRunaways_Group_03-03-19.json'
);

$x = ceil((count($filenames)));

for ($i=0; $i<$x; ++$i) {
    $jsonFile = $filenames[$i];
    $fileContents = file_get_contents($jsonFile);
    $artistData = json_decode($fileContents,true);
    
    $artistMBID = $artistData['mbid'];
    $artistName = $artistData['name'];
    
    $dataDate = $artistData['date'];

    $albums = $artistData['albums'];
    $albumsNum = ceil((count($albums)));

    for ($j=0; $j<$albumsNum; ++$j) {
        $album = $albums[$j];
        $albumMBID = $album['mbid'];
        $albumName = $album['name'];

        $releases = $albums['releases'];
        $releasesNum = ceil((count($releases)));

        for ($k=0; $k<$releasesNum; ++$k){
            $release = $releases[$k];
            $releaseMBID = $release['mbid'];
            $releaseName = $release['name'];

            $tracks = $release['tracks'];
            $tracksNum = ceil((count($tracks)));   
            
            for ($m=0; $m<$tracksNum; ++$m) {
                $track = $tracks[$m];
                $trackMBID = $track['mbid'];
                $trackName = $track['name'];
                $trackListeners = $track['stats']['listeners'];
                $trackPlaycount = $track['stats']['playcount'];
            };
        };
    };
    
    
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
        echo ' Inserted ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays for ' . $artistName . '.<br>';
    } 
    
};

?>