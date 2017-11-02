<?php
// does next line need to be here since it is in same file that includes this file?
require 'vendor/autoload.php';

$artistAlbums = array ();
$artistAlbumsChunk = array ();
$albumsArrays = array ();
$albumIds = array ();
$albumsChunk = array ();

function divideCombineAlbums ($artistAlbums) {
	
    // Divide all artist's albums into chunks of 20
	$x = ceil((count($artistAlbums))/20);

	$firstAlbum = 0;
	
    for ($i=0; $i<$x; ++$i) {
	  $lastAlbum = $firstAlbum + 19;
      $artistAlbumsChunk = array_slice($artistAlbums, $firstAlbum, $lastAlbum);
	  // put chunks of 20 into an array
      $albumsArrays [] = $artistAlbumsChunk;
      $firstAlbum += 19;
	};

    
}

?>