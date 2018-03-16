<?php

// $artistAlbums = array ();
// include 'sesh.php';
// $artistID = $_SESSION['artist'];
// $_SESSION['artist'] = $artistID;

require_once 'rockdb.php';
require ("class.artist.php");

function sortTheseAlbums ($artistID) {

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};

$sortBy = "a.year";
$order = "ASC";

if (!empty($POST_["sortBy"])) {
	$sortBy = $_POST["sortBy"];
}

if (!empty($POST_["order"])) {
	$order = $_POST["order"];
}

$albumNameNextOrder = "ASC";
$yearNextOrder = "ASC";
$popNextOrder = "ASC";

if ($sortBy == $albumName and $order == "ASC") {
	$albumNameNextOrder = "DESC";
}

if ($sortBy == $albumReleased and $order == "ASC") {
	$yearNextOrder = "DESC";
}

if ($sortBy == $albumPop and $order == "ASC") {
	$albumPopNextOrder = "DESC";
}

$sortScabies = "SELECT a.albumName, a.year, a.albumArt, z.artistName, p1.pop, p1.date
					FROM (SELECT
								y.albumID AS albumID,
								y.albumName AS albumName,
								y.artistID AS artistID,
								y.albumArt AS albumArt,
								y.year AS year
							FROM albums y 
							WHERE y.artistID = '$artistID') a
					JOIN artists z ON z.artistID = '$artistID'
					JOIN (SELECT p.*
							FROM popAlbums p
							INNER JOIN (SELECT albumID, pop, max(date) AS MaxDate
										FROM popAlbums  
										GROUP BY albumID) groupedp
							ON p.albumID = groupedp.albumID
							AND p.date = groupedp.MaxDate) p1 
					ON a.albumID = p1.albumID
					ORDER BY " . $sortBy . " " . $order . ";";

$sortit = $connekt->query($sortScabies);

if(!$sortit){
	echo 'Cursed-Crap. Did not run the query.';
}

// NEED HEADERS HERE

while ($row = mysqli_fetch_array($sortit)) {
	// $artistID = $row["artistID"];
	$artistName = $row['artistName'];
	$albumArt = $row['albumArt'];
	$albumName = $row['albumName'];
	$albumReleased = $row['year'];
	$albumPop = $row['pop'];
	$date = $row['date'];

	// $rows[] = $row;
	
	echo "<tr>";
	echo "<td><img src='" . $albumArt . "' height='64' width='64'></td>";
	echo "<td>" . $albumName . "</td>";
	echo "<td>" . $albumReleased . "</td>";
	echo "<td>" . $albumPop . "</td>";
	echo "<td>" . $date . "</td>";
	echo "</tr>";

}

// echo json_encode($rows);
// make the above echo a js script that sends the json to the console

sortTheseAlbums ($artistID);

}


?>