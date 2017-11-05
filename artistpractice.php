<?php
	// PHP code in a more secure location
	require_once 'rockdb.php';

	$artistID = '3EhbVgyfGd7HkpsagwL9GS';
	$artistName = 'Alice Cooper';
 
	$connekt = new mysqli($host, $un, $magicword, $db);
	
    if (!$connekt) {
        echo 'did not connect';
    };
        
    $insertArtist = "
    INSERT INTO artists (
        artistID,
        artistName
        ) 
    VALUES(
        '$artistID',
        '$artistName',
    )"; 
    
    $rockon = $connekt->query($insertArtist);
    
    // Feedback of whether INSERT worked or not
    if(!$rockon){
          echo 'Double-Crap. Could not insert your albums.';
      }
    
    // When attempt is complete, connection closes
    mysqli_close($connekt);
?>
