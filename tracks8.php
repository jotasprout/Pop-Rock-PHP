<?php

$albumsTracksArrays = array ();

function divideCombineTracks ($AlbumsTracks) {

	$totalTracks = count($AlbumsTracks);
	echo $totalTracks . '<br>';

	// Divide all artist's tracks into chunks of 50
	$tracksChunk = array ();
	$x = ceil((count($AlbumsTracks))/50);

	$firstTrack = 0;

	for ($i=0; $i<$x; ++$i) {
		$lastTrack = 49;
		$tracksChunk = array_slice($AlbumsTracks, $firstTrack, $lastTrack);
		// put chunks of 50 into an array
		$albumsTracksArrays [] = $tracksChunk;
		$firstTrack += 50;
	};

	for ($i=0; $i<(count($albumsTracksArrays)); ++$i) {
				
		$tracksThisTime = count($albumsTracksArrays[$i]);
		echo $tracksThisTime . '<br>';

		$trackIds = implode(',', $albumsTracksArrays[$i]);

		// For each array of tracks (50 at a time), "get several tracks"
		$bunchoftracks = $GLOBALS['api']->getTracks($trackIds);
			
		foreach ($bunchoftracks->tracks as $track) {

			$trackID = $track->id;
			$trackAlbumName = $track->album->name;
			$trackName = $track->name;
			$trackPop = $track->popularity;
			echo '<tr><td>' . $trackAlbumName . '</td><td>' . $trackName . '</td><td>' . $trackPop . '</td></tr>';
		}
	};
  
}

function showAlbums () {
	
	$gatherAlbumInfo = "SELECT a.trackID, a.trackName, a.albumID, b.albumName, b.artistID, b.year, c.pop, d.artistName 
		FROM tracks a
			INNER JOIN albums b ON a.albumID = b.albumID
			INNER JOIN popTracks c ON a.trackID = c.trackID
			INNER JOIN artists d ON b.artistID = d.artistID
				ORDER BY b.albumName ASC";

	$getit = $connekt->query($gatherAlbumInfo);

	while ($row = mysqli_fetch_array($getit)) {
		// $artistID = $row["artistID"];
		$artistName = $row["artistName"];
		$albumName = $row["albumName"];
		$trackName = $row["trackName"];
		$albumReleased = $row["year"];
		$trackPop = $row["pop"];
		
		echo "<tr>";
		echo "<td>" . $artistName . "</td>";
		echo "<td>" . $albumName . "</td>";
		echo "<td>" . $trackName . "</td>";
		echo "<td>" . $albumReleased . "</td>";
		echo "<td>" . $trackPop . "</td>";
		echo "</tr>";
	}
}

?>