<?php

require_once '../rockdb.php';

$filenames0 = array (
    '../data_text/jsonLastFM/AliceCooper_Combined_03-25-19.json',
    '../data_text/jsonLastFM/Anvil_Group_03-25-19.json',
    '../data_text/jsonLastFM/BlackSabbath_Group_03-25-19.json',
    '../data_text/jsonLastFM/Dio_Group_03-25-19.json', 
    '../data_text/jsonLastFM/Elf_Group_03-25-19.json', 
    '../data_text/jsonLastFM/EvilStig_Group_03-25-19.json', 
    '../data_text/jsonLastFM/Heaven&Hell_Group_03-25-19.json', 
    '../data_text/jsonLastFM/JoanJett_Combined_03-25-19.json', 
    '../data_text/jsonLastFM/MeatLoaf_Person_03-25-19.json', 
    '../data_text/jsonLastFM/MötleyCrüe_Group_03-25-19.json', 
    '../data_text/jsonLastFM/OzzyOsbourne_Person_03-25-19.json', 
    '../data_text/jsonLastFM/Queen_Group_03-25-19.json', 
    '../data_text/jsonLastFM/QuietRiot_Group_03-25-19.json', 
    '../data_text/jsonLastFM/Rainbow_Group_03-25-19.json', 
    '../data_text/jsonLastFM/RonnieDioandtheProphets_Group_03-25-19.json', 
    '../data_text/jsonLastFM/RonnieDioandtheRedCaps_Group_03-25-19.json', 
    '../data_text/jsonLastFM/Saxon_Group_03-25-19.json', 
    '../data_text/jsonLastFM/Stoney&Meatloaf_Group_03-25-19.json',
    '../data_text/jsonLastFM/TedNugent_Person_03-25-19.json', 
    '../data_text/jsonLastFM/TheAmboyDukes_Group_03-25-19.json',
    '../data_text/jsonLastFM/TheElectricElves_Group_03-25-19.json', 
    '../data_text/jsonLastFM/TheRunaways_Group_03-25-19.json'
);

$filenames1 = array (
    '../data_text/jsonLastFM/TheZombies_Group_03-25-19.json', 
    '../data_text/jsonLastFM/TheCure_Group_03-25-19.json', 
    '../data_text/jsonLastFM/StevieNicks_Person_03-25-19.json', 
    '../data_text/jsonLastFM/DefLeppard_Group_03-25-19.json', 
    '../data_text/jsonLastFM/FleetwoodMac_Group_03-25-19.json',
    '../data_text/jsonLastFM/JanetJackson_Person_03-25-19.json', 
    '../data_text/jsonLastFM/Journey_Group_03-25-19.json',
    '../data_text/jsonLastFM/Radiohead_Group_03-25-19.json', 
    '../data_text/jsonLastFM/RoxyMusic_Group_03-25-19.json'
);

$x = ceil((count($filenames1)));

for ($i=0; $i<$x; ++$i) {

    $jsonFile = $filenames1[$i];
    $fileContents = file_get_contents($jsonFile);
	
    $artistData = json_decode($fileContents,true);

    $artistMBID = $artistData['mbid'];
    $artistName = $artistData['name'];
    $dataDate = $artistData['date'];
    
    $artistListeners = $artistData['stats']['listeners'];
    $artistPlaycount = $artistData['stats']['playcount'];

    $dataDate = $artistData['date'];

    $albums = $artistData['albums'];

    $albumsNum = ceil((count($albums)));

    $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

    if(!$connekt){
        echo '<p>Fiddlesticks! Could not connect to database.</p>';
    } else {

        $insertArtistLastFM = "INSERT INTO artistsLastFM (artistMBID, dataDate, artistListeners, artistPlaycount) VALUES('$artistMBID','$dataDate','$artistListeners', '$artistPlaycount')";

        $rockout = $connekt->query($insertArtistLastFM);

        if(!$rockout){
            echo '<p>Shickety Brickety! Could not insert stats for ' . $artistName . '.</p>';
        } else {
            echo '<p>Inserted ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays for ' . $artistName . '.</p>';
        }

        for ($j=0; $j<$albumsNum; ++$j) {
            $album = $albums[$j];
            $releases = $album['releases'];
            $releasesNum = ceil((count($releases)));
            if ($releasesNum > 0){
                $releaseMBID = $album['releases'][0]['mbid'];
                $releaseNameYucky = $album['releases'][0]['name'];
                $releaseName = mysqli_real_escape_string($connekt,$releaseNameYucky);
                $albumListeners = $album['releases'][0]['listeners'];
                $albumPlaycount = $album['releases'][0]['playcount'];
    
                $insertAlbumMBinfo = "INSERT INTO albumsMB (
                    albumName,
                    artistMBID, 
                    albumMBID
                ) 
                VALUES(
                    '$releaseName',
                    '$artistMBID',
                    '$releaseMBID'
                )";
                
                $rockon = $connekt->query($insertAlbumMBinfo);
        
                if(!$rockon){
                    echo '<p>Shickety Brickety! Could not insert MB info for ' . $releaseName . '.</p>';
                } else {
                    echo '<p>Inserted MB info for ' . $releaseName . '.</p>';
                }
        
                $insertLastFMalbumData = "INSERT INTO albumListenersPlaycount (
                    albumMBID, 
                    dataDate,
                    albumListeners,
                    albumPlaycount
                    ) 
                    VALUES(
                        '$releaseMBID',
                        '$dataDate',
                        '$albumListeners',
                        '$albumPlaycount'
                    )";	
                    
                $rockin = $connekt->query($insertLastFMalbumData);

                if(!$rockin){
                    echo '<p>Shickety Brickety! Could not insert ' . $releaseName . ' stats.</p>';
                } else {
                    echo '<p>Inserted ' . $albumListeners . ' listeners and ' . $albumPlaycount . ' plays for ' . $releaseName . '.</p>';
                }
/*
                $tracks = $album['releases'][0]['tracks'];
                $tracksNum = ceil((count($tracks)));   

                for ($m=0; $m<$tracksNum; ++$m) {
                    $track = $tracks[$m];
                    $trackMBID = $track['mbid'];
                    $trackNameYucky = $track['title'];
                    $trackName = mysqli_real_escape_string($connekt,$trackNameYucky);
                    $trackListeners = $track['stats']['listeners'];
                    $trackPlaycount = $track['stats']['playcount'];

                    $insertMBIDtrack = "INSERT INTO tracksMB (
                        trackMBID, 
                        trackName,
                        albumMBID 
                        ) 
                        VALUES(
                            '$trackMBID',
                            '$trackName',
							'$releaseMBID'
                        )";

                    $pushTrack = $connekt->query($insertMBIDtrack);

                    if(!$pushTrack){
                        echo '<p>Shickety Brickety! Could not insert ' . $trackName . ' info.</p>';
                    } else {
                        echo '<p>Inserted ' . $trackName . ' from ' . $releaseName . '.</p>';
                    }     
                    
                    $insertTrackLastFMdata = "INSERT INTO tracksLastFM (
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

                    $pushTrack = $connekt->query($insertTrackLastFMdata);

                    if(!$pushTrack){
                        echo '<p>Shickety Brickety! Could not insert ' . $trackName . ' stats.</p>';
                    } else {
                        echo '<p>' . $trackName . ' from ' . $releaseName . ' had ' . $trackListeners . ' listeners and ' . $trackPlaycount . ' plays on ' . $dataDate . '.</p>';
                    };   
                };
                */
            };
        };
    };
};

?>