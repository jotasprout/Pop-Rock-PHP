<?php
	// PHP code in a more secure location
	require_once 'rockdb.php';
    
    $insertVampires = "INSERT INTO artists (artistID,artistName) VALUES('3k4YA0uPsWc2PuOQlJNpdH','Hollywood Vampires')";
 
	$connekt = new mysqli($host, $un, $magicword, $db);
	
    if (!$connekt) {
        echo 'Darn. Did not connect.';
    };
    
    // $rockon = $connekt->query($insertArtist);
    $rockout = $connekt->query($insertVampires);
    
    // Feedback of whether INSERT worked or not
    if(!$rockout){
        echo 'Triple-Crap. Could not insert Hollywood Vampires.';
        }

    // When attempt is complete, connection closes
    mysqli_close($connekt);
?>
