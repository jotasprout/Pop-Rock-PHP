<?php

$artistAlbums = array ();
require_once 'rockdb.php';

function divideCombineAlbumsForTracks ($artistAlbums) {

	$albumsArrays = array ();
	
	// Divide all artist's albums into chunks of 20
	$artistAlbumsChunk = array ();
	$x = ceil((count($artistAlbums))/20);

	$firstAlbum = 0;
	
    for ($i=0; $i<$x; ++$i) {
	  $lastAlbum = 19;
      $artistAlbumsChunk = array_slice($artistAlbums, $firstAlbum, $lastAlbum);
	  // put chunks of 20 into an array
      $albumsArrays [] = $artistAlbumsChunk;
      $firstAlbum += 20;
	};

	for ($i=0; $i<(count($albumsArrays)); ++$i) {
				
		$albumIds = implode(',', $albumsArrays[$i]);
	
		// For each array of albums (20 at a time), "get several albums"
		$bunchofalbums = $GLOBALS['api']->getAlbums($albumIds);
			
		foreach ($bunchofalbums->albums as $album) {

			$AlbumsTracks = array();
	
			$albumID = $album->id;
			
			$thisAlbumTracks = $GLOBALS['api']->getAlbumTracks($albumID);

			// should be method in albums class
			foreach ($thisAlbumTracks->items as $track) {
				
				// Get each trackID for requesting Full Track Object with popularity
				$trackID = $track->id;
				
				// Put trackIDs in array for requesting several at a time (far fewer requests)
				$AlbumsTracks [] = $trackID;
				
			}

			divideCombineInsertTracksAndPop ($AlbumsTracks);
			// divideCombineInsertPopTracks ($AlbumsTracks);
			unset($AlbumsTracks);
			
		}
		
	};
	
}

function divideCombineAlbums ($artistAlbums) {
	
	// Divide all artist's albums into chunks of 20
	$artistAlbumsChunk = array ();
	$x = ceil((count($artistAlbums))/20);

	$firstAlbum = 0;
	
    for ($i=0; $i<$x; ++$i) {
	  $lastAlbum = 19;
	  $artistAlbumsChunk = array_slice($artistAlbums, $firstAlbum, $lastAlbum);
	  // $howmanytotal = count($artistAlbumsChunk);
	  // echo $howmanytotal . '<br>';
	  // put chunks of 20 into an array
      $albumsArrays [] = $artistAlbumsChunk;
      $firstAlbum += 20;
	};

	$howmany = count($albumsArrays);
	echo $howmany . '<br>';

	for ($i=0; $i<(count($albumsArrays)); ++$i) {

		$howmanyhere = count($albumsArrays[$i]);
		echo $howmanyhere . '<br>';
				
		$albumIds = implode(',', $albumsArrays[$i]);
	
		// For each array of albums (20 at a time), "get several albums"
		$bunchofalbums = $GLOBALS['api']->getAlbums($albumIds);
			
		foreach ($bunchofalbums->albums as $album) {

			$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
	
			$albumID = $album->id;	
			$albumNameYucky = $album->name;
			$albumName = mysqli_real_escape_string($connekt,$albumNameYucky);
			// $albumName = mysqli_real_escape_string($connekt, htmlspecialchars($albumNameYucky));
			$albumReleasedWhole = $album->release_date;
			$albumReleased = substr($albumReleasedWhole, 0, 4);
			$thisArtistID = $album->artists[0]->id;
			$thisArtistName = $album->artists[0]->name;
			$albumPop = $album->popularity;

			$insertAlbums = "INSERT INTO albums (albumID,albumName,artistID,year) VALUES('$albumID','$albumName','$thisArtistID','$albumReleased')";
			
			if (!$connekt) {
				echo 'Darn. Did not connect.<br>';
			};
			
			$rockout = $connekt->query($insertAlbums);

			if(!$rockout){
				echo 'Crap de General Tsao! Could not insert album.<br>';
			}

			$insertAlbumsPop = "INSERT INTO popAlbums (albumID,pop) VALUES('$albumID','$albumPop')";

			$rockin = $connekt->query($insertAlbumsPop);
			
			if(!$rockin){
				echo 'Sweet & Sour Crap! Could not insert albums popularity.';
			}
		
            echo '<tr><td>' . $thisArtistName . '</td><td>' . $albumName . '</td><td>' . $albumReleased . '</td><<td>' . $albumPop . '</td></tr>';

		}
	};
  
}

