<?php

require_once '../rockdb.php';
require_once '../page_pieces/navbar_rock2.php';
require_once '../page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

// if any of these did not come through, the defaults are the basic starting sort from the sql query
$artistID = "artistID";
$columnName = "trackName";
$currentOrder = "ASC";

// If POSTed columnNames came through, use them
if ( !empty( $_POST[ "artistID" ] ) ) {
	$artistID = $_POST[ "artistID" ];
}

if ( !empty( $_POST[ "columnName" ] ) ) {
	$columnName = $_POST[ "columnName" ];
}

if ( !empty( $_POST[ "currentOrder" ] ) ) {
	$currentOrder = $_POST[ "currentOrder" ];
}

// Toggle sorting order

if ( $currentOrder == "DESC" ) {
	$newOrder = "ASC";
}

if ( $currentOrder == "ASC" ) {
	$newOrder = "DESC";
}

$albumNameNewOrder = "DESC";

if ( $columnName == "albumName" and $currentOrder == "DESC" ) {
	$albumNameNewOrder = "ASC";
}

$trackNameNewOrder = "DESC";

if ( $columnName == "trackName" and $currentOrder == "ASC" ) {
	$trackNameNewOrder = "DESC";
}

$popNewOrder = "ASC";

if ( $columnName == "pop" and $currentOrder == "ASC" ) {
	$popNewOrder = "DESC";
}

$gatherTrackInfo = "SELECT t.trackID, t.trackName, a.albumName, a.artistID, p1.pop, p1.date, f1.dataDate, f1.trackListeners, f1.trackPlaycount
						FROM tracks t
						INNER JOIN albums a ON a.albumID = t.albumID
						JOIN (SELECT p.* FROM popTracks p
								INNER JOIN (SELECT trackID, pop, max(date) AS MaxDate
											FROM popTracks  
											GROUP BY trackID) groupedp
								ON p.trackID = groupedp.trackID
								AND p.date = groupedp.MaxDate) p1 
						ON t.trackID = p1.trackID
							LEFT JOIN (SELECT f.*
								FROM tracksLastFM f
								INNER JOIN (SELECT trackMBID, trackListeners, trackPlaycount, max(dataDate) AS MaxDataDate
											FROM tracksLastFM  
											GROUP BY trackMBID) groupedf
								ON f.trackMBID = groupedf.trackMBID
								AND f.dataDate = groupedf.MaxDataDate) f1
						ON t.trackMBID = f1.trackMBID
						WHERE a.artistID = '$artistID'
						ORDER BY " . $columnName . " " . $newOrder . ";";

$sortit = $connekt->query( $gatherTrackInfo );

if ( !$sortit ) {
	echo 'Cursed-Crap. Did not run the query.';
}

if(!empty($sortit)) { ?>

<table class="table" id="tableotracks">
<thead>
<tr>
	<th onClick="sortColumn('albumName', '<?php echo $albumNameNewOrder; ?>', '<?php echo $artistID ?>')"><div class="pointyHead">Album Title</div></th>
	<th>Spotify<br>trackID</th>
	<th onClick="sortColumn('trackName', '<?php echo $trackNameNewOrder; ?>', '<?php echo $artistID ?>')"><div class="pointyHead">Track Title</div></th>
	<th>Spotify<br>Data Date</th>
	
	<th class="popStyle" onClick="sortColumn('pop', '<?php echo $popNewOrder; ?>', '<?php echo $artistID ?>')"><div class="pointyHead">Spotify<br>Popularity</div></th>
	<th>LastFM<br>Data Date</th>
	<th class="rightNum pointyHead">LastFM<br>Listeners</th>
	<th class="rightNum pointyHead">LastFM<br>Playcount</th>
</tr>
</thead>

	<tbody>
	<?php
		while ( $row = mysqli_fetch_array( $sortit ) ) {
			$albumName = $row[ "albumName" ];
			$trackName = $row[ "trackName" ];
			$trackID = $row[ "trackID" ];
			$trackPop = $row[ "pop" ];
			$popDate = $row[ "date" ];
			$lastFMDate = $row[ "dataDate" ];
			$trackListenersNum = $row["trackListeners"];
			$trackListeners = number_format ($trackListenersNum);
			if (!$trackListeners > 0) {
				$trackListeners = "n/a";
			};
			$trackPlaycountNum = $row["trackPlaycount"];
			$trackPlaycount = number_format ($trackPlaycountNum);
			if (!$trackPlaycount > 0) {
				$trackPlaycount = "n/a";
			};
	?>
			<tr>
				<td><?php echo $albumName ?></td>
				<td><?php echo $trackID ?></td>
				<td><?php echo $trackName ?></td>
				<td><?php echo $popDate ?></td>
				
				<td class="popStyle"><?php echo $trackPop ?></td>
				<td class="popStyle"><?php echo $lastFMDate ?></td>
				<td class="rightNum"><?php echo $trackListeners ?></td>
				<td class="rightNum"><?php echo $trackPlaycount ?></td>
			</tr>
	<?php 
		} // end of while
	?>

	</tbody>
</table>
<?php 
	} // end of if
?>