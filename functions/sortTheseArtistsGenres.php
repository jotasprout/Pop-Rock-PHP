<?php

require_once '../rockdb.php';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
    echo 'Darn. Did not connect.';
};

$sortBy = "genre";
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
$genreNextOrder = "ASC";

if ( $sortBy == "artistName" and $order == "ASC" ) {
	$artistNameNextOrder = "DESC";
}

if ( $sortBy == "genre" and $order == "ASC" ) {
	$genreNextOrder = "DESC";
}

$artistInfoWithArtAndGenres = "SELECT a.artistID, a.artistArt, a.artistName, g.genre
    FROM artists a
    JOIN genres2 g ON a.artistID = g.artistID
	ORDER BY " . $sortBy . " " . $order . ";";	

$sortit = $connekt->query($artistInfoWithArtAndGenres); 

if (!$sortit) {
    echo 'Darn. No query.';
};

if (!empty($sortit)) { ?>

	<table class="table" id="tableoartists">
		<thead>
			<tr>
				<!--
				<th>Pretty Face</th>	
				-->
				<th onClick="sortColumn('artistName', '<?php echo $artistNameNextOrder; ?>')"><div class="pointyHead">Artist Name</div></th>
				<th onClick="sortColumn('genre', '<?php echo $genreNextOrder; ?>')"><div class="pointyHead">Genre</div></th>
			</tr>
		</thead>

		<tbody>

		<?php
			while ($row = mysqli_fetch_array($sortit)) {
				$artistName = $row["artistName"];
				$genre = $row["genre"];
				$artistArt = $row[ "artistArt" ];
		?>

		<tr>
		<!--
		<td><img src='<?php // echo $artistArt ?>' height='64' width='64'></td>	
		-->
			<td><?php echo $artistName ?></td>
			<td><?php echo $genre ?></td>
		</tr>

		<?php 
			} // end of while
		?>

		</tbody>
	</table>
<?php 
	} // end of if
?>
