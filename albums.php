<?php



function divideCombineAlbums ($artistAlbums) {

	$artistAlbumsChunk = array ();
	$albumsArrays = array ();
	
    // Round up so loop loops as much as needed
	$x = ceil((count($artistAlbums))/20);
	echo 'Artist Albums divided by 20 = ' . $x . '<br>';
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
    
  }


?>