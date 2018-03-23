<?php

include 'sesh.php';
$artistID = $_SESSION['artist'];
$_SESSION['artist'] = $artistID;
require_once 'rockdb.php';
require( "class.artist.php" );

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$sortBy = "year";
$order = "ASC";

if ( !empty( $_POST[ "sortBy" ] ) ) {
	// echo $_POST[ "sortBy" ] . "<br>";
	$sortBy = $_POST[ "sortBy" ];
}

if ( !empty( $_POST[ "order" ] ) ) {
	// echo $order = $_POST[ "order" ] . "<br>";
	$order = $_POST[ "order" ];
}

$albumNameNextOrder = "ASC";
$yearNextOrder = "ASC";
$popNextOrder = "ASC";

if ( $sortBy == "albumName" and $order == "ASC" ) {
	$albumNameNextOrder = "DESC";
}

if ( $sortBy == "year" and $order == "ASC" ) {
	$yearNextOrder = "DESC";
}

if ( $sortBy == "pop" and $order == "ASC" ) {
	$popNextOrder = "DESC";
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

$sortit = $connekt->query( $sortScabies );

if ( !$sortit ) {
	echo 'Cursed-Crap. Did not run the query.';
}

if(!empty($sortit))	 { ?>

<table class="table-content">
	
<thead>
	<tr>
	  	<th>Album Art</th>
		<th onClick="sortColumn('albumName', '<?php echo $albumNameNextOrder; ?>')">Album Name</th>
		<th onClick="sortColumn('year', '<?php echo $yearNextOrder; ?>')">Released</th>
		<th onClick="sortColumn('pop', '<?php echo $popNextOrder; ?>')">Popularity</th>
		<th>Date</th>	 
	</tr>
</thead>
	
<tbody>

<?php
							  
while ( $row = mysqli_fetch_array( $sortit ) ) {
	// $artistID = $row["artistID"];
	$artistName = $row[ 'artistName' ];
	$albumArt = $row[ 'albumArt' ];
	$albumName = $row[ 'albumName' ];
	$albumReleased = $row[ 'year' ];
	$albumPop = $row[ 'pop' ];
	$date = $row[ 'date' ];

?>

	<tr>
		<td><img src='<?php echo $albumArt; ?>' height='64' width='64'></td>
		<td><?php echo $albumName; ?></td>
		<td><?php echo $albumReleased; ?></td>
		<td><?php echo $albumPop; ?></td>
		<td><?php echo $date; ?></td>
	</tr>

<?php
} // end of while
?>
</tbody>
</table>
<?php
} // end of if
?>