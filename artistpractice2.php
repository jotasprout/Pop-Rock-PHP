<?php

// PHP code in a more secure location
require_once 'rockdb.php';
$connekt = new mysqli($host, $un, $magicword, $db);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};
        
$showArtist = "SELECT * FROM artists ORDER BY artists.artistName ASC";

$rockaway = $connekt->query($showArtist);

// Feedback of whether SELECT worked or not
if(!$rockaway){
	echo 'Nope. Can not show your Artists.';
}

echo "<!DOCTYPE html><html><head><title>Artist Practice</title></head><body><table><thead><tr><th>Artist ID</th><th>Artist Name</th></tr></thead><tbody>";

// Create a row in HTML table for each row from database
while ($row = mysqli_fetch_array($rockaway)) {
	echo "<tr><td>" . $row["artistID"] . "</td><td>" . $row["artistName"] . "</td></tr>";
}

// Finish creating HTML table
echo "</tbody></table>";

// When attempt is complete, connection closes
mysqli_close($connekt);

?>
