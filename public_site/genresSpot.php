<?php

include 'page_pieces/sesh.php';
require_once 'rockdb.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo '<p>Darn. Did not connect. Screwed up like this: ' . mysqli_error($connekt) . '</p>';
};

$artistInfoWithArtAndGenres = "SELECT a.artistSpotID, a.artistArtSpot, a.artistNameSpot, g.genre
    FROM artistsSpot a
    JOIN genresSpot g ON a.artistSpotID = g.artistSpotID
	ORDER BY a.artistNameSpot ASC";

$getit = $connekt->query( $artistInfoWithArtAndGenres );

if(!$getit){ 
	echo '<p>Cursed-Crap. Did not run the query. Screwed up like this: ' . mysqli_error($getit) . '</p>';
}	

?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="UTF-8">
	<title>Spotify Genres</title>
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
				<!-- D3 chart goes here -->
				<?php if (!empty($getit)) { ?>

				<table class="table table-striped table-hover" id="tableoartists">
				<thead>
					<tr>
						<!--
					<th>Pretty Face</th>	
						-->
					<th onClick="sortColumn('artistNameSpot', 'DESC')"><div class="pointyHead">Artist Name</div></th>
					<th onClick="sortColumn('genre', 'ASC')"><div class="pointyHead">Genre</div></th>
					</tr>
				</thead>

				<tbody>

					<?php
						while ( $row = mysqli_fetch_array( $getit ) ) {
							$artistNameSpot = $row[ "artistNameSpot" ];
							$artistGenre = $row[ "genre" ];
							$artistArtSpot = $row[ "artistArtSpot" ];
					?>

					<tr>
						<!--
							<td><img src='<?php //echo $artistArtSpot ?>' height='64' width='64'></td>
						-->
							
						<td><?php echo $artistNameSpot ?></td>
						<td><a href='https://www.roxorsoxor.com/poprock/genreArtists_popCurrentBars.php?artistGenre=<?php echo $artistGenre ?>'><?php echo $artistGenre ?></a></td>
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
	<script src="https://www.roxorsoxor.com/poprock/functions/sort_genresSpot.js"></script>
	<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbarIndex.js"></script>
</body>

</html>