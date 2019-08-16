<?php
require_once '../rockdb.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$dragdrop = array ('6ZLTlhejhndI4Rh53vYhrY', '4UjiBRkTw9VmvDZiJZKPJ7', '4CYeVo5iZbtYGBN4Isc3n6', '5M52tdBnJaKSvOpJGz8mfZ', '36QJpDe2go2KgaRleHCDTp', '6mdiAmATAx73kdxrNrnlao', '0oSGxfWSnnOXhD2fKuz2Gy', '33EUXrFKGjpUSGacqEHhU4', '3lPQ2Fk5JOwGWAF3ORFCqH', '3qm84nBOXUEQ2vnTfUTTFC', '2x9SpqnPi8rlE9pjHBwmSC', '6SLAMfhOi7UJI0fMztaK0m', '1bDWGdIC2hardyt55nlQgG', '711MCceyCBcFnzjGY4Q7Un', '74ASZWbe4lXaubB36ztrGX', '485uL27bPomh29R4JmQehQ', '3eqjTLE0HfPfh78zjh6TqT', '7HL4id2U7FSDJtfKQHMgQx', '762310PdDnwsDxAQxzQkfX', '4CYeVo5iZbtYGBN4Isc3n6', '0lZoBs4Pzo7R89JM9lxwoT', '5KQMtyPE8DCQNUzoNqlEsE', '1Qp56T7n950O3EGMsSl81D', '2NzvxoOoIshAvoQ2wYbZhj', '4xtWjIlVuZwTCeqVAsgEXy', '6kACVPfCOnqzgfEF5ryl0x', '2tRsMl4eGxwoNabM08Dm4I', '7dnB1wSxbYa8CejeVg98hz', '3fMbdgg4jU18AjLCKBhRSm', '6v8FB84lnmJs434UJf2Mrm', '4KWTAlx2RvbpseOGMEmROg', '2Hkut4rAAyrQxRdof7FVJq', '2UBTfUoLI07iRqGeUrwhZh', '6lE1ly8K8H7u8k2ej2plvv', '21ysNsPzHdqYN2fQ75ZswG');

$thisarray = implode("', '", $dragdrop);

$artistPopCurrentWithArt = "SELECT a.artistSpotID AS artistSpotID, a.artistArtSpot AS artistArtSpot, a.artistNameSpot AS artistNameSpot, p1.pop AS pop, p1.date AS date
    FROM artistsSpot a
    JOIN (SELECT p.*
			FROM popArtists p
			INNER JOIN (SELECT artistSpotID, pop, max(date) AS MaxDate
						FROM popArtists  
						GROUP BY artistSpotID) groupedp
			ON p.artistSpotID = groupedp.artistSpotID
			AND p.date = groupedp.MaxDate) p1
	ON a.artistSpotID = p1.artistSpotID
	WHERE a.artistSpotID IN ('" . $thisarray . "')    
    ORDER BY a.artistNameSpot ASC";

$artistInfoWithArt = "SELECT a.artistSpotID AS artistSpotID, a.artistArtSpot AS artistArtSpot, a.artistNameSpot AS artistNameSpot
    FROM artistsSpot a
	WHERE a.artistSpotID IN ('" . $thisarray . "')    
    ORDER BY a.artistNameSpot ASC";

$result = mysqli_query($connekt, $artistPopCurrentWithArt);

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