<?php

require_once '../rockdb.php';

$filenames1 = array (
    '../data_text/jsonLastFM/BuckinghamNicks_Group_03-25-19.json',
    '../data_text/jsonLastFM/DefLeppard_Group_03-25-19.json',
    '../data_text/jsonLastFM/FleetwoodMac_Group_03-25-19.json', 
    '../data_text/jsonLastFM/JanetJackson_Person_03-25-19.json', 
    '../data_text/jsonLastFM/Journey_Group_03-25-19.json', 
    '../data_text/jsonLastFM/LindseyBuckingham_Person_03-25-19.json', 
    '../data_text/jsonLastFM/Radiohead_Group_03-25-19.json', 
    '../data_text/jsonLastFM/RoxyMusic_Group_03-25-19.json', 
    '../data_text/jsonLastFM/StevieNicks_Person_03-25-19.json', 
    '../data_text/jsonLastFM/TheCure_Group_03-25-19.json', 
    '../data_text/jsonLastFM/TheZombies_Group_03-25-19.json'
);

$filenames = $filenames1;

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
                $albumListeners = $album['releases'][0]['listeners'];
                $albumPlaycount = $album['releases'][0]['playcount'];
				
				$insertLastFMalbumData = "INSERT INTO albumsLastFM (
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
				
				$insertReleaseStats = $connekt->query($insertLastFMalbumData);
    
                if(!$insertReleaseStats){
                    echo '<p>Shickety Brickety! Could not insert ' . $releaseName . ' stats.</p>';
                } else {
                    echo '<p>' . $releaseName . ' had ' . $albumListeners . ' listeners and ' . $albumPlaycount . ' plays on ' . $dataDate . '.</p>';
                }
				
            }
        };
    };
};

?>