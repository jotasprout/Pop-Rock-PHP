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

$happyScabies = "	SELECT a.albumName, a.year, z.artistName, p1.pop, p1.date
					FROM (SELECT
								y.albumID AS albumID,
								y.albumName AS albumName,
								y.artistID AS artistID,
								y.year AS year
							FROM albums y 
							WHERE y.artistID = '3PXQl96QHBJbzAGENdJWc1') a
					JOIN artists z ON z.artistID = '3PXQl96QHBJbzAGENdJWc1'
					JOIN (SELECT p.*
							FROM popAlbums p
							INNER JOIN (SELECT albumID, pop, max(date) AS MaxDate
										FROM popAlbums  
										GROUP BY albumID) groupedp
							ON p.albumID = groupedp.albumID
							AND p.date = groupedp.MaxDate) p1 
					ON a.albumID = p1.albumID
					ORDER BY a.year ASC;";						

$result = mysqli_query($conn, $happyScabies);

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
}

else {
	echo "Nope. Nothing to see here.";
}

mysqli_close($conn);

?>