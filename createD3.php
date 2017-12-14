<?php

$host = 'localhost';
$db = 'poprock';
$un = 'jay';
$magicword = 'booger';
$charset = 'utf8';

$conn = mysqli_connect($host, $un, $magicword, $db);

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

$artistInfoRecent = "	SELECT a.artistID, a.artistName, b.pop, b.date 
						FROM artists a
							INNER JOIN popArtists b ON a.artistID = b.artistID
								WHERE b.date = (SELECT max(b2.date)
												FROM popArtists b2)
						ORDER BY b.pop ASC";

$result = mysqli_query($conn, $artistInfoRecent);

function consoleLog ($data) {
	echo '<script>';
	echo 'console.log('. json_encode($data) .')';
	echo '</script>';
}

if (mysqli_num_rows($result) > 0) {
	$rows = array();
	while ($row = mysqli_fetch_array($result)) {
		$rows[] = $row;
	}
	echo json_encode($rows);
	// consoleLog($rows);
}

else {
	echo "Nope. Nothing to see here.";
}

mysqli_close($conn);

?>