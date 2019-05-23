<?php

require_once '../../rockdb.php';
$filenames_07 = array (
    'data/Cream_Group_05-18-19.json',
    'data/EricClapton_Person_05-18-19.json',
    'data/Rainbow_Group_05-18-19.json', 
    'data/RoxyMusic_Group_05-18-19.json',
    'data/Saxon_Group_05-18-19.json', 
    'data/NeilYoung_Person_05-18-19.json',
    'data/TheZombies_Group_05-18-19.json'
);

$filenames = $filenames_07;

$x = ceil((count($filenames)));
/*
$y = ceil((count($artistNames)));

for ($j=0; $j<$y; ++$j){
	assembleURL ($artistNames[$j]);
};
*/
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