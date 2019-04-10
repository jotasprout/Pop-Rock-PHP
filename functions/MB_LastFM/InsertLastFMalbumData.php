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

	$rockout = $connekt->query($insertArtistLastFM);

    if(!$rockout){
        echo '<p>Shickety Brickety! Could not insert stats for ' . $artistName . '.</p>';
    } else {
        echo '<p>Inserted ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays for ' . $artistName . '.</p>';
    }

    for ($j=0; $j<$albumsNum; ++$j) {
        $album = $albums[$j];
        $releases = $album['releases'];
        $release = $releases[$k];
        $releaseMBID = $release['mbid'];
		$releaseName = $release['name'];
		$albumListeners = $album['listeners'];
		$albumPlaycount = $album['playcount'];

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
	};
};

    $rockin = $connekt->query($insertLastFMalbumData);

    if(!$rockin){
        echo '<p>Shickety Brickety! Could not insert data for ' . $releaseName . '.</p>';
    } else {
		'$albumPlaycount'
		echo '<p>Inserted ' . $albumListeners . ' listeners and ' . $artistPlaycount . ' plays for ' . $releaseName . '.</p>';
    }
};

?>