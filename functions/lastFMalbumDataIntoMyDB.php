<?php

require_once '../rockdb.php';

$filenames = array (
    '../data_text/jsonLastFM/AliceCooper_Combined_03-08-19.json',
    '../data_text/jsonLastFM/Anvil_Group_03-08-19.json',
    '../data_text/jsonLastFM/BlackSabbath_Group_03-08-19.json',
    '../data_text/jsonLastFM/Dio_Group_03-08-19.json', 
    '../data_text/jsonLastFM/Elf_Group_03-08-19.json', 
    '../data_text/jsonLastFM/EvilStig_Group_03-08-19.json', 
    '../data_text/jsonLastFM/Heaven&Hell_Group_03-08-19.json', 
    '../data_text/jsonLastFM/JoanJett_Combined_03-08-19.json', 
    '../data_text/jsonLastFM/MeatLoaf_Person_03-08-19.json', 
    '../data_text/jsonLastFM/MötleyCrüe_Group_03-08-19.json', 
    '../data_text/jsonLastFM/OzzyOsbourne_Person_03-08-19.json', 
    '../data_text/jsonLastFM/Queen_Group_03-08-19.json', 
    '../data_text/jsonLastFM/QuietRiot_Group_03-08-19.json', 
    '../data_text/jsonLastFM/Rainbow_Group_03-08-19.json', 
    '../data_text/jsonLastFM/RonnieDioandtheProphets_Group_03-08-19.json', 
    '../data_text/jsonLastFM/RonnieDioandtheRedCaps_Group_03-08-19.json', 
    '../data_text/jsonLastFM/Saxon_Group_03-08-19.json', 
    '../data_text/jsonLastFM/Stoney&Meatloaf_Group_03-08-19.json',
    '../data_text/jsonLastFM/TedNugent_Person_03-08-19.json', 
    '../data_text/jsonLastFM/TheAmboyDukes_Group_03-08-19.json',
    '../data_text/jsonLastFM/TheElectricElves_Group_03-08-19.json', 
    '../data_text/jsonLastFM/TheRunaways_Group_03-08-19.json'
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

    $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

    if(!$connekt){
        echo 'Fiddlesticks! Could not connect to database.<br>';
    } else {

        for ($j=0; $j<$albumsNum; ++$j) {
            $album = $albums[$j];
            $releases = $album['releases'];
            $releasesNum = ceil((count($releases)));
            if ($releasesNum > 0){
                $releaseMBID = $album['releases'][0]['mbid'];
                $releaseNameYucky = $album['releases'][0]['name'];
                $releaseName = mysqli_real_escape_string($connekt,$releaseNameYucky);
                //albumListeners = album['releases'][0]['listeners']
                //albumPlaycount = album['releases'][0]['playcount']
    
                $insertReleaseMBID = "INSERT INTO albumsMB (
                    albumMBID,
                    albumName,
                    artistMBID
                    ) 
                    VALUES (
                        '$releaseMBID',
                        '$releaseName',
                        '$artistMBID'
                    )";
    
                $pushRelease = $connekt->query($insertReleaseMBID);
    
                if(!$pushRelease){
                    echo 'Shickety Brickety! Could not insert ' . $releaseName . '.<br>';
                } else {
                    echo '<p>Inserted ' . $releaseName . ' by ' . $artistName . '.</p>';
                } 
            }
        };
    };
};

?>