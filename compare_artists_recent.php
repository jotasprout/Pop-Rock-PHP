<?php

require_once 'rockdb.php';

function compareArtistsRecent () {

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

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
    mysql_close($server);

}

compareArtistsRecent();

?>