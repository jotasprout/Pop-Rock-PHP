<?php

$artistSpotID = $_GET['artistSpotID'];
$artistMBID = $_GET['artistMBID'];
$source = $_GET['source'];

require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$blackSabbath_MBID = '5182c1d9-c7d2-4dad-afa0-ccfeada921a8';
/*
$gatherTrackInfo = "SELECT t.trackMBID, t.trackName, a.albumName, a.artistMBID, f1.MaxDataDate, f1.trackListeners, f1.trackPlaycount
					FROM tracksMB t
					INNER JOIN albumsMB a ON a.albumMBID = t.albumMBID
					JOIN (SELECT f.*
							FROM tracksLastFM f
							INNER JOIN (SELECT trackMBID, trackListeners, trackPlaycount, max(dataDate) AS MaxDataDate
										FROM tracksLastFM  
										GROUP BY trackMBID) groupedf
							ON f.trackMBID = groupedf.trackMBID
							AND f.dataDate = groupedf.MaxDataDate) f1
					ON t.trackMBID = f1.trackMBID
					WHERE a.artistMBID = '$artistMBID'
					ORDER BY t.trackName ASC";
*/

$gatherTrackInfo = "SELECT v.trackName, v.albumName, v.trackListeners, v.trackPlaycount, max(v.dataDate) AS MaxDataDate
					FROM (
						SELECT z.trackMBID, z.trackName, z.albumName, p.dataDate, p.trackListeners, p.trackPlaycount
							FROM (
								SELECT t.*, r.albumName, a.artistName
									FROM tracksMB t
									INNER JOIN albumsMB r ON r.albumMBID = t.albumMBID
									JOIN artistsMB a ON r.artistMBID = a.artistMBID
									WHERE a.artistMBID = '$artistMBID'
							) z
						JOIN tracksLastFM p 
							ON z.trackMBID = p.trackMBID					
					) v
					GROUP BY v.trackMBID
					ORDER BY v.trackPlaycount DESC";


$getit = $connekt->query( $gatherTrackInfo );

if ( !$getit ) {
	echo 'Cursed-Crap. Did not run the query.';
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Stats for All Tracks By This Artist</title>
	<?php echo $stylesAndSuch; ?>
</head>

<body>

	<div class="container-fluid">

		<?php echo $navbar ?>

		<!-- main -->
		<p>If this page is empty, or the wrong discography displays, <a href='https://www.roxorsoxor.com/poprock/index.php'>choose an artist</a> first.</p>

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Latest Tracks Stats from My Database</h3>
			</div>
			<div class="panel-body">

				<?php if(!empty($getit)) { ?>
				
<table class="table" id="tableotracks">
	<thead>
		<tr>
			<th onClick="sortColumn('albumName', 'DESC', '<?php echo $artistSpotID ?>')"><div class="pointyHead">Album Title</div></th>
			<th onClick="sortColumn('trackName', 'ASC', '<?php echo $artistSpotID ?>')"><div class="pointyHead">Track Title</div></th>
<!--
			<th class="popStyle">LastFM<br>Data Date</th>
			-->
			<th class="rightNum pointyHead">LastFM<br>Listeners</th>
			<th class="rightNum pointyHead">LastFM<br>Playcount</th>
		</tr>
	</thead>
					
					<tbody>
					<?php
						while ( $row = mysqli_fetch_array( $getit ) ) {
							$albumName = $row[ "albumName" ];
							$trackName = $row[ "trackName" ];
							//$trackSpotID = $row[ "trackSpotID" ];
							//$trackPop = $row[ "pop" ];
							//$popDate = $row[ "date" ];
							$lastFMDate = $row[ "MaxDataDate" ];
							$trackListenersNum = $row["trackListeners"];
							$trackListeners = number_format ($trackListenersNum);
							if (!$trackListeners > 0) {
								$trackListeners = "n/a";
							};
							$trackPlaycountNum = $row["trackPlaycount"];
							$trackPlaycount = number_format ($trackPlaycountNum);
							if (!$trackPlaycount > 0) {
								$trackPlaycount = "n/a";
							};
					?>
							<tr>
								<td><?php echo $albumName ?></td>
								<td><?php echo $trackName ?></td>
<!--
								<td class="popStyle"><?php //echo $lastFMDate ?></td>
								-->
								<td class="rightNum"><?php echo $trackListeners ?></td>
								<td class="rightNum"><?php echo $trackPlaycount ?></td>
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

<script>
	let artistSpotID = '<?php echo $artistSpotID ?>';
</script>

<script src="https://www.roxorsoxor.com/poprock/functions/sort_Tracks.js"></script>

</body>
	
</html>