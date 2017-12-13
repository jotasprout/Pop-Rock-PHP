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

$firstArtists = array ("3k4YA0uPsWc2PuOQlJNpdH","3EhbVgyfGd7HkpsagwL9GS","0oSGxfWSnnOXhD2fKuz2Gy","74ASZWbe4lXaubB36ztrGX","7dnB1wSxbYa8CejeVg98hz","3lPQ2Fk5JOwGWAF3ORFCqH","4BFMTELQyWJU1SwqcXMBm3","3eqjTLE0HfPfh78zjh6TqT","07XSN3sPlIlB2L2XNcTwJw","33EUXrFKGjpUSGacqEHhU4","1l8grPt6eiOS4YlzjIs0LF","22bE4uQ6baNwSHPVcDxLCe","2UZMlIwnkgAEDBsw1Rejkn","4tX2TplrkIP4v05BNC903e");

$garyNuman = new artist("5KQMtyPE8DCQNUzoNqlEsE","Gary Numan");
$jethroTull = new artist("6w6z8m4WXX7Tub4Rb6Lu7R","Jethro Tull");
$ronnieJamesDio = new artist("4M3c7tg4BzLQ5pIOupZL65","Ronnie James Dio");
$dio = new artist("4CYeVo5iZbtYGBN4Isc3n6","Dio");
$ozzyOsbourne = new artist("6ZLTlhejhndI4Rh53vYhrY","Ozzy Osbourne");
$HeavenHell = new artist("4UjiBRkTw9VmvDZiJZKPJ7","Heaven and Hell");
$ironMaiden = new artist("6mdiAmATAx73kdxrNrnlao","Iron Maiden");
$blackSabbath = new artist("5M52tdBnJaKSvOpJGz8mfZ","Black Sabbath");
$u2 = new artist("51Blml2LZPmy7TTiAg47vQ","U2");
$zzTop = new artist("2AM4ilv6UzW0uMRuqKtDgN","ZZ Top");
$johnnyCash = new artist("6kACVPfCOnqzgfEF5ryl0x","Johnny Cash");
$bobSeger = new artist("485uL27bPomh29R4JmQehQ","Bob Seger");
$prince = new artist("5a2EaR3hamoenG9rDuVn8j","Prince");
$acdc = new artist("711MCceyCBcFnzjGY4Q7Un","AC/DC");

$secondArtists = array ("711MCceyCBcFnzjGY4Q7Un","5a2EaR3hamoenG9rDuVn8j","485uL27bPomh29R4JmQehQ","6kACVPfCOnqzgfEF5ryl0x","2AM4ilv6UzW0uMRuqKtDgN","51Blml2LZPmy7TTiAg47vQ","5M52tdBnJaKSvOpJGz8mfZ","6mdiAmATAx73kdxrNrnlao","4UjiBRkTw9VmvDZiJZKPJ7","6ZLTlhejhndI4Rh53vYhrY","4CYeVo5iZbtYGBN4Isc3n6","4M3c7tg4BzLQ5pIOupZL65","6w6z8m4WXX7Tub4Rb6Lu7R","5KQMtyPE8DCQNUzoNqlEsE");

$newBatch = array ("711MCceyCBcFnzjGY4Q7Un","5a2EaR3hamoenG9rDuVn8j","485uL27bPomh29R4JmQehQ","6kACVPfCOnqzgfEF5ryl0x","2AM4ilv6UzW0uMRuqKtDgN","51Blml2LZPmy7TTiAg47vQ","5M52tdBnJaKSvOpJGz8mfZ","6mdiAmATAx73kdxrNrnlao","4UjiBRkTw9VmvDZiJZKPJ7","6ZLTlhejhndI4Rh53vYhrY","4CYeVo5iZbtYGBN4Isc3n6","4M3c7tg4BzLQ5pIOupZL65","6w6z8m4WXX7Tub4Rb6Lu7R","5KQMtyPE8DCQNUzoNqlEsE","7hW3Ezs4uzy0QQvdnF0Imi","6lE1ly8K8H7u8k2ej2plvv","5WJ6VEY43MOngJJJNabAId","3G7qoMSLvu9Pmb0xGtf9fl","0t1uzfQspxLvAifZLdmFe2","5MQsxr7sbsewUTIEEYxauR","0PGxNwykt4KgnvSnNHVUSZ","3lgxzeCbj6oMQMmaUhH2H6","0sNPk98oyaTeaRojDYglDY","1P72cdCRCvytPnFLkGSeVm","3PXQl96QHBJbzAGENdJWc1","1zK4ACgLi1lVPpfmmcwOTh","1LZqY4X3vFpZaEgXkmiYrG","5kadFhaVFgdn1J4rX3HqB2","3G5wgSAeFzEa6Jv5UNDs4N","3MAQykZ3MwPcviv5eIVqgb","3h66yQiOXZpT6AV2Np5yIq","2hjEGPXpN1BGpNjODQ4ImL","6K1KoB3WXLSOaphD2YoWNU","0p9uD4WGPHqMicwXm3Kavk");

