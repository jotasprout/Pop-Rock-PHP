<?php

include 'page_pieces/sesh.php';
require_once 'rockdb.php';
require_once 'page_pieces/stylesAndScripts.php';

$artistArtMBFilepath = "https://www.roxorsoxor.com/poprock/artist-art/";

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo '<p>Darn. Did not connect. Screwed up like this: ' . mysqli_error($connekt) . '</p>';
};

$newGenresQuery = "SELECT g.*, s.artistNameSpot, m.artistNameMB
					FROM genres g
					LEFT JOIN artistsSpot s ON s.artistSpotID = g.artistID
					LEFT JOIN artistsMB m ON m.artistMBID = g.artistID
					ORDER BY g.genre DESC;";

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
                                ORDER BY g.genre ASC";

$getit = $connekt->query( $newGenresQuery );
if(!$getit){ 
	echo '<p>Cursed-Crap. Did not run the query. Screwed up like this: ' . mysqli_error($getit) . '</p>';
}	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Genres</title>
	<?php echo $stylesAndSuch; ?>
</head>
<body>
	<div class="container">
	<div id="fluidCon"></div> <!-- end of fluidCon -->
		<!-- main -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Click a genre to compare artists in that genre.</h3>
			</div>
			<div class="panel-body">
				<!-- Panel Content -->
				<?php if (!empty($getit)) { ?>
					<table class="table table-striped table-hover" id="tableoartists">
					<thead>
						<tr>
							<!-- 
							<th>Pretty Face</th>	
							 -->
							<th>Table ID</th>
								
							<th onClick="sortColumn('artistName', 'unsorted', 'source')"><div class="pointyHead popStyle">Artist Name</div></th>
							<th onClick="sortColumn('genre', 'ASC', 'source')"><div class="pointyHead popStyle">Genre</div></th>
							<th><div class="popStyle">Genre<br>Source</div></th>
						</tr>
					</thead>
					<tbody>
					<?php
						while ( $row = mysqli_fetch_array( $getit ) ) {
							$rowID = $row["id"];
							$artistID = '';
                            //$artistArtSpot = $row[ "artistArtSpot" ];
                            //$artistArtMBFilename = $row[ "artistArtMBFilename" ];
                            //$artistSpotID = $row["artistSpotID"];
                            //$artistMBID = $row["artistMBID"];
                            //$artistArt = '';
                            $artistName = '';
                            $artistNameSpot = $row[ "artistNameSpot" ];
							$artistNameMB = $row[ "artistNameMB" ];
							$genre = $row["genre"];
                            $genreSource = $row["genreSource"];
                            if ($genreSource = "spotify") {
                                //$artistID = $artistSpotID;
                                //$artistArt = $artistArtSpot;
                                $artistName = $artistNameSpot;
                            } else {
                                //$artistID = $artistMBID;
                                //$artistArt = $artistArtMBFilepath . $artistArtMBFilename;
                                $artistName = $artistNameMB;
                            };
                                  
					?>

					<tr>
						<!-- <td><img src='<?php echo $artistArt ?>' height='64' width='64'></td> -->
						<td><?php echo $rowID ?></td>
						
						<td><?php echo $artistName ?></td>
						<td class="popStyle"><a href='https://www.roxorsoxor.com/poprock/genreArtists_popCurrentBars.php?artistGenre=<?php echo $genre ?>'><?php echo $genre ?></a></td>
                        <td class="popStyle"><?php echo $genreSource ?></td>
					</tr>

					<?php 
						} // end of while
					?>

					</tbody>
				</table>
				<?php 
					} // end of if
				?>

			</div>
			<!-- panel body -->

		</div>
		<!-- panel panel-primary -->

	</div>
	<!-- close container -->

	<?php echo $scriptsAndSuch; ?>
	<script src="https://www.roxorsoxor.com/poprock/functions/sort_genres.js"></script>
	<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbarIndex.js"></script>
</body>

</html>