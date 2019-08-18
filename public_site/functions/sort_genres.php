<?php

require_once '../rockdb.php';

$artistArtMBFilepath = "https://www.roxorsoxor.com/poprock/artist-art/";

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
    echo '<p>Darn. Did not connect. Screwed up like this: ' . mysqli_error($connekt) . '</p>';
};

$sortBy = "genre";
$order = "DESC";

if ($_POST["source"])

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

$artistInfoWithArtAndGenres = "SELECT g.id,
                                      g.artistID,
									  s.artistArtSpot, 
									  m.artistArtMBFilename,
									  s.artistSpotID, 
									  m.artistMBID, 
									  s.artistNameSpot,
									  m.artistNameMB,
                                      g.genre,
                                      g.genreSource
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
    <th>Table ID</th>
    <th>Pretty Face</th>	
    <th onClick="sortColumn('artistName', '<?php echo $artistNameNextOrder; ?>')"><div class="pointyHead">Artist Name</div></th>
    <th onClick="sortColumn('genre', '<?php echo $genreNextOrder; ?>')"><div class="pointyHead">Genre</div></th>
    <th><div class="popStyle">Genre<br>Source</div></th>
</tr>
</thead>

<tbody>

		<?php
			while ($row = mysqli_fetch_array($sortit)) {
                $rowID = $row["id"];
                $artistID = '';
                $artistArtSpot = $row[ "artistArtSpot" ];
                $artistArtMBFilename = $row[ "artistArtMBFilename" ];
                $artistSpotID = $row["artistSpotID"];
                $artistMBID = $row["artistMBID"];
                $artistArt = '';
                $artistName = '';
                $artistNameSpot = $row[ "artistNameSpot" ];
                $artistNameMB = $row[ "artistNameMB" ];
                $genre = $row["genre"];
                $genreSource = $row["genreSource"];
                if ($genreSource = "spotify") {
                    $artistID = $artistSpotID;
                    $artistArt = $artistArtSpot;
                    $artistName = $artistNameSpot;
                } else {
                    $artistID = $artistMBID;
                    $artistArt = $artistArtMBFilepath . $artistArtMBFilename;
                    $artistName = $artistNameMB;
                };
		?>

		<tr>
		<!--  -->
        <td><?php echo $rowID ?></td>
		    <td><img src='<?php echo $artistArt ?>' height='64' width='64'></td>	
		
			<td><?php echo $artistName ?></td>
			<td><a href='https://www.roxorsoxor.com/poprock/genreArtists_popCurrentBars.php?artistGenre=<?php echo $genre ?>'><?php echo $genre ?></a></td>
            <td class="popStyle"><?php echo $genreSource ?></td>
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
