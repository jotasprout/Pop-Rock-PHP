<?php

include 'sesh.php';
require_once 'rockdb.php';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
    echo 'Darn. Did not connect.';
};

$sortBy = "pop";
$order = "DESC";

if ( !empty( $_POST[ "sortBy" ] ) ) {
	// echo $_POST[ "sortBy" ] . "<br>";
	$sortBy = $_POST[ "sortBy" ];
}

if ( !empty( $_POST[ "order" ] ) ) {
	// echo $order = $_POST[ "order" ] . "<br>";
	$currentOrder = $_POST[ "order" ];
}

if ( $currentOrder == "ASC" ) {
	$newOrder = "DESC";
} else {
	$newOrder = "ASC";
}

$artistInfoRecentWithArt = "SELECT a.artistID AS artistID, a.artistArt AS artistArt, a.artistName AS artistName, p1.pop AS pop, p1.date AS date
    FROM artists a
    JOIN (SELECT p.*
			FROM popArtists p
			INNER JOIN (SELECT artistID, pop, max(date) AS MaxDate
						FROM popArtists  
						GROUP BY artistID) groupedp
			ON p.artistID = groupedp.artistID
			AND p.date = groupedp.MaxDate) p1
	ON a.artistID = p1.artistID
	ORDER BY p1.pop DESC";

$sortit = $connekt->query($artistInfoRecentWithArt); 

if (!$sortit) {
    echo 'Darn. No query.';
};

if (!empty($sortit)) { ?>

	<table class="table" id="tableoartists">
		<thead>
			<tr>
				<th>Pretty Face</th>
				<th onClick="sortColumn('artistName', '<?php echo $artistNameNextOrder; ?>')"><div class="pointyHead">Artist Name</div></th>
				<th onClick="sortColumn('pop', '<?php echo $popNextOrder; ?>')"><div class="pointyHead">Popularity</div></th>
				<th>Date</th>
				<!--
			
		--> 
			</tr>
		</thead>

		<tbody>

		<?php
			while ($row = mysqli_fetch_array($sortit)) {
				$artistName = $row["artistName"];
				$artistPop = $row["pop"];
				$artistArt = $row[ "artistArt" ];
				// $popDate = $row["date"];
		?>

		<tr>
			<td><img src='<?php echo $artistArt ?>' height='64' width='64'></td>
			<td><?php echo $artistName ?></td>
			<td><?php echo $artistPop ?></td>
			
			<!--
					<td><?php // echo $popDate ?></td>			
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
