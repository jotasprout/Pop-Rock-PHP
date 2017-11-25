<?php

require ("class.artist.php");
require_once 'rockdb.php';

$hollywoodVampires = new artist ("3k4YA0uPsWc2PuOQlJNpdH","Hollywood Vampires");
$aliceCooper = new artist("3EhbVgyfGd7HkpsagwL9GS","Alice Cooper");
$davidBowie = new artist("0oSGxfWSnnOXhD2fKuz2Gy","David Bowie");
$bobDylan = new artist("74ASZWbe4lXaubB36ztrGX","Bob Dylan");
$meatLoaf = new artist("7dnB1wSxbYa8CejeVg98hz","Meat Loaf");
$johnMellencamp = new artist("3lPQ2Fk5JOwGWAF3ORFCqH","John Mellencamp");
$stooges = new artist("4BFMTELQyWJU1SwqcXMBm3","The Stooges");
$bruceSpringsteen = new artist("3eqjTLE0HfPfh78zjh6TqT","Bruce Springsteen");
$kiss = new artist("07XSN3sPlIlB2L2XNcTwJw","Kiss");
$iggyPop = new artist("33EUXrFKGjpUSGacqEHhU4","Iggy Pop");
$popWilliamson = new artist("1l8grPt6eiOS4YlzjIs0LF","Iggy Pop & James Williamson");
$rollingStones = new artist("22bE4uQ6baNwSHPVcDxLCe","Rolling Stones");
$tomPetty = new artist("2UZMlIwnkgAEDBsw1Rejkn","Tom Petty");
$tpHeartbreakers = new artist("4tX2TplrkIP4v05BNC903e","Tom Petty & the Heartbreakers");
$travelingWilburys = new artist("2hO4YtXUFJiUYS2uYFvHNK","Traveling Wilburys");

$artists = array ("3k4YA0uPsWc2PuOQlJNpdH","3EhbVgyfGd7HkpsagwL9GS","0oSGxfWSnnOXhD2fKuz2Gy","74ASZWbe4lXaubB36ztrGX","7dnB1wSxbYa8CejeVg98hz","3lPQ2Fk5JOwGWAF3ORFCqH","4BFMTELQyWJU1SwqcXMBm3","3eqjTLE0HfPfh78zjh6TqT","07XSN3sPlIlB2L2XNcTwJw","33EUXrFKGjpUSGacqEHhU4","1l8grPt6eiOS4YlzjIs0LF","22bE4uQ6baNwSHPVcDxLCe","2UZMlIwnkgAEDBsw1Rejkn","4tX2TplrkIP4v05BNC903e");

$BonJovi = new artist ("Bon Jovi", "58lV9VcRSjABbAbfWS6skp");
$KateBush = new artist ("Kate Bush", "1aSxMhuvixZ8h9dK9jIDwL");
$Cars = new artist ("The Cars", "6DCIj8jNaNpBz8e5oKFPtp");
$DepecheMode = new artist ("Depeche Mode", "762310PdDnwsDxAQxzQkfX");
$DireStraits = new artist ("Dire Straits", "0WwSkZ7LtFUFjGjMZBMt6T");
$Eurythmics = new artist ("Eurythmics", "0NKDgy9j66h3DLnN8qu1bB");
$JGeilsBand = new artist ("J. Geils Band", "69Mj3u4FTUrpyeGNSIaU6F");
$JudasPriest = new artist ("Judas Priest", "2tRsMl4eGxwoNabM08Dm4I");
$LLCoolJ = new artist ("LL Cool J", "1P8IfcNKwrkQP5xJWuhaOC");
$MC5 = new artist ("The MC5", "4WquJweZPIK9qcfVFhTKvf");
$TheMeters = new artist ("The Meters", "2JRvXPGWiINrnJljNJhG5s");
$MoodyBlues = new artist ("Moody Blues", "5BcZ22XONcRoLhTbZRuME1");
$Radiohead = new artist ("Radiohead", "4Z8W4fKeB5YxbusRsdQVPb");
$RageAgainstTheMachine = new artist ("Rage Against the Machine", "2d0hyoQ5ynDBnkvAbJKORj");
$RufusFeatChakaKhan = new artist ("Rufus featuring Chaka Khan", "1YLsqPcFg1rj7VvhfwnDWm");
$NinaSimone = new artist ("Nina Simone", "7G1GBhoKtEPnP86X2PvEYO");
$SisterRosettaTharpe = new artist ("Sister Rosetta Tharpe", "2dXf5lu5iilcaTQJZodce7");
$LinkWray = new artist ("Link Wray", "2vQavlZtDA660mnZotYIto");
$Zombies = new artist ("The Zombies", "2jgPkn6LuUazBoBk6vvjh5");
$TravelingWilburys = new artist ("Traveling Wilburys", "2hO4YtXUFJiUYS2uYFvHNK");
$ChakaKhan = new artist ("Chaka Khan", "6mQfAAqZGBzIfrmlZCeaYT");

