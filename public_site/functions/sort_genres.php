<?php

require_once '../rockdb.php';

$artistArtMBFilepath = "https://www.roxorsoxor.com/poprock/artist-art/";

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

if ( $sortBy == "artistNameSpot" and $order == "ASC" ) {
	$artistNameNextOrder = "DESC";
}

if ( $sortBy == "genre" and $order == "ASC" ) {
	$genreNextOrder = "DESC";
}

$artistInfoWithArtAndGenres = "SELECT g.id,
                                      g.artistID,
                                      g.genre,
                                      g.genreSource,
                                      s.artistSpotID, 
                                      s.artistArtSpot, 
                                      s.artistNameSpot,
                                      m.artistMBID, 
                                      m.artistArtMBFilename, 
                                      m.artistNameMB
                                FROM genres g
                                LEFT JOIN artistsSpot s ON s.artistSpotID = g.artistID
                                LEFT JOIN artistsMB m ON m.artistMBID = g.artistID
                                ORDER BY " . $sortBy . " " . $order . ";";

$sortit = $connekt->query($artistInfoWithArtAndGenres); 

if (!$sortit) {
    echo 'Darn. No query.';
};

if (!empty($sortit)) { ?>

<table class="table" id="tableoartists">
<thead>
<tr>
    <!--  -->
    <th>Pretty Face</th>	
    <th onClick="sortColumn('artistNameSpot', '<?php echo $artistNameNextOrder; ?>')"><div class="pointyHead">Artist Name</div></th>
    <th onClick="sortColumn('genre', '<?php echo $genreNextOrder; ?>')"><div class="pointyHead">Genre</div></th>
</tr>
</thead>

<tbody>

		<?php
			while ($row = mysqli_fetch_array($sortit)) {
                $artistNameSpot = $row[ "artistNameSpot" ];
                $artistNameMB = $row[ "artistNameMB" ];
                $artistArtSpot = $row[ "artistArtSpot" ];
                $artistArtMB = $row[ "artistArtMBFilename" ];
                $genre = $row["genre"];
		?>

		<tr>
		<!--  -->
		    <td><img src='<?php // echo $artistArtSpot ?>' height='64' width='64'></td>	
		
			<td><?php echo $artistNameSpot ?></td>
			<td><a href='https://www.roxorsoxor.com/poprock/genreArtists_popCurrentBars.php?artistGenre=<?php echo $genre ?>'><?php echo $genre ?></a></td>
			<!--  -->
		</tr>

		<?php 
			} // end of while
		?>

		</tbody>
	</table>
<?php 
	} // end of if
?>
