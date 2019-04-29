<?php

require_once '../rockdb.php';
require( "class.artist.php" );

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect. Screwed up like this: ' . mysqli_connect_error() . '.</p>';
};

// if any of these did not come through, the defaults are the basic starting sort from the sql query
$artistID = "artistID";
$columnName = "year";
$currentOrder = "ASC";

if ( !empty( $_POST[ "artistID" ] ) ) {
	$artistID = $_POST[ "artistID" ];
}

if ( !empty( $_POST[ "columnName" ] ) ) {
    // if the column name came through, use it
	$columnName = $_POST[ "columnName" ];
}

if ( !empty( $_POST[ "currentOrder" ] ) ) {
    // if the current order came through, use it
	$currentOrder = $_POST[ "currentOrder" ];
}

if ( $currentOrder == "DESC" ) {
	$newOrder = "ASC";
}

if ($currentOrder == "ASC") {
    $newOrder = "DESC";
}

// These next three variables are for building the TH table headers. 
// They're the defaults-in-waiting, I guess
// The table is initially sorted in chronological order using the Year Released column in ASC order.
// Clicking the header toggles it to DESC so next time it should toggle to ASC
$yearNewOrder = "ASC";
// The other two columns are not sorted. Clicking their header sorts them ASC so next time 

$popNewOrder = "ASC";

// For the clicked column
/*
if ( $columnName == "albumName" and $currentOrder == "ASC" ) {
	$albumNameNewOrder = "DESC";
}
*/

$albumNameNewOrder = "unsorted";

if ( $columnName == "albumName" ) {
	if ($currentOrder == "unsorted" or $currentOrder == "DESC") {
		$albumNameNewOrder = "ASC";
		$newOrder = "ASC";
	} else {
		$albumNameNewOrder = "DESC";
		$newOrder = "DESC";
	};
};

if ( $columnName == "year" and $currentOrder == "ASC" ) {
	$yearNewOrder = "DESC";
}

/*
if ( $columnName == "pop" and $currentOrder == "ASC" ) {
	$popNewOrder = "DESC";
}
*/

$popNewOrder = "unsorted";

if ( $columnName == "pop" ) {
	if ($currentOrder == "unsorted" or $currentOrder == "ASC") {
		$popNewOrder = "DESC";
		$newOrder = "DESC";
	} else {
		$popNewOrder = "ASC";
		$newOrder = "ASC";
	};
};

$listenersNewOrder = "unsorted";

if ( $columnName == "albumListeners" ) {
	if ($currentOrder == "unsorted" or $currentOrder == "ASC") {
		$listenersNewOrder = "DESC";
		$newOrder = "DESC";
	} else {
		$listenersNewOrder = "ASC";
		$newOrder = "ASC";
	};
};

$playcountNewOrder = "unsorted";

if ( $columnName == "albumPlaycount" ) {
	if ($currentOrder == "unsorted" or $currentOrder == "ASC") {
		$playcountNewOrder = "DESC";
		$newOrder = "DESC";
	} else {
		$playcountNewOrder = "ASC";
		$newOrder = "ASC";
	};
};

$sortScabies = "SELECT a.albumName, a.year, a.albumArtSpot, a.tracksTotal, z.artistName, p1.pop, p1.date, a.albumSpotID, f1.albumMBID, f1.dataDate, f1.albumListeners, f1.albumPlaycount
	FROM (SELECT
				y.albumSpotID AS albumSpotID,
				y.albumMBID AS albumMBID,
				y.albumName AS albumName,
				y.artistID AS artistID,
				y.tracksTotal AS tracksTotal,
				y.albumArtSpot AS albumArtSpot,
				y.year AS year
			FROM albums y 
			WHERE y.artistID = '$artistID') a
	JOIN artists z ON z.artistID = '$artistID'
	JOIN (SELECT p.*
			FROM popAlbums p
			INNER JOIN (SELECT albumSpotID, pop, max(date) AS MaxDate
						FROM popAlbums  
						GROUP BY albumSpotID) groupedp
			ON p.albumSpotID = groupedp.albumSpotID
			AND p.date = groupedp.MaxDate) p1 
	ON a.albumSpotID = p1.albumSpotID
	LEFT JOIN (SELECT f.*
			FROM albumsLastFM f
			INNER JOIN (SELECT albumMBID, albumListeners, albumPlaycount, max(dataDate) AS MaxDataDate
			FROM albumsLastFM
			GROUP BY albumMBID) groupedf
			ON f.albumMBID = groupedf.albumMBID
			AND f.dataDate = groupedf.MaxDataDate) f1
	ON a.albumMBID = f1.albumMBID
				ORDER BY " . $columnName . " " . $newOrder . ";";

