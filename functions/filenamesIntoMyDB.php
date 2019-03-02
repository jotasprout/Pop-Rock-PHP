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

$filenames = array ('../data_text/BlackSabbath_02-28-19.json', '../data_text/BlackSabbath_02-27-19.json', '../data_text/BlackSabbath_02-26-19.json', '../data_text/BlackSabbath_02-25-19.json', '../data_text/BlackSabbath_02-24-19.json', '../data_text/BlackSabbath_02-22-19.json', '../data_text/BlackSabbath_02-21-19.json', '../data_text/BlackSabbath_02-17-19.json');

$filenamesKindaBroken = array ('../data_text/BlackSabbath_Group_03-01-19.json', '../data_text/BlackSabbath_Group_02-28-19.json', '../data_text/BlackSabbath_Group_02-27-19.json', '../data_text/BlackSabbath_Group_02-26-19.json', '../data_text/BlackSabbath_Group_02-25-19.json', '../data_text/BlackSabbath_Group_02-24-19.json', '../data_text/BlackSabbath_Group_02-22-19.json', '../data_text/BlackSabbath_Group_02-21-19.json', '../data_text/BlackSabbath_Group_02-17-19.json', '../data_text/Dio_Group_03-01-19.json', '../data_text/Dio_02-28-19.json', '../data_text/Dio_02-27-19.json', '../data_text/Dio_02-26-19.json', '../data_text/Dio_02-25-19.json', '../data_text/Dio_02-24-19.json', '../data_text/Dio_02-22-19.json', '../data_text/Dio_02-21-19.json', '../data_text/Dio_02-17-19.json', '../data_text/Elf_Group_03-01-19.json', '../data_text/Elf_02-28-19.json', '../data_text/Elf_02-27-19.json', '../data_text/Elf_02-26-19.json', '../data_text/Elf_02-25-19.json', '../data_text/Elf_02-24-19.json', '../data_text/Elf_02-22-19.json', '../data_text/Elf_02-21-19.json', '../data_text/Elf_02-17-19.json', '../data_text/EvilStig_Group_03-01-19.json', '../data_text/EvilStig_02-28-19.json', '../data_text/EvilStig_02-27-19.json', '../data_text/EvilStig_02-26-19.json', '../data_text/EvilStig_02-25-19.json', '../data_text/EvilStig_02-24-19.json', '../data_text/EvilStig_02-22-19.json', '../data_text/EvilStig_02-21-19.json', '../data_text/EvilStig_02-17-19.json', '../data_text/EvilStig_021619.json', '../data_text/Heaven&Hell_Group_03-01-19.json', '../data_text/Heaven&Hell_02-28-19.json', '../data_text/Heaven&Hell_02-27-19.json', '../data_text/Heaven&Hell_02-26-19.json', '../data_text/Heaven&Hell_02-25-19.json', '../data_text/Heaven&Hell_02-24-19.json', '../data_text/Heaven&Hell_02-22-19.json', '../data_text/Heaven&Hell_02-21-19.json', '../data_text/Heaven&Hell_02-17-19.json', '../data_text/MeatLoaf_Person_03-01-19.json', '../data_text/MeatLoaf_02-28-19.json', '../data_text/MeatLoaf_02-27-19.json', '../data_text/MeatLoaf_02-26-19.json', '../data_text/MeatLoaf_02-25-19.json', '../data_text/MeatLoaf_02-24-19.json', '../data_text/MeatLoaf_02-22-19.json', '../data_text/MeatLoaf_02-21-19.json', '../data_text/MeatLoaf_02-17-19.json', '../data_text/MötleyCrüe_Group_03-01-19.json', '../data_text/MötleyCrüe_02-28-19.json', '../data_text/MötleyCrüe_02-27-19.json', '../data_text/MötleyCrüe_02-25-19.json', '../data_text/OzzyOsbourne_Person_03-01-19.json', '../data_text/OzzyOsbourne_02-28-19.json', '../data_text/OzzyOsbourne_02-27-19.json', '../data_text/OzzyOsbourne_02-26-19.json', '../data_text/OzzyOsbourne_02-25-19.json', '../data_text/OzzyOsbourne_02-24-19.json', '../data_text/OzzyOsbourne_02-22-19.json', '../data_text/OzzyOsbourne_02-21-19.json', '../data_text/OzzyOsbourne_02-17-19.json', '../data_text/Queen_Group_03-01-19.json', '../data_text/Queen_02-28-19.json', '../data_text/Queen_02-27-19.json', '../data_text/Queen_02-25-19.json', '../data_text/QuietRiot_Group_03-01-19.json', '../data_text/QuietRiot_02-28-19.json', '../data_text/Rainbow_Group_03-01-19.json', '../data_text/Rainbow_02-28-19.json', '../data_text/Rainbow_02-27-19.json', '../data_text/Rainbow_02-26-19.json', '../data_text/Rainbow_02-25-19.json', '../data_text/Rainbow_02-24-19.json', '../data_text/Rainbow_02-22-19.json', '../data_text/Rainbow_02-21-19.json', '../data_text/Rainbow_02-17-19.json', '../data_text/TedNugent_Person_03-01-19.json', '../data_text/TedNugent_02-28-19.json', '../data_text/TedNugent_02-27-19.json', '../data_text/TedNugent_02-26-19.json', '../data_text/TedNugent_02-25-19.json', '../data_text/TedNugent_02-24-19.json', '../data_text/TedNugent_02-22-19.json', '../data_text/TedNugent_02-21-19.json', '../data_text/TedNugent_02-17-19.json', '../data_text/TheAmboyDukes_Group_03-01-19.json', '../data_text/TheAmboyDukes_02-28-19.json', '../data_text/TheAmboyDukes_02-27-19.json', '../data_text/TheAmboyDukes_02-26-19.json', '../data_text/TheAmboyDukes_02-25-19.json', '../data_text/TheAmboyDukes_02-24-19.json', '../data_text/TheAmboyDukes_02-22-19.json', '../data_text/TheAmboyDukes_02-21-19.json', '../data_text/TheAmboyDukes_02-17-19.json', '../data_text/Saxon_Group_03-01-19.json', '../data_text/Saxon_02-28-19.json', '../data_text/Saxon_02-27-19.json', '../data_text/Saxon_02-26-19.json', '../data_text/Saxon_02-25-19.json', '../data_text/Saxon_02-24-19.json', '../data_text/Saxon_02-22-19.json', '../data_text/Saxon_02-21-19.json', '../data_text/Saxon_02-17-19.json', '../data_text/TheRunaways_Group_03-01-19.json', '../data_text/TheRunaways_02-28-19.json', '../data_text/TheRunaways_02-27-19.json', '../data_text/TheElectricElves_Group_03-01-19.json', '../data_text/TheElectricElves_02-28-19.json', '../data_text/TheElectricElves_02-27-19.json', '../data_text/TheElectricElves_02-26-19.json', '../data_text/TheElectricElves_02-25-19.json', '../data_text/TheElectricElves_02-24-19.json', '../data_text/TheElectricElves_02-22-19.json', '../data_text/TheElectricElves_02-21-19.json', '../data_text/TheElectricElves_02-17-19.json', '../data_text/Stoney&MeatLoaf_Group_03-01-19.json', '../data_text/Stoney&MeatLoaf_02-28-19.json', '../data_text/Stoney&MeatLoaf_02-27-19.json');

$x = ceil((count($filenames)));


for ($i=0; $i<$x; ++$i) {
    $jsonFile = $filenames[$i];
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
        echo ' Inserted ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays for ' . $artistName . '.<br>';
    } 
    
};


?>