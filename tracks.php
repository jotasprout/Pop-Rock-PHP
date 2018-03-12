<?php

$albumsTracksArrays = array ();

function divideCombineInsertTracksAndPop ($AlbumsTracks) {

	// $totalTracks = count($AlbumsTracks);
	// echo $totalTracks . '<br>';

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
		// echo $tracksThisTime . '<br>';

		$trackIds = implode(',', $albumsTracksArrays[$i]);

		// For each array of tracks (50 at a time), "get several tracks"
		$bunchoftracks = $GLOBALS['api']->getTracks($trackIds);
			
		foreach ($bunchoftracks->tracks as $track) {
			
			$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
			
			if (!$connekt) {
				echo 'Darn. Did not connect.';
			};			

			$trackID = $track->id;
			$trackAlbumID = $track->album->id;
			$trackAlbumNameYucky = $track->album->name;
			$trackAlbumName = mysqli_real_escape_string($connekt,$trackAlbumNameYucky);
			$trackNameYucky = $track->name;
			$trackName = mysqli_real_escape_string($connekt,$trackNameYucky);
			$trackPop = $track->popularity;
			$thisArtistName = $track->artists[0]->name;
			
			$insertTrackInfo = "INSERT INTO tracks (trackID,trackName,albumID) VALUES('$trackID','$trackName','$trackAlbumID')";
	
			$rockout = $connekt->query($insertTrackInfo);
	
			if(!$rockout){
				echo 'Cursed-Crap. Could not insert "' . $trackName . '" from <i>' . $trackAlbumName . '</i>.<br>';
			}
	
			$insertTrackPop = "INSERT INTO popTracks (trackID,pop) VALUES('$trackID','$trackPop')";
	
			$rockpop = $connekt->query($insertTrackPop);
			
			if(!$rockpop){
				echo 'Confounded-Crap. Could not insert POPULARITY for "' . $trackName . '" from <i>' . $trackAlbumName . '</i>.<br>';
			}
	
			else {
				echo $thisArtistName . "'s album <i>" . $trackAlbumName . "</i>, track " . $trackName . " has pop " . $trackPop . "<br>";
			}
		}
	};
}

function divideCombineInsertPopTracks ($AlbumsTracks) {

	// $totalTracks = count($AlbumsTracks);
	// echo $totalTracks . '<br>';

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
				
		// $tracksThisTime = count($albumsTracksArrays[$i]);
		// echo $tracksThisTime . '<br>';

		$trackIds = implode(',', $albumsTracksArrays[$i]);

		// For each array of tracks (50 at a time), "get several tracks"
		$bunchoftracks = $GLOBALS['api']->getTracks($trackIds);
			
		foreach ($bunchoftracks->tracks as $track) {
			
			$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
			
			if (!$connekt) {
				echo 'Darn. Did not connect.';
			};			

			$trackID = $track->id;
			$trackAlbumNameYucky = $track->album->name;
			$trackAlbumName = mysqli_real_escape_string($connekt,$trackAlbumNameYucky);
			$trackName = $track->name;
			$trackPop = $track->popularity;
	
			$insertTrackPop = "INSERT INTO popTracks (trackID,pop) VALUES('$trackID','$trackPop')";
	
			$rockpop = $connekt->query($insertTrackPop);
			
			if(!$rockpop){
				echo 'Cursed-Crap. Could not insert track popularity.';
			}
	
			else {
				echo "<tr><td>" . $trackAlbumName . "</td><td>" . $trackName . "</td><td>" . $trackPop . "</td></tr>";
			}
		}
	};
}

function divideCombineTracks ($AlbumsTracks) {

	// $totalTracks = count($AlbumsTracks);
	// echo $totalTracks . '<br>';

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
				
		// $tracksThisTime = count($albumsTracksArrays[$i]);
		// echo $tracksThisTime . '<br>';

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

function showTracks ($artistID) {

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

	if (!$connekt) {
		echo 'Darn. Did not connect.';
	};
	
	$gatherTrackInfo = "SELECT a.trackID, a.trackName, a.albumID, b.albumName, b.artistID, b.year, c.pop, d.artistName, a.date 
		FROM tracks a
			INNER JOIN albums b ON a.albumID = b.albumID
			INNER JOIN popTracks c ON a.trackID = c.trackID
			INNER JOIN artists d ON b.artistID = d.artistID
				WHERE b.artistID = '$artistID' 
				ORDER BY a.trackName ASC";

	$getit = $connekt->query($gatherTrackInfo);

	if(!$getit){
		echo 'Cursed-Crap. Did not run the query.';
	}

	while ($row = mysqli_fetch_array($getit)) {
		// $artistID = $row["artistID"];
		$artistName = $row["artistName"];
		$albumName = $row["albumName"];
		$trackName = $row["trackName"];
		$albumReleased = $row["year"];
		$trackPop = $row["pop"];
		$popDate = $row["date"];
		
		echo "<tr>";
		echo "<td>" . $artistName . "</td>";
		echo "<td>" . $albumName . "</td>";
		echo "<td>" . $trackName . "</td>";
		echo "<td>" . $trackPop . "</td>";
		echo "<td>" . $popDate . "</td>";
		echo "</tr>";
	}
}

?>