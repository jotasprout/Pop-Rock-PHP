<?php

require_once '../rockdb.php';
require_once 'artists.php';
require_once 'albums.php';
require_once '../page_pieces/navbar_rock.php';
require_once '../page_pieces/stylesAndScripts.php';

$jsonFile = '../data_text/jsonLastFM/AliceCooper_Combined_03-14-19.json';
$fileContents = file_get_contents($jsonFile);

$artistData = json_decode($fileContents,true);

$artistMBID = $artistData['mbid'];
$artistSpotifyID = '3EhbVgyfGd7HkpsagwL9GS';
$artistName = $artistData['name'];
$artistListeners = $artistData['stats']['listeners'];
$artistPlaycount = $artistData['stats']['playcount'];

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
        $release = $releases[$k];
        $releaseMBID = $release['mbid'];
        $releaseName = $release['name'];

		$insertMBIDalbums = "INSERT INTO albumsMB (
			albumName,
			artistMBID, 
			artistSpotID,
			albumMBID
		) 
		VALUES(
			'$releaseName',
			'$artistMBID',
			'$artistSpotifyID',
			'$releaseMBID'
		)";
		
		$albumListeners = $album['listeners'];
		$albumPlaycount = $album['playcount'];
		
		$insertLastFMalbumData = "INSERT INTO albumListenersPlaycount (
			albumMBID, 
			dataDate,
			albumListeners,
			albumPlaycount
			) 
			VALUES(
				'$$releaseMBID',
				'$dataDate',
				'$albumListeners',
				'$albumPlaycount'
			)";		
	};
};


    $rockout = $connekt->query($insertMBIDalbums);


    if(!$rockout){
        echo 'Shickety Brickety! Could not insert albums for ' . $artistName . '.<br>';
    } else {
        echo ' Inserted ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays for ' . $artistName . '.<br>';
    }


    
    echo $artistName . ' had ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays on ' . $dataDate . '.<br>';
    

    
 
    
};

?>