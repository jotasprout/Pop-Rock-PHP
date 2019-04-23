<?php

$filenames = array (
    'data/jsonLastFM/AliceCooper_Combined_04-23-19.json',
    'data/jsonLastFM/Anvil_Group_04-23-19.json',
    'data/jsonLastFM/BlackSabbath_Group_04-23-19.json',
    'data/jsonLastFM/LindseyBuckingham_Person_04-23-19.json',
    'data/jsonLastFM/DefLeppard_Group_04-23-19.json',
    'data/jsonLastFM/Dio_Group_04-23-19.json', 
    'data/jsonLastFM/Elf_Group_04-23-19.json', 
    'data/jsonLastFM/EvilStig_Group_04-23-19.json', 
    'data/jsonLastFM/FleetwoodMac_Group_04-23-19.json',
    'data/jsonLastFM/Heaven&Hell_Group_04-23-19.json', 
    'data/jsonLastFM/JanetJackson_Person_04-23-19.json', 
    'data/jsonLastFM/JoanJett_Combined_04-23-19.json', 
    'data/jsonLastFM/Journey_Group_04-23-19.json', 
    'data/jsonLastFM/MeatLoaf_Person_04-23-19.json', 
    'data/jsonLastFM/MötleyCrüe_Group_04-23-19.json', 
    'data/jsonLastFM/StevieNicks_Person_04-23-19.json',
    'data/jsonLastFM/OzzyOsbourne_Person_04-23-19.json', 
    'data/jsonLastFM/Queen_Group_04-23-19.json', 
    'data/jsonLastFM/QuietRiot_Group_04-23-19.json', 
    'data/jsonLastFM/Radiohead_Group_04-23-19.json',
    'data/jsonLastFM/Rainbow_Group_04-23-19.json', 
    'data/jsonLastFM/RonnieDioandtheProphets_Group_04-23-19.json', 
    'data/jsonLastFM/RonnieDioandtheRedCaps_Group_04-23-19.json', 
    'data/jsonLastFM/RoxyMusic_Group_04-23-19.json',
    'data/jsonLastFM/Saxon_Group_04-23-19.json', 
    'data/jsonLastFM/Stoney&Meatloaf_Group_04-23-19.json',
    'data/jsonLastFM/TedNugent_Person_04-23-19.json', 
    'data/jsonLastFM/TheAmboyDukes_Group_04-23-19.json',
    'data/jsonLastFM/TheCure_Group_04-23-19.json',
    'data/jsonLastFM/TheElectricElves_Group_04-23-19.json', 
    'data/jsonLastFM/TheRunaways_Group_04-23-19.json',
    'data/jsonLastFM/TheZombies_Group_04-23-19.json'
);

$filenames2 = array (
    'data/jsonLastFM/AliceCooper_Combined_04-23-19.json',
    'data/jsonLastFM/Anvil_Group_04-23-19.json',
    'data/jsonLastFM/BlackSabbath_Group_04-23-19.json',
    'data/jsonLastFM/LindseyBuckingham_Person_04-23-19.json',
    'data/jsonLastFM/DefLeppard_Group_04-23-19.json',
    'data/jsonLastFM/Dio_Group_04-23-19.json', 
    'data/jsonLastFM/Elf_Group_04-23-19.json', 
    'data/jsonLastFM/EvilStig_Group_04-23-19.json', 
    'data/jsonLastFM/FleetwoodMac_Group_04-23-19.json',
    'data/jsonLastFM/Heaven&Hell_Group_04-23-19.json', 
    'data/jsonLastFM/JanetJackson_Person_04-23-19.json', 
    'data/jsonLastFM/JoanJett_Combined_04-23-19.json'
);

$filenames = $filenames2;

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
                $release = $releases[0];
                $releaseMBID = $album['releases'][0]['mbid'];
                $releaseName = $album['releases'][0]['name'];

                $tracks = $release['tracks'];
                $tracksNum = ceil((count($tracks)));   

                for ($m=0; $m<$tracksNum; ++$m) {
                    $track = $tracks[$m];
                    $trackMBID = $track['mbid'];
                    $trackNameYucky = $track['title'];
                    $trackName = mysqli_real_escape_string($connekt,$trackNameYucky);
                    $trackListeners = $track['stats']['listeners'];
                    $trackPlaycount = $track['stats']['playcount'];

                    $insertMBIDtrack = "INSERT INTO tracksLastFM (
                        trackMBID, 
                        dataDate,
						trackListeners,
						trackPlaycount 
                        ) 
                        VALUES(
                            '$trackMBID',
                            '$dataDate',
							'$trackListeners',
							'$trackPlaycount'
                        )";

                    $pushTrack = $connekt->query($insertMBIDtrack);

                    if(!$pushTrack){
                        echo '<p>Shickety Brickety! Could not insert ' . $trackName . ' stats.</p>';
                    } else {
                        echo '<p>' . $trackName . ' from ' . $releaseName . ' had ' . $trackListeners . ' listeners and ' . $trackPlaycount . ' plays on ' . $dataDate . '.</p>';
                    }       
                };
            }  
        };
    };
};       

?>