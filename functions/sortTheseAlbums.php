<?php

require_once '../rockdb.php';
require( "class.artist.php" );

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

// if any of these did not come through, the defaults are the basic starting sort from the sql query
$artistID = "artistID";
$sortThisColumn = "year";
$currentOrder = "ASC";

if ( !empty( $_POST[ "artistID" ] ) ) {
	$artistID = $_POST[ "artistID" ];
}

if ( !empty( $_POST[ "sortThisColumn" ] ) ) {
    // if the column name came through, use it
    // echo $_POST[ "sortThisColumn" ] . "<br>";
	$sortThisColumn = $_POST[ "sortThisColumn" ];
}

if ( !empty( $_POST[ "currentOrder" ] ) ) {
    // if the current order came through, use it
    // echo $_POST[ "currentOrder" ] . "<br>";
	$currentOrder = $_POST[ "currentOrder" ];
}

// These next two statements are only for the SQL query
$usingThisOrder = "ASC";

if ($currentOrder == "ASC") {
    $usingThisOrder = "DESC";
}

// These next three variables are for building the TH table headers. 
// They're the defaults-in-waiting, I guess
// The table is initially sorted in chronological order using the Year Released column in ASC order.
// Clicking the header toggles it to DESC so next time it should toggle to ASC
$yearNewOrder = "ASC";
// The other two columns are not sorted. Clicking their header sorts them ASC so next time 
$albumNameNewOrder = "ASC";
$popNewOrder = "ASC";

// For the clicked column
if ( $sortThisColumn == "albumName" and $currentOrder == "ASC" ) {
	$albumNameNewOrder = "DESC";
}

if ( $sortThisColumn == "year" and $currentOrder == "ASC" ) {
	$yearNewOrder = "DESC";
}

if ( $sortThisColumn == "pop" and $currentOrder == "ASC" ) {
	$popNewOrder = "DESC";
}

$sortScabies = "SELECT a.albumName, a.albumID, a.year, a.albumArt, z.artistName, p1.pop, p1.date
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
				ORDER BY " . $sortThisColumn . " " . $usingThisOrder . ";";

$sortit = $connekt->query( $sortScabies );

if ( !$sortit ) {
	echo ('Cursed-Crap. Did not run the query.');
}

if(!empty($sortit))	 { ?>

<table class="table-content" id="recordCollection">
	
<thead>
	<tr>
		  <th>Album Art</th>
		  <th>Album Spotify ID</th>
		<th onClick="sortColumn('albumName', '<?php echo $albumNameNewOrder; ?>', '<?php echo $artistID; ?>')"><div class="pointyHead">Album Name</div></th>
		<th onClick="sortColumn('year', '<?php echo $yearNewOrder; ?>', '<?php echo $artistID; ?>')"><div id="pointyHead">Released</div></th>
		<th onClick="sortColumn('pop', '<?php echo $popNewOrder; ?>', '<?php echo $artistID; ?>')">Popularity</th>

		<!--
		<th>1 day</th>
		<th>7 days</th>
		<th>30 days</th>
		<th>90 days</th>
		<th>180 days</th>
		<th>Date</th>	
		--> 
	</tr>
</thead>
	
<tbody>

<?php
							  
while ( $row = mysqli_fetch_array( $sortit ) ) {
	// $artistID = $row["artistID"];
	$artistName = $row[ 'artistName' ];
	$albumArt = $row[ 'albumArt' ];
	$albumID = $row[ 'albumID' ];
	$albumName = $row[ 'albumName' ];
	$albumReleased = $row[ 'year' ];
	$albumPop = $row[ 'pop' ];
	$date = $row[ 'date' ];

?>

	<tr>
		<td><img src='<?php echo $albumArt; ?>' height='64' width='64'></td>
		<td><?php echo $albumID; ?></td>
		<td><?php echo $albumName; ?></td>
		<td><?php echo $albumReleased; ?></td>
		<td><?php echo $albumPop; ?></td>
		<!--
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		<td>*</td>
		-->
	</tr>

<?php
} // end of while
?>
</tbody>
</table>
<?php
} // end of if
?>