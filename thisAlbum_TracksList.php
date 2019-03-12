<?php

$albumID = $_GET['albumID'];

require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$gatherTrackInfo = "SELECT t.trackID, t.trackName, a.albumName, a.artistID, p1.pop, p1.date
						FROM tracks t
						INNER JOIN albums a ON a.albumID = t.albumID
						JOIN (SELECT p.* FROM popTracks p
								INNER JOIN (SELECT trackID, pop, max(date) AS MaxDate
											FROM popTracks  
											GROUP BY trackID) groupedp
								ON p.trackID = groupedp.trackID
								AND p.date = groupedp.MaxDate) p1 
						ON t.trackID = p1.trackID
						WHERE a.albumID = '$albumID'
						ORDER BY p1.pop DESC";

$getit = $connekt->query( $gatherTrackInfo );

if ( !$getit ) {
	echo 'Cursed-Crap. Did not run the query.';
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>This Album's Tracks Popularity On Spotify</title>
	<?php echo $stylesAndSuch; ?>
</head>

<body>

	<div class="container">

		<?php echo $navbar ?>

		<!-- main -->
		<p>Please be patient while data loads.</p>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">This Album's Tracks Popularity On Spotify</h3>
			</div>
			<div class="panel-body">

				<?php if(!empty($getit)) { ?>
				
				<table class="table" id="tableotracks">
					<thead>
						<tr>
							<th onClick="sortColumn('albumName', 'ASC')"><div class="pointyHead">Album Name</div></th>
							<th>trackID</th>
				<!--

				-->
			<th onClick="sortColumn('trackName', 'DESC')"><div class="pointyHead">Track</div></th>
			<th>Date</th>
			<th onClick="sortColumn('pop', 'ASC')"><div class="pointyHead">Track Popularity</div></th>
		</tr>
	</thead>
	
	<tbody>
	<?php
		while ( $row = mysqli_fetch_array( $getit ) ) {
			$albumName = $row[ "albumName" ];
			$trackName = $row[ "trackName" ];
			$trackID = $row[ "trackID" ];
			$trackPop = $row[ "pop" ];
			$popDate = $row[ "date" ];
	?>
<tr>
<td><?php echo $albumName ?></td>
<td><?php echo $trackID ?></td>
<!--

-->
<td><a href='https://www.roxorsoxor.com/poprock/thisTrack_popChart.php?trackID=<?php echo $trackID ?>'><?php echo $trackName ?></a></td>
<td><?php echo $popDate ?></td>
<td><?php echo $trackPop ?></td>
</tr>
	<?php 
		} // end of while
	?>
	
	</tbody>
</table>
				<?php 
					} // end of if
				?>
			</div> <!-- panel body -->
		</div> <!-- panel panel-primary -->
	</div> <!-- closing container -->
	
<?php echo $scriptsAndSuch; ?>
<script src="https://www.roxorsoxor.com/poprock/functions/sortTheseTracks.js"></script>
</body>
	
</html>