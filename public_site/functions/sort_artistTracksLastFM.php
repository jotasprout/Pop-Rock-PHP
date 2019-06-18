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

$gatherTrackInfoLastFM = "SELECT v.artistMBID, v.artistName, v.trackName, v.albumName, v.trackListeners, v.trackPlaycount, max(v.dataDate) AS MaxDataDate
					FROM (
						SELECT z.artistMBID, z.trackMBID, z.trackName, z.albumName, z.artistName, p.dataDate, p.trackListeners, p.trackPlaycount
							FROM (
								SELECT t.*, r.albumName, a.artistName, a.artistMBID
									FROM tracksMB t
									INNER JOIN albumsMB r ON r.albumMBID = t.albumMBID
									JOIN artistsMB a ON r.artistMBID = a.artistMBID
									WHERE a.artistMBID = '$artistMBID'
							) z
						JOIN tracksLastFM p 
							ON z.trackMBID = p.trackMBID					
					) v
					GROUP BY v.trackMBID
					ORDER BY " . $columnName . " " . $newOrder . ";";

$sortit = $connekt->query( $gatherTrackInfoLastFM );

if ( !$sortit ) {
	echo '<p>Cursed-Crap. Did not run the query because ' . mysqli_error($connekt) . '.</p>';
}

if(!empty($sortit)) { ?>

<table class="table" id="tableotracks">
<thead>
<tr>
	<th onClick="sortColumn('albumName', '<?php echo $albumNameNewOrder; ?>', '<?php echo $artistMBID ?>', '<?php echo $source ?>')"><div class="pointyHead">Album Title</div></th>
	<th onClick="sortColumn('trackName', '<?php echo $trackNameNewOrder; ?>', '<?php echo $artistMBID ?>', '<?php echo $source ?>')"><div class="pointyHead">Track Title</div></th>

	<th class="popStyle">LastFM<br>Data Date</th>
	<th class="rightNum pointyHead" onClick="sortColumn('trackListeners', '<?php echo $popNewOrder; ?>', '<?php echo $artistMBID ?>', '<?php echo $source ?>')">LastFM<br>Listeners</th>
	<th class="rightNum pointyHead" onClick="sortColumn('trackPlaycount', '<?php echo $popNewOrder; ?>', '<?php echo $artistMBID ?>', '<?php echo $source ?>')">LastFM<br>Playcount</th>
	<th><div class="popStyle">LastFM<br>Ratio</div></th>
</tr>
</thead>

	<tbody>
	<?php
		while ( $row = mysqli_fetch_array( $sortit ) ) {
			$albumName = $row[ "albumName" ];
			$trackName = $row[ "trackName" ];
			//$trackMBID = $row[ "trackMBID" ];

			$lastFMDate = $row[ "MaxDataDate" ];
			$trackListenersNum = $row["trackListeners"];
			$trackListeners = number_format ($trackListenersNum);

			$trackPlaycountNum = $row["trackPlaycount"];
			$trackPlaycount = number_format ($trackPlaycountNum);
			$trackRatio = "1:" . floor($trackPlaycountNum/$trackListenersNum);
	?>
			<tr>
				<td><?php echo $albumName ?></td>
				<td><?php echo $trackName ?></td>

				<td class="popStyle"><?php echo $lastFMDate ?></td>
				<td class="rightNum"><?php echo $trackListeners ?></td>
				<td class="rightNum"><?php echo $trackPlaycount ?></td>
				<td class="popStyle"><?php echo $trackRatio ?></td>
			</tr>
	<?php 
		} // end of while
	?>

	</tbody>
</table>
<?php 
	} // end of if
?>