<?php
	// PHP code in a more secure location
	require_once 'rockdb.php';

	$artistID = '3EhbVgyfGd7HkpsagwL9GS';
    $artistName = 'Alice Cooper';
    
    $insertAlice = "INSERT INTO artists (artistID,artistName) VALUES('3EhbVgyfGd7HkpsagwL9GS','Alice Cooper')";
 
	$connekt = new mysqli($host, $un, $magicword, $db);
	
    if (!$connekt) {
        echo 'Darn. Did not connect.';
    };
        
    $insertArtistsPopQuery = "
    INSERT INTO popArtists (
        artistID,
        artistPop
        ) 
    VALUES(
        '$artistID',
        '$artistPop',
    )"; 
    
    // $rockon = $connekt->query($insertArtist);
    $insertArtistsPopResult = $connekt->query($insertArtistsPopQuery);
    
    // Feedback of whether INSERT worked or not
    if(!$insertArtistsPopResult){
       echo "Quintuple-Crap. Could not insert your Artists' popularity.";
    }

    // When attempt is complete, connection closes
    mysqli_close($connekt);
?>