$sortit = $connekt->query( $sortScabies );

if ( !$sortit ) {
	echo '<p>Cursed-Crap. Did not run the query. Screwed up like this: ' . mysqli_error($connekt) . '</p>';
}

if(!empty($sortit))	 { ?>

<table class="table" id="recordCollection">
	
<thead>
<tr>
<th>Cover Art</th>
<!--
<th>Album Spotify ID</th>
<th>albumMBID</th>
-->
	<th onClick="sortColumn('albumName', '<?php echo $albumNameNewOrder; ?>', '<?php echo $artistID; ?>')"><div class="pointyHead">Album Name</div></th>
	<th onClick="sortColumn('year', '<?php echo $yearNewOrder; ?>', '<?php echo $artistID; ?>')"><div class="pointyHead popStyle">Released</div></th>
<!--
<th><div class="pointyHead popStyle">Total<br>Tracks</div></th>
<th class="popStyle">Spotify<br>Data Date</th>
-->
	<th onClick="sortColumn('pop', '<?php echo $popNewOrder; ?>', '<?php echo $artistID; ?>')"><div class="pointyHead popStyle">Spotify<br>Popularity</div></th>
<!--
<th>LastFM<br>Data Date</th>
-->
<th onClick="sortColumn('artistListeners', '<?php echo $listenersNewOrder; ?>')"><div class="pointyHead rightNum">LastFM<br>Listeners</div></th>
<th onClick="sortColumn('artistPlaycount', '<?php echo $playcountNewOrder; ?>')"><div class="pointyHead rightNum">LastFM<br>Playcount</div></th>
</tr>
</thead>
	
<tbody>

<?php
							  
while ( $row = mysqli_fetch_array( $sortit ) ) {
	$artistName = $row['artistName'];
	if (is_null($row['albumArtSpot'])) {
		$coverArt = $row['albumArtMB'];
	} else {
		$coverArt = $row['albumArtSpot'];
	};

	if (is_null($row['albumSpotID'])) {
		$albumID = $row['albumMBID'];
	} else {
		$albumID = $row['albumSpotID'];
	};

	//$albumSpotID = $row['albumSpotID'];
	//$albumMBID = $row['albumMBID'];

	$albumName = $row['albumName'];
	$tracksTotal = $row['tracksTotal'];
	$albumReleased = $row['year'];
	$albumPop = $row['pop'];
	$date = $row['date'];
	$lastFMDate = $row[ "dataDate" ];
	$albumListenersNum = $row[ "albumListeners"];
	$albumListeners = number_format ($albumListenersNum);
	if (!$albumListeners > 0) {
		$albumListeners = "n/a";
	};
	$albumPlaycountNum = $row[ "albumPlaycount"];
	$albumPlaycount = number_format ($albumPlaycountNum);
	if (!$albumPlaycount > 0) {
		$albumPlaycount = "n/a";
	};

?>

	<tr>
	<td><img src='<?php echo $coverArt ?>' height='64' width='64'></td>
<!--
<td><?php //echo $albumSpotID ?></td>
<td><?php //echo $albumMBID ?></td>
-->
		<td><a href='https://www.roxorsoxor.com/poprock/thisAlbum_TracksList.php?albumID=<?php echo $albumID ?>'><?php echo $albumName ?></a></td>
		<td class="popStyle"><?php echo $albumReleased ?></td>
<!--
<td class="popStyle"><?php //echo $tracksTotal ?></td>
<th class="popStyle"><?php //echo $date ?></th>
-->
		<td class="popStyle"><?php echo $albumPop ?></td>
<!--
<td class="popStyle"><?php //echo $lastFMDate ?></td>
-->
		<td class="rightNum"><?php echo $albumListeners ?></td>
		<td class="rightNum"><?php echo $albumPlaycount ?></td>
	</tr>

<?php
} // end of while
?>
</tbody>
</table>
<?php
} // end of if
?>