$nominees2018 = array ("58lV9VcRSjABbAbfWS6skp", "1aSxMhuvixZ8h9dK9jIDwL", "6DCIj8jNaNpBz8e5oKFPtp", "762310PdDnwsDxAQxzQkfX", "0WwSkZ7LtFUFjGjMZBMt6T", "0NKDgy9j66h3DLnN8qu1bB", "69Mj3u4FTUrpyeGNSIaU6F", "2tRsMl4eGxwoNabM08Dm4I", "1P8IfcNKwrkQP5xJWuhaOC", "4WquJweZPIK9qcfVFhTKvf", "2JRvXPGWiINrnJljNJhG5s", "5BcZ22XONcRoLhTbZRuME1", "4Z8W4fKeB5YxbusRsdQVPb", "2d0hyoQ5ynDBnkvAbJKORj", "1YLsqPcFg1rj7VvhfwnDWm", "7G1GBhoKtEPnP86X2PvEYO", "2dXf5lu5iilcaTQJZodce7", "2vQavlZtDA660mnZotYIto", "2jgPkn6LuUazBoBk6vvjh5", "2hO4YtXUFJiUYS2uYFvHNK", "6mQfAAqZGBzIfrmlZCeaYT");


$allArtists = array ("3k4YA0uPsWc2PuOQlJNpdH","3EhbVgyfGd7HkpsagwL9GS","0oSGxfWSnnOXhD2fKuz2Gy","74ASZWbe4lXaubB36ztrGX","7dnB1wSxbYa8CejeVg98hz","3lPQ2Fk5JOwGWAF3ORFCqH","4BFMTELQyWJU1SwqcXMBm3","3eqjTLE0HfPfh78zjh6TqT","07XSN3sPlIlB2L2XNcTwJw","33EUXrFKGjpUSGacqEHhU4","1l8grPt6eiOS4YlzjIs0LF","22bE4uQ6baNwSHPVcDxLCe","2UZMlIwnkgAEDBsw1Rejkn","4tX2TplrkIP4v05BNC903e","58lV9VcRSjABbAbfWS6skp", "1aSxMhuvixZ8h9dK9jIDwL", "6DCIj8jNaNpBz8e5oKFPtp", "762310PdDnwsDxAQxzQkfX", "0WwSkZ7LtFUFjGjMZBMt6T", "0NKDgy9j66h3DLnN8qu1bB", "69Mj3u4FTUrpyeGNSIaU6F", "2tRsMl4eGxwoNabM08Dm4I", "1P8IfcNKwrkQP5xJWuhaOC", "4WquJweZPIK9qcfVFhTKvf", "2JRvXPGWiINrnJljNJhG5s", "5BcZ22XONcRoLhTbZRuME1", "4Z8W4fKeB5YxbusRsdQVPb", "2d0hyoQ5ynDBnkvAbJKORj", "1YLsqPcFg1rj7VvhfwnDWm", "7G1GBhoKtEPnP86X2PvEYO", "2dXf5lu5iilcaTQJZodce7", "2vQavlZtDA660mnZotYIto", "2jgPkn6LuUazBoBk6vvjh5", "2hO4YtXUFJiUYS2uYFvHNK", "6mQfAAqZGBzIfrmlZCeaYT");

function divideCombineArtists ($allArtists) {
	
	$totalTracks = count($allArtists);

	// Divide all artists into chunks of 50
	$artistsChunk = array ();
	$x = ceil((count($allArtists))/50);

	$firstArtist = 0;

	for ($i=0; $i<$x; ++$i) {
		$lastArtist = 49;
		$artistsChunk = array_slice($allArtists, $firstArtist, $lastArtist);
		// put chunks of 50 into an array
		$artistsArrays [] = $artistsChunk;
		$firstArtist += 50;
	};

	for ($i=0; $i<(count($artistsArrays)); ++$i) {
				
		$artistsThisTime = count($artistsArrays[$i]);

		$artistIds = implode(',', $artistsArrays[$i]);

		// For each array of artists (50 at a time), "get several artists"
		$bunchofartists = $GLOBALS['api']->getArtists($artistIds);
			
		foreach ($bunchofartists->artists as $artist) {
			$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
			$artistID = $artist->id;
			$artistNameYucky = $artist->name;
			$artistName = mysqli_real_escape_string($connekt,$artistNameYucky);
			$artistPop = $artist->popularity;
	
			$insertArtistsPop = "INSERT INTO popArtists (artistID,pop) VALUES('$artistID','$artistPop')";
	
			$rockpop = $connekt->query($insertArtistsPop);
			
		}
	};	
}