$oneBadPig = new artist("7hW3Ezs4uzy0QQvdnF0Imi","One Bad Pig");
$stryper = new artist("6lE1ly8K8H7u8k2ej2plvv","Stryper");
$bloodgood = new artist("5WJ6VEY43MOngJJJNabAId","Bloodgood");
$bride = new artist("3G7qoMSLvu9Pmb0xGtf9fl","Bride");
$steveTaylor = new artist("0t1uzfQspxLvAifZLdmFe2","Steve Taylor");
$stPerfectFoil = new artist("5MQsxr7sbsewUTIEEYxauR","Steve Taylor & the Perfect Foil");
$stDanielsonFoil = new artist("0PGxNwykt4KgnvSnNHVUSZ","Steve Taylor and the Danielson Foil");
$vengeanceRising = new artist("3lgxzeCbj6oMQMmaUhH2H6","Vengeance Rising");
$freedomSoul = new artist("0sNPk98oyaTeaRojDYglDY","Freedom of Soul");
$pid = new artist("1P72cdCRCvytPnFLkGSeVm","PID");
$sfc = new artist("3PXQl96QHBJbzAGENdJWc1","SFC");
$dcTalk = new artist("1zK4ACgLi1lVPpfmmcwOTh","DC Talk");
$dynamicTwins = new artist("1LZqY4X3vFpZaEgXkmiYrG","Dynamic Twins");
$eRoc = new artist("5kadFhaVFgdn1J4rX3HqB2","E-Roc");
$glennKaiser = new artist("3G5wgSAeFzEa6Jv5UNDs4N","Glenn Kaiser");
$resurrectionBand = new artist("3MAQykZ3MwPcviv5eIVqgb","Ressurection Band");
$xlDBD = new artist("3h66yQiOXZpT6AV2Np5yIq","X.L. and DBD");
$playdough = new artist("2hjEGPXpN1BGpNjODQ4ImL","Playdough");
$crucified = new artist("6K1KoB3WXLSOaphD2YoWNU","The Crucified");
$chagallGuevara = new artist("0p9uD4WGPHqMicwXm3Kavk","Chagall Guevara");


$xianArtists = array ("7hW3Ezs4uzy0QQvdnF0Imi","6lE1ly8K8H7u8k2ej2plvv","5WJ6VEY43MOngJJJNabAId","3G7qoMSLvu9Pmb0xGtf9fl","0t1uzfQspxLvAifZLdmFe2","5MQsxr7sbsewUTIEEYxauR","0PGxNwykt4KgnvSnNHVUSZ","3lgxzeCbj6oMQMmaUhH2H6","0sNPk98oyaTeaRojDYglDY","1P72cdCRCvytPnFLkGSeVm","3PXQl96QHBJbzAGENdJWc1","1zK4ACgLi1lVPpfmmcwOTh","1LZqY4X3vFpZaEgXkmiYrG","5kadFhaVFgdn1J4rX3HqB2","3G5wgSAeFzEa6Jv5UNDs4N","3MAQykZ3MwPcviv5eIVqgb","3h66yQiOXZpT6AV2Np5yIq","2hjEGPXpN1BGpNjODQ4ImL","6K1KoB3WXLSOaphD2YoWNU");

