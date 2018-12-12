<?php

$artistID = $_COOKIE['artistID'];

require_once '../rockdb.php';
require_once '../page_pieces/navbar_rock.php';
require_once '../page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$sortBy = "trackName";
$order = "DESC";

if ( !empty( $_POST[ "sortBy" ] ) ) {
	// echo $_POST[ "sortBy" ] . "<br>";
	$sortBy = $_POST[ "sortBy" ];
}

if ( !empty( $_POST[ "order" ] ) ) {
	// echo $order = $_POST[ "order" ] . "<br>";
	$order = $_POST[ "order" ];
}

$albumNameNextOrder = "ASC";
$trackNameNextOrder = "DESC";
$popNextOrder = "ASC";

if ( $sortBy == "albumName" and $order == "ASC" ) {
	$albumNameNextOrder = "DESC";
}

if ( $sortBy == "trackName" and $order == "DESC" ) {
	$trackNameNextOrder = "ASC";
}

if ( $sortBy == "pop" and $order == "ASC" ) {
	$popNextOrder = "DESC";
}

$gatherTrackInfo = "SELECT t.trackID, t.trackName, a.albumName, a.artistID, p1.pop, p1.date
						FROM tracks t
						INNER JOIN albums a ON a.albumID = t.albumID
						JOIN (SELECT p.* FROM popTracks p
								INNER JOIN (SELECT trackID, pop, max(date) AS MaxDate
											FROM popTracks  
											GROUP BY trackID) groupedp
								ON p.trackID = groupedp.trackID
								AND p.date = groupedp.MaxDate) p1 
						ON t.trackID = p1.trackID
						WHERE a.artistID = '$artistID'
						ORDER BY " . $sortBy . " " . $order . ";";

$sortit = $connekt->query( $gatherTrackInfo );

if ( !$sortit ) {
	echo 'Cursed-Crap. Did not run the query.';
}

if(!empty($sortit)) { ?>

<table class="table" id="tableotracks">
	<thead>
		<tr>
			<th onClick="sortColumn('albumName', '<?php echo $albumNameNextOrder; ?>')"><div class="pointyHead">Album Name</div></th>
			<th>trackID</th>
			<th onClick="sortColumn('trackName', '<?php echo $trackNameNextOrder; ?>')"><div class="pointyHead">Track</div></th>
			<th onClick="sortColumn('pop', '<?php echo $popNextOrder; ?>')"><div class="pointyHead">Track Popularity</div></th>
		</tr>
	</thead>

	<tbody>
	<?php
		while ( $row = mysqli_fetch_array( $sortit ) ) {
			$albumName = $row[ "albumName" ];
			$trackID = $row[ "trackID" ];
			$trackName = $row[ "trackName" ];
			$trackPop = $row[ "pop" ];
			$popDate = $row[ "date" ];
	?>
			<tr>
				<td><?php echo $albumName ?></td>
				<td><?php echo $trackID ?></td>
				<td><?php echo $trackName ?></td>
				<td><?php echo $trackPop ?></td>
			</tr>
	<?php 
		} // end of while
	?>

	</tbody>
</table>
<?php 
	} // end of if
?>