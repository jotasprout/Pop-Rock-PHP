<?php

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
	echo 'artistAlbums are ' . implode(", ", $artistAlbums) . '<br>';
	echo 'artistAlbumsChunk contains ' . implode(", ", $artistAlbumsChunk) . '<br>';
	echo 'albumsArrays includes ' . implode(", ", $albumsArrays[0]) . '<br>';
	echo 'albumsArrays includes ' . implode(", ", $albumsArrays[1]) . '<br>';

	getAllAlbums ($albumsArrays);
    
}

// getAllAlbums loops through the arrays in albumsArrays
function getAllAlbums ($albumsArrays) {

	// for each albumsChunk in $albumsArrays
	for ($i=0; $i<(count($albumsArrays)); ++$i) {

		// $albumIds = implode(",", $albumsArrays[$i]);

		// For each array of albums (20 at a time), "get several albums"
		$albumsChunk = $api->getAlbums($albumsArrays[$i]);

		foreach($albumsChunk as $thisAlbum) {
			$albumID = $album->id;
			$albumName = $album->name;
			$albumReleased = $thisAlbum->release_date;
			$albumPop = $thisAlbum->popularity;
			$artistID = $thisAlbum->artists->id;

			echo '<tr><td>' . $albumID . '</td><td>' . $albumName . '</td><td>' . $albumReleased . '</td><td>' . $albumPop . '</td></tr>';
		}

	};
}


?>