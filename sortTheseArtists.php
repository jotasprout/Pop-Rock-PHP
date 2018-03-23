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
	$order = $_POST[ "order" ];
}

$artistNameNextOrder = "ASC";
$popNextOrder = "ASC";

if ( $sortBy == "artistName" and $order == "ASC" ) {
	$artistNameNextOrder = "DESC";
}

if ( $sortBy == "pop" and $order == "ASC" ) {
	$popNextOrder = "DESC";
}

$artistInfoRecent = "SELECT a.artistID, a.artistName, b.pop, b.date 
	FROM artists a
		INNER JOIN popArtists b ON a.artistID = b.artistID
			WHERE b.date = (select max(b2.date)
							FROM popArtists b2)
	ORDER BY " . $sortBy . " " . $order . ";";

$sortit = $connekt->query($artistInfoRecent); 

if (!$sortit) {
    echo 'Darn. No query.';
};

if (!empty($sortit)) { ?>

	<table class="table" id="tableoartists">
		<thead>
			<tr>
				<th onClick="sortColumn('artistName', '<?php echo $artistNameNextOrder; ?>')">Artist Name</th>
				<th onClick="sortColumn('pop', '<?php echo $popNextOrder; ?>')">Popularity</th>
				<!--
		<th>Date</th>	
		--> 
			</tr>
		</thead>

		<tbody>

		<?php
			while ($row = mysqli_fetch_array($sortit)) {
				$artistName = $row["artistName"];
				$artistPop = $row["pop"];
				$popDate = $row["date"];
		?>

		<tr>
			<td><?php echo $artistName ?></td>
			<td><?php echo $artistPop ?></td>
			<!--
								<td><?php //echo $popDate ?></td>
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
