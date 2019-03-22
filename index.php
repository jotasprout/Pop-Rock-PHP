<?php

require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$artistInfoRecentWithArt = "SELECT a.artistID AS artistID, a.artistArt AS artistArt, a.artistName AS artistName, a.albumsTotal AS albumsTotal, p1.pop AS pop, p1.followers AS followers, p1.date AS date
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

$getit = $connekt->query( $artistInfoRecentWithArt );

if(!$getit){ echo 'Cursed-Crap. Did not run the query.'; }	

?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="UTF-8">
	<title>All Artists</title>
	<?php echo $stylesAndSuch; ?>
</head>

<body>

	<div class='container-fluid'>
	<!--
	<div class="container">
	-->
		<?php 
			echo $navbarIndex;
		?>

	<!-- main -->

	<div class="panel panel-primary">

		<div class="panel-heading">
			<h3 class="panel-title">Data for All Artists</h3>
		</div>

		<div class="panel-body">

			<!-- Panel Content -->
			<!-- D3 chart goes here -->
			<?php if (!empty($getit)) { ?>

			<table class="table" id="tableoartists">
				<thead>
					<tr>
						<th>Pretty Face</th>	
						<th onClick="sortColumn('artistName', 'ASC')"><div class="pointyHead">Artist Name</div></th>
						<th class="popStyle">Spotify ID</th>
						<!--
						-->
						<th class="popStyle">Spotify<br>Data Date</th>
						<th onClick="sortColumn('pop', 'DESC')"><div class="pointyHead popStyle">Spotify<br>Popularity</div></th>
						<th class="popStyle">Spotify<br>Followers</th>
						<th class="popStyle">LastFM<br>Listeners</th>
						<th class="popStyle">LastFM<br>Playcount</th>
						<th class="popStyle">Spotify<br>Total Albums</th>
					</tr>
				</thead>

				<tbody>

				<?php
					while ( $row = mysqli_fetch_array( $getit ) ) {
						$artistName = $row[ "artistName" ];
						$artistID = $row[ "artistID" ];
						$artistPop = $row[ "pop" ];
						$artistFollowersNum = $row[ "followers"];
						$artistFollowers = number_format ($artistFollowersNum);
						$artistArt = $row[ "artistArt" ];
						$popDate = $row[ "date" ];
						$albumsTotal = $row[ "albumsTotal" ];
				?>

				<tr>
					<td><img src='<?php echo $artistArt ?>' class="indexArtistArt"></td>	
					<td><a href='https://www.roxorsoxor.com/poprock/this_artistPopChart.php?artistID=<?php echo $artistID ?>'><?php echo $artistName ?></a></td>
					<td class="popStyle"><?php echo $artistID ?></td>
					<!--
					-->
					<td class="popStyle"><?php echo $popDate ?></td>
					<td class="popStyle"><?php echo $artistPop ?></td>
					<td id="followers" class="rightNum"><?php echo $artistFollowers ?></td>
					<td class="popStyle">--</td>
					<td class="popStyle">--</td>
					<td class="popStyle"><?php echo $albumsTotal ?></td>
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
	<script src="https://www.roxorsoxor.com/poprock/functions/sortTheseArtists.js"></script>

</body>

</html>