$BonJovi = new artist ("58lV9VcRSjABbAbfWS6skp", "Bon Jovi");
$KateBush = new artist ("1aSxMhuvixZ8h9dK9jIDwL", "Kate Bush");
$Cars = new artist ("6DCIj8jNaNpBz8e5oKFPtp", "The Cars");
$DepecheMode = new artist ("762310PdDnwsDxAQxzQkfX", "Depeche Mode");
$DireStraits = new artist ("0WwSkZ7LtFUFjGjMZBMt6T", "Dire Straits");
$Eurythmics = new artist ("0NKDgy9j66h3DLnN8qu1bB", "Eurythmics");
$JGeilsBand = new artist ("69Mj3u4FTUrpyeGNSIaU6F", "J. Geils Band");
$JudasPriest = new artist ("2tRsMl4eGxwoNabM08Dm4I","Judas Priest");
$LLCoolJ = new artist ("1P8IfcNKwrkQP5xJWuhaOC", "LL Cool J");
$MC5 = new artist ("4WquJweZPIK9qcfVFhTKvf", "The MC5");
$TheMeters = new artist ("2JRvXPGWiINrnJljNJhG5s", "The Meters");
$MoodyBlues = new artist ("5BcZ22XONcRoLhTbZRuME1", "Moody Blues");
$Radiohead = new artist ("4Z8W4fKeB5YxbusRsdQVPb", "Radiohead");
$RageAgainstTheMachine = new artist ("2d0hyoQ5ynDBnkvAbJKORj", "Rage Against the Machine");
$RufusFeatChakaKhan = new artist ("1YLsqPcFg1rj7VvhfwnDWm", "Rufus featuring Chaka Khan");
$NinaSimone = new artist ("7G1GBhoKtEPnP86X2PvEYO", "Nina Simone");
$SisterRosettaTharpe = new artist ("2dXf5lu5iilcaTQJZodce7", "Sister Rosetta Tharpe");
$LinkWray = new artist ("2vQavlZtDA660mnZotYIto", "Link Wray");
$Zombies = new artist ("2jgPkn6LuUazBoBk6vvjh5", "The Zombies");
$TravelingWilburys = new artist ("2hO4YtXUFJiUYS2uYFvHNK", "Traveling Wilburys");
$ChakaKhan = new artist ("6mQfAAqZGBzIfrmlZCeaYT", "Chaka Khan");

$nominees2018 = array ("58lV9VcRSjABbAbfWS6skp", "1aSxMhuvixZ8h9dK9jIDwL", "6DCIj8jNaNpBz8e5oKFPtp", "762310PdDnwsDxAQxzQkfX", "0WwSkZ7LtFUFjGjMZBMt6T", "0NKDgy9j66h3DLnN8qu1bB", "69Mj3u4FTUrpyeGNSIaU6F", "2tRsMl4eGxwoNabM08Dm4I", "1P8IfcNKwrkQP5xJWuhaOC", "4WquJweZPIK9qcfVFhTKvf", "2JRvXPGWiINrnJljNJhG5s", "5BcZ22XONcRoLhTbZRuME1", "4Z8W4fKeB5YxbusRsdQVPb", "2d0hyoQ5ynDBnkvAbJKORj", "1YLsqPcFg1rj7VvhfwnDWm", "7G1GBhoKtEPnP86X2PvEYO", "2dXf5lu5iilcaTQJZodce7", "2vQavlZtDA660mnZotYIto", "2jgPkn6LuUazBoBk6vvjh5", "2hO4YtXUFJiUYS2uYFvHNK", "6mQfAAqZGBzIfrmlZCeaYT");


