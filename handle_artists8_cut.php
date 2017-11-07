<?php

// $supergroup = $GLOBALS['api']->getArtists($artists);

// should be method in albums class
foreach ($supergroup->artists as $artist) {
	
	// Get each albumID for requesting Full Album Object with popularity
	$artistName = $artist->name;
	$artistPop = $artist->popularity;
	$artistID = $artist->id;

	echo '<tr><td>' . $artistName . '</td><td>' . $artistPop . '</td><td>' . $artistID . '</td></tr>';
	
}

?>