<?php

include 'page_pieces/sesh.php';
require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$artistInfoWithArtAndGenres = "SELECT a.artistID, a.artistArt, a.artistName, g.genre
    FROM artists a
    JOIN genres2 g ON a.artistID = g.artistID
	ORDER BY a.artistName ASC";

$getit = $connekt->query( $artistInfoWithArtAndGenres );

if(!$getit){ echo 'Cursed-Crap. Did not run the query.'; }	

?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="UTF-8">
	<title>Artists and Their Genres</title>
	<?php echo $stylesAndSuch; ?>
</head>

<body>

	<div class="container">
		<?php echo $navbar ?>

		<!-- main -->

		<div class="panel panel-primary">

			<div class="panel-heading">
				<h3 class="panel-title">Artists Genres</h3>
			</div>

			<div class="panel-body">

				<!-- Panel Content -->
				<!-- D3 chart goes here -->
				<?php if (!empty($getit)) { ?>

				<table class="table" id="tableoartists">
				<thead>
					<tr>
						<!--
					<th>Pretty Face</th>	
						-->
					<th onClick="sortColumn('artistName', 'DESC')"><div class="pointyHead">Artist Name</div></th>
					<th onClick="sortColumn('genre', 'ASC')"><div class="pointyHead">Genre</div></th>
					</tr>
				</thead>

				<tbody>

					<?php
						while ( $row = mysqli_fetch_array( $getit ) ) {
							$artistName = $row[ "artistName" ];
							$artistGenre = $row[ "genre" ];
							$artistArt = $row[ "artistArt" ];
					?>

					<tr>
						<!--
						<td><img src='<?php // echo $artistArt ?>' height='64' width='64'></td>	
						-->
						<td><?php echo $artistName ?></td>
						<td><?php echo $artistGenre ?></td>
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
	<script src="https://www.roxorsoxor.com/poprock/functions/sortTheseArtistsGenres.js"></script>

	<script>
	
	</script>

</body>

</html>