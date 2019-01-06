<?php

require_once '../rockdb.php';
require( "class.artist.php" );

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

// Rock en Espanol

$artistInfoRecentWithArt = "SELECT a.artistID AS artistID, a.artistArt AS artistArt, a.artistName AS artistName, p1.pop AS pop, p1.date AS date
    FROM artists a
    JOIN (SELECT p.*
			FROM popArtists p
			INNER JOIN (SELECT artistID, pop, max(date) AS MaxDate
						FROM popArtists  
						GROUP BY artistID) groupedp
			ON p.artistID = groupedp.artistID
			AND p.date = groupedp.MaxDate) p1
	ON a.artistID = p1.artistID
	WHERE a.artistID IN ('7CJiKj8TrQSms0WSCKbHm4', '4PtVXWSOmF4Tox1jj6ctSq', '3MqjsWDLhq8SyY6N3PE8yW', '3oNy8cjBtJzLC07I70sklp', '5XsWrYhwadPBjW20qYbdZg', '2mSHY8JOR0nRi3mtHqVa04', '3qAPxVwIQRBuz5ImPUxpZT', '27Owkm4TGlMqb0BqaEt3PW', '2QWIScpFDNxmS6ZEMIUvgm', '60uh2KYYSCqAgJNxcU4DA0', '4U7lXyKdSf1JbM1aXvsodC', '6IdtcAwaNVAggwd6sCKgTI')    
    ORDER BY a.artistName ASC";
    

$result = mysqli_query($connekt, $artistInfoRecentWithArt);

if (mysqli_num_rows($result) > 0) {
	$rows = array();
	while ($row = mysqli_fetch_array($result)) {
		$rows[] = $row;
	}
	echo json_encode($rows);
}

else {
	echo "Nope. Nothing to see here.";
}

mysqli_close($connekt);

?>