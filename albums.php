<?php

require 'vendor/autoload.php';

$artistAlbums = array ();
$artistAlbumsChunk = array ();
$albumsArrays = array ();
$albumIds = array ();
$albumsChunk = array ();

function divideCombineAlbums ($artistAlbums) {
	
    // Round up so loop loops as much as needed
	$x = ceil((count($artistAlbums))/20);

	// echo 'Artist Albums divided by 20 = ' . $x . '<br>';

	$firstAlbum = 0;
	
    for ($i=0; $i<$x; ++$i) {
	  $lastAlbum = $firstAlbum + 19;
	  echo 'Last album = ' . $lastAlbum . '<br>';
      $artistAlbumsChunk = array_slice($artistAlbums, $firstAlbum, $lastAlbum);
      $albumsArrays [] = $artistAlbumsChunk;
      $firstAlbum += 19;
	};
	
	// am I leaving any garbage behind? Check with the following
	echo '<b>artistAlbums are</b> ' . implode(", ", $artistAlbums) . '<br>';
	// echo '<b>artistAlbumsChunk contains</b> <br>' . implode(", ", $artistAlbumsChunk) . '<br>';
	echo '<b>albumsArrays [0] includes</b> <br>' . implode(", ", $albumsArrays[0]) . '<br>';
	echo '<b>albumsArrays [1] includes</b> <br>' . implode(", ", $albumsArrays[1]) . '<br>';
	// echo 'albumsArrays is = <br>' . $albumsArrays;
	getAllAlbums ($albumsArrays);
    
}

// getAllAlbums loops through the arrays in albumsArrays
function getAllAlbums ($albumsArrays) {

	// for each albumsChunk in $albumsArrays
	for ($i=0; $i<(count($albumsArrays)); ++$i) {

		// echo '<b>albumsArrays [' . $i . '] includes</b> <br>' . implode(", ", $albumsArrays[$i]) . '<br>';

		$albumIds = $albumsArrays[$i];
		echo '<b>this albumIds batch includes</b> <br>' . $albumIds[$i] . '<br>';

		// For each array of albums (20 at a time), "get several albums"
		$thisAlbumsBatch = $api->getAlbums($albumIds);

		echo 'thisalbumsBatch includes ' . $thisAlbumsBatch . '<br>';

		foreach($thisAlbumsBatch as $thisAlbum) {
			$albumID = $album->id;
			$albumName = $album->name;
			echo $albumName;
			$albumReleased = $thisAlbum->release_date;
			$albumPop = $thisAlbum->popularity;
			$artistID = $thisAlbum->artists->id;

			echo '<tr><td>' . $albumID . '</td><td>' . $albumName . '</td><td>' . $albumReleased . '</td><td>' . $albumPop . '</td></tr>';
		}

	};
}


?>