$allArtists = array ("3k4YA0uPsWc2PuOQlJNpdH","3EhbVgyfGd7HkpsagwL9GS","0oSGxfWSnnOXhD2fKuz2Gy","74ASZWbe4lXaubB36ztrGX","7dnB1wSxbYa8CejeVg98hz","3lPQ2Fk5JOwGWAF3ORFCqH","4BFMTELQyWJU1SwqcXMBm3","3eqjTLE0HfPfh78zjh6TqT","07XSN3sPlIlB2L2XNcTwJw","33EUXrFKGjpUSGacqEHhU4","1l8grPt6eiOS4YlzjIs0LF","22bE4uQ6baNwSHPVcDxLCe","2UZMlIwnkgAEDBsw1Rejkn","4tX2TplrkIP4v05BNC903e","58lV9VcRSjABbAbfWS6skp", "1aSxMhuvixZ8h9dK9jIDwL", "6DCIj8jNaNpBz8e5oKFPtp", "762310PdDnwsDxAQxzQkfX", "0WwSkZ7LtFUFjGjMZBMt6T", "0NKDgy9j66h3DLnN8qu1bB", "69Mj3u4FTUrpyeGNSIaU6F", "2tRsMl4eGxwoNabM08Dm4I", "1P8IfcNKwrkQP5xJWuhaOC", "4WquJweZPIK9qcfVFhTKvf", "2JRvXPGWiINrnJljNJhG5s", "5BcZ22XONcRoLhTbZRuME1", "4Z8W4fKeB5YxbusRsdQVPb", "2d0hyoQ5ynDBnkvAbJKORj", "1YLsqPcFg1rj7VvhfwnDWm", "7G1GBhoKtEPnP86X2PvEYO", "2dXf5lu5iilcaTQJZodce7", "2vQavlZtDA660mnZotYIto", "2jgPkn6LuUazBoBk6vvjh5", "2hO4YtXUFJiUYS2uYFvHNK", "6mQfAAqZGBzIfrmlZCeaYT","711MCceyCBcFnzjGY4Q7Un","5a2EaR3hamoenG9rDuVn8j","485uL27bPomh29R4JmQehQ","6kACVPfCOnqzgfEF5ryl0x","2AM4ilv6UzW0uMRuqKtDgN","51Blml2LZPmy7TTiAg47vQ","5M52tdBnJaKSvOpJGz8mfZ","6mdiAmATAx73kdxrNrnlao","4UjiBRkTw9VmvDZiJZKPJ7","6ZLTlhejhndI4Rh53vYhrY","4CYeVo5iZbtYGBN4Isc3n6","4M3c7tg4BzLQ5pIOupZL65","6w6z8m4WXX7Tub4Rb6Lu7R","5KQMtyPE8DCQNUzoNqlEsE","7hW3Ezs4uzy0QQvdnF0Imi","6lE1ly8K8H7u8k2ej2plvv","5WJ6VEY43MOngJJJNabAId","3G7qoMSLvu9Pmb0xGtf9fl","0t1uzfQspxLvAifZLdmFe2","5MQsxr7sbsewUTIEEYxauR","0PGxNwykt4KgnvSnNHVUSZ","3lgxzeCbj6oMQMmaUhH2H6","0sNPk98oyaTeaRojDYglDY","1P72cdCRCvytPnFLkGSeVm","3PXQl96QHBJbzAGENdJWc1","1zK4ACgLi1lVPpfmmcwOTh","1LZqY4X3vFpZaEgXkmiYrG","5kadFhaVFgdn1J4rX3HqB2","3G5wgSAeFzEa6Jv5UNDs4N","3MAQykZ3MwPcviv5eIVqgb","3h66yQiOXZpT6AV2Np5yIq","2hjEGPXpN1BGpNjODQ4ImL","6K1KoB3WXLSOaphD2YoWNU");

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


function inserttArtistsAndPop ($artistsToInsert) {

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

	$bunchofartists = $GLOBALS['api']->getArtists($artistsToInsert);

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
		ORDER BY b.pop ASC";

	$getit = $connekt->query($artistInfoRecent);

	while ($row = mysqli_fetch_array($getit)) {
		// $artistID = $row["artistID"];
		$artistName = $row["artistName"];
		$artistPop = $row["pop"];
		$popDate = $row["date"];
		
		echo "<tr>";
		echo "<td>" . $artistName . "</td>";
		echo "<td>" . $artistPop . "</td>";
		echo "<td>" . $popDate . "</td>";
		echo "</tr>";
	}
}

?>