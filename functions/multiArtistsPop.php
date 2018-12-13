<?php

$nominations = array ('0UKfenbZb15sqhfPC6zbt3', '4WquJweZPIK9qcfVFhTKvf', '0nJUwPwC9Ti4vvuJ0q3MfT', '1P8IfcNKwrkQP5xJWuhaOC', '2d0hyoQ5ynDBnkvAbJKORj', '0dmPX6ovclgOy8WWJaFEUU', '0Lpr5wXzWLtDWm1SjNbpPb', '1YLsqPcFg1rj7VvhfwnDWm');

$inductees = array ('7bu3H8JO7d0UbMoVzbo70s', '6H1RjVyNruCmrBEWRbD0VZ', '7crPfGd2k81ekOoSqQKWWz', '4qwGe91Bz9K2T8jXTZ815W', '4Z8W4fKeB5YxbusRsdQVPb', '3fhOTtm0LBJ3Ojn4hIljLo', '2jgPkn6LuUazBoBk6vvjh5');

require_once '../rockdb.php';
require( "class.artist.php" );

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};

$multiArtistPop = "SELECT a.artistID, a.artistArt , a.artistName, p.pop, p.date
    FROM artists a
    JOIN popArtists p ON p.artistID = a.artistID
	WHERE a.artistID IN ('7bu3H8JO7d0UbMoVzbo70s', '6H1RjVyNruCmrBEWRbD0VZ', '7crPfGd2k81ekOoSqQKWWz', '4qwGe91Bz9K2T8jXTZ815W', '4Z8W4fKeB5YxbusRsdQVPb', '3fhOTtm0LBJ3Ojn4hIljLo', '2jgPkn6LuUazBoBk6vvjh5')
	ORDER BY a.artistID ASC";

$getit = mysqli_query($connekt, $multiArtistPop);

if(!$getit){
	echo 'Cursed-Crap. Did not run the query.';
}	

if (mysqli_num_rows($getit) > 0) {
	$rows = array();
	while ($row = mysqli_fetch_array($getit)) {
		$rows[] = $row;
	}
	echo json_encode($rows);
}

else {
	echo "Nope. Nothing to see here.";
}

mysqli_close($connekt);

?>