function getAlbumsPop ($artistAlbums) {
	
	// Divide all artist's albums into chunks of 20
	$artistAlbumsChunk = array ();
	$x = ceil((count($artistAlbums))/20);

	$firstAlbum = 0;
	
    for ($i=0; $i<$x; ++$i) {
	  $lastAlbum = 19;
      $artistAlbumsChunk = array_slice($artistAlbums, $firstAlbum, $lastAlbum);
	  // put chunks of 20 into an array
      $albumsArrays [] = $artistAlbumsChunk;
      $firstAlbum += 20;
	};

	for ($i=0; $i<(count($albumsArrays)); ++$i) {
				
		$albumIds = implode(',', $albumsArrays[$i]);
	
		// For each array of albums (20 at a time), "get several albums"
		$bunchofalbums = $GLOBALS['api']->getAlbums($albumIds);
			
		foreach ($bunchofalbums->albums as $album) {

			$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
	
			$albumID = $album->id;
			$artistName = $album->artists[0]->name;
			$albumPop = $album->popularity;
			$albumNameYucky = $album->name;
			$albumName = mysqli_real_escape_string($connekt,$albumNameYucky);
			$albumReleasedWhole = $album->release_date;
			$albumReleased = substr($albumReleasedWhole, 0, 4);
			$insertAlbumsPop = "INSERT INTO popAlbums (albumID,pop) VALUES('$albumID','$albumPop')";
			
			if (!$connekt) {
				echo 'Darn. Did not connect.';
			};
			
			$rockout = $connekt->query($insertAlbumsPop);

			if(!$rockout){
				echo 'Sweet & Sour Crap! Could not insert albums popularity.';
			}
						
			echo "<tr>";
			echo "<td>" . $artistName . "</td>";
			echo "<td>" . $albumName . "</td>";
			echo "<td>" . $albumReleased . "</td>";
			echo "<td>" . $albumPop . "</td>";
			echo "</tr>";

		}
	};
  
}

function showAlbums ($artistID) {

	// $thisArtist = $artistID;
	// before trying above I am trying 201

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

	$query = "SELECT a.albumID, a.albumName, a.year, b.pop, a.artistID, c.artistName 
		FROM albums a
			INNER JOIN popAlbums b ON a.albumID = b.albumID
			INNER JOIN artists c ON a.artistID = c.artistID
				WHERE a.artistID = '$artistID'
					ORDER BY a.year ASC;";

	$query2 = "SELECT a.albumID, a.albumName, a.year, b.pop, a.artistID, c.artistName 
		FROM popAlbums b
		 ON a.artistID = '$artistID'
			INNER JOIN popAlbums b ON a.albumID = b.albumID
				WHERE b.date = (select max(b2.date)
								FROM popAlbums b2)
			INNER JOIN artists c ON a.artistID = c.artistID
				
					ORDER BY a.year ASC";

	$query3 = "SELECT a.albumID, a.albumName, a.artistID, a.year, b.artistName, c.pop, c.date
		FROM albums a ON a.artistID = '$artistID'
			INNER JOIN artists b ON b.artistID = a.artistID
			INNER JOIN popAlbums c ON c.albumID = a.albumID
				WHERE c.date = (SELECT max (c2.date)
								FROM popAlbums c2)
		ORDER BY a.year ASC";

// the next line works in stakeout but not here
	// $result = $connekt->query($query);

	$result = mysqli_query($connekt,$query3);

	while ($row = mysqli_fetch_array($result)) {
		// $artistID = $row["artistID"];
		$artistName = $row['artistName'];
		$albumName = $row['albumName'];
		$albumReleased = $row['year'];
		$albumPop = $row['pop'];
		
		echo "<tr>";
		echo "<td>" . $artistName . "</td>";
		echo "<td>" . $albumName . "</td>";
		echo "<td>" . $albumReleased . "</td>";
		echo "<td>" . $albumPop . "</td>";
		echo "</tr>";
	}
}

?>