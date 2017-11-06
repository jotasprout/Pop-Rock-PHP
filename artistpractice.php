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
        
    $insertArtist = "
    INSERT INTO artists (
        artistID,
        artistName
        ) 
    VALUES(
        '$artistID',
        '$artistName',
    )"; 

    // $query = "SELECT * FROM cases ORDER BY cases.caseName ASC";

    // $showArtist = "SELECT * FROM artists ORDER BY artists.artistName ASC";
    
    // $rockon = $connekt->query($insertArtist);
    $rockout = $connekt->query($insertAlice);
    
    // Feedback of whether INSERT worked or not
    if(!$rockon){
       echo 'Double-Crap. Could not insert your Artist.';
    }
    
    // Feedback of whether INSERT worked or not
    if(!$rockout){
        echo 'Triple-Crap. Could not insert Alice.';
        }

    // When attempt is complete, connection closes
    mysqli_close($connekt);
?>