function inserttArtistsAndPop ($nominees2018) {

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

	$bunchofartists = $GLOBALS['api']->getArtists($nominees2018);

	foreach ($bunchofartists->artists as $artist) {

		$artistID = $artist->id;
		$artistNameYucky = $artist->name;
		$artistName = mysqli_real_escape_string($connekt,$artistNameYucky);
		$artistPop = $artist->popularity;

		$insertArtistsInfo = "INSERT INTO artists (artistID,artistName) VALUES('$artistID','$artistName')";

		if (!$connekt) {
			echo 'Darn. Did not connect.';
		};

		$rockout = $connekt->query($insertArtistsInfo);

		if(!$rockout){
			echo 'Cursed-Crap. Could not insert artists.';
		}

		$insertArtistsPop = "INSERT INTO popArtists (artistID,pop) VALUES('$artistID','$artistPop')";

		$rockpop = $connekt->query($insertArtistsPop);
		
		if(!$rockpop){
			echo 'Cursed-Crap. Could not insert artists popularity.';
		}

		else {
			echo '<tr><td>' . $artistName . '</td><td>' . $artistPop . '</td></tr>';
		}

	}

	// When attempt is complete, connection closes
	mysqli_close($connekt);

}

function getArtistsPopCron ($artists) {
	
	$artistsIds = implode(',', $artists);

	$bunchofartists = $GLOBALS['api']->getArtists($artistsIds);

	foreach ($bunchofartists->artists as $artist) {

		$artistID = $artist->id;
		$artistName = $artist->name;
		$artistPop = $artist->popularity;

		$insertArtistsPop = "INSERT INTO popArtists (artistID,pop) VALUES('$artistID','$artistPop')";

		$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

		$rockout = $connekt->query($insertArtistsPop);

		// When attempt is complete, connection closes
		mysqli_close($connekt);

	}

}

function getArtistsPop ($artists) {
				
	$artistsIds = implode(',', $artists);

	$bunchofartists = $GLOBALS['api']->getArtists($artistsIds);
		
	foreach ($bunchofartists->artists as $artist) {

		$artistID = $artist->id;
		$artistName = $artist->name;
		$artistPop = $artist->popularity;
		
		$insertArtistsPop = "INSERT INTO popArtists (artistID,pop) VALUES('$artistID','$artistPop')";
		
		$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
		
		if (!$connekt) {
			echo 'Darn. Did not connect.';
		};
		
		$rockout = $connekt->query($insertArtistsPop);
		
		if(!$rockout){
			echo 'Cursed-Crap. Could not insert artists popularity.';
		}
	
		echo '<tr><td>' . $artistName . '</td><td>' . $artistPop . '</td></tr>';

		// When attempt is complete, connection closes
		mysqli_close($connekt);

	}	
}

function getArtistsAndPop ($artists) {
	
	$artistsIds = implode(',', $artists);

	$bunchofartists = $GLOBALS['api']->getArtists($artistsIds);

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

	foreach ($bunchofartists->artists as $artist) {

		$artistID = $artist->id;
		$artistName = $artist->name;
		$artistPop = $artist->popularity;

		$insertArtistsPop = "INSERT INTO popArtists (artistID,pop) VALUES('$artistID','$artistPop')";

		if (!$connekt) {
			echo 'Darn. Did not connect.';
		};

		$rockout = $connekt->query($insertArtistsPop);

		if(!$rockout){
			echo 'Cursed-Crap. Could not insert artists popularity.';
		}

		echo '<tr><td>' . $artistName . '</td><td>' . $artistPop . '</td></tr>';

	}

	// When attempt is complete, connection closes
	mysqli_close($connekt);

}

function showArtists () {

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
	
	$artistInfoAll = "SELECT a.artistID, a.artistName, b.pop, b.date 
		FROM artists a
			INNER JOIN popArtists b ON a.artistID = b.artistID
		ORDER BY a.artistName ASC";

	$artistInfoRecent = "SELECT a.artistID, a.artistName, b.pop, b.date 
		FROM artists a
			INNER JOIN popArtists b ON a.artistID = b.artistID
				WHERE b.date = (select max(b2.date)
								FROM popArtists b2)
		ORDER BY a.artistName ASC";

	$getit = $connekt->query($artistInfoRecent);

    if (!$getit) {
        echo mysql_error();
        die;
    }
    
    $data = array();
    
    for ($x = 0; $x < mysql_num_rows($getit); $x++) {
        $data[] = mysql_fetch_assoc($getit);
    }
    
	echo json_encode($data); 	
	// should next line go here or after while loop?
	mysql_close($server);

	while ($row = mysqli_fetch_array($getit)) {
		// $artistID = $row["artistID"];
		$artistName = $row["artistName"];
		$artistPop = $row["pop"];
		
		echo "<tr>";
		echo "<td>" . $artistName . "</td>";
		echo "<td>" . $artistPop . "</td>";
		echo "</tr>";
	}
}

?>