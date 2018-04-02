<?php

require_once 'rockdb.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$artistInfoRecent = "SELECT a.artistID AS artistID, a.artistName AS artistName, b.pop AS pop, b.date AS date
    FROM artists a
        INNER JOIN popArtists b ON a.artistID = b.artistID
            WHERE b.date = (select max(b2.date)
                            FROM popArtists b2)
    ORDER BY b.pop DESC";

$getit = $connekt->query( $artistInfoRecent );

if(!$getit){ echo 'Cursed-Crap. Did not fetch anything.'; }

?>