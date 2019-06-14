<?php

require_once '../rockdb.php';
//require_once '../page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo '<p>Darn. Did not connect because ' . mysqli_connect_error() . '.</p>';
};

// if any of these did not come through, the defaults are the basic starting sort from the sql query
$artistMBID = "artistMBID";
$artistSpotID = "artistSpotID";
$columnName = "trackName";
$currentOrder = "ASC";
$source = $_POST[ "source" ];

// If POSTed columnNames came through, use them
if ( !empty( $_POST[ "artistSpotID" ] ) ) {
	$artistSpotID = $_POST[ "artistSpotID" ];
}

if ( !empty( $_POST[ "artistMBID" ] ) ) {
	$artistMBID = $_POST[ "artistMBID" ];
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

$gatherTrackInfoSpot = "SELECT v.trackSpotID, v.artistName, v.trackName, v.albumName, v.pop, max(v.date) AS MaxDate
					FROM (
						SELECT z.artistName, z.trackSpotID, z.trackName, z.albumName, p.date, p.pop
							FROM (
								SELECT t.*, r.albumName, a.artistName
									FROM tracks t
									INNER JOIN albums r ON r.albumSpotID = t.albumSpotID
									JOIN artists a ON r.artistSpotID = a.artistSpotID
									WHERE a.artistSpotID = '$artistSpotID'
							) z
						JOIN popTracks p 
							ON z.trackSpotID = p.trackSpotID					
					) v
					GROUP BY v.trackSpotID
					ORDER BY " . $columnName . " " . $newOrder . ";";
/*
$gathering = "";

if ( $source == "musicbrainz" ) {
	$gathering = $gatherTrackInfoLastFM;
};

if ( $source == "spotify" ) {
	$gathering = $gatherTrackInfoSpot;
};
*/
$sortit = $connekt->query( $gatherTrackInfoSpot );

if ( !$sortit ) {
	echo '<p>Cursed-Crap. Did not run the query because ' . mysqli_error($connekt) . '.</p>';
}

if(!empty($sortit)) { ?>

<table class="table" id="tableotracks">
<thead>
<tr>
	<th onClick="sortColumn('albumName', '<?php echo $albumNameNewOrder; ?>', '<?php echo $artistSpotID ?>', '<?php echo $source ?>')"><div class="pointyHead">Album Title</div></th>
	<th onClick="sortColumn('trackName', '<?php echo $trackNameNewOrder; ?>', '<?php echo $artistSpotID ?>', '<?php echo $source ?>')"><div class="pointyHead">Track Title</div></th>
	<th class="popStyle" onClick="sortColumn('pop', '<?php echo $popNewOrder; ?>', '<?php echo $artistSpotID ?>', '<?php echo $source ?>')"><div class="pointyHead">Spotify<br>Popularity</div></th>
	<!---->
	<th>Spotify<br>trackSpotID</th>
	<th>Spotify<br>Data Date</th>

</tr>
</thead>

	<tbody>
	<?php
		while ( $row = mysqli_fetch_array( $sortit ) ) {
			$albumName = $row[ "albumName" ];
			$trackName = $row[ "trackName" ];
			$trackSpotID = $row[ "trackSpotID" ];
			$trackPop = $row[ "pop" ];
			$popDate = $row[ "MaxDate" ];

	?>
			<tr>
				<td><?php echo $albumName ?></td>
				<td><?php echo $trackName ?></td>
				<td class="popStyle"><?php echo $trackPop ?></td>
				<td><?php echo $trackSpotID ?></td>
				<td><?php echo $popDate ?></td>
			
			</tr>
	<?php 
		} // end of while
	?>

	</tbody>
</table>
<?php 
	} // end of if
?>