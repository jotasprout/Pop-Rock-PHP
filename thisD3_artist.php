<?php 

    // include 'sesh.php';
    // $artistID = $_SESSION['artist'];
    // $_SESSION['artist'] = $artistID;
    require_once 'rockdb.php';
    require_once 'stylesAndScripts.php';
    require_once 'navbar_rock.php';
	// require_once 'artists.php';
	
	$artistID = "4BFMTELQyWJU1SwqcXMBm3";

function showThisD3Artist ($artistID) {

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

	$artistInfoAll = "SELECT a.artistID, a.artistName, b.pop, b.date 
		FROM artists a
			INNER JOIN popArtists b ON a.artistID = b.artistID
				WHERE a.artistID = '$artistID'
					ORDER BY b.date ASC";

	$getit = $connekt->query($artistInfoAll);

	if (!$connekt) { echo 'Darn. Did not connect.'; }

	if(!$getit){ echo 'Cursed-Crap. Did not run the query.'; }	

	$popArray = array ();

	while ($row = mysqli_fetch_array($getit)) {
		$popArray[] = $row;
	} 

	echo json_encode($popArray) . '<br>';

	$jPop = json_encode($popArray);

	mysqli_close($connekt);

	function console_log ($popArray) {
		echo '<script>';
		echo 'console.log('. json_encode ($popArray) .')';
		echo '</script>';
	  }

	console_log ($popArray);

	// $popFile = fopen('popData.json', 'w');
	// fwrite($popFile, json_encode($popArray));
	// fclose($popFile);

}

?>

<!DOCTYPE html>

<html>
	
<head>
    <meta charset="UTF-8">
    <title>This D3 Artist</title>
    <?php echo $stylesAndSuch; ?>
    <script src='https://d3js.org/d3.v4.min.js'></script>
</head>

<body>

	<div class="container">
		<?php echo $navbar ?>
		<!-- D3 chart goes here -->
		<?php showThisD3Artist ($artistID); ?>
	</div> <!-- close container -->
	<?php echo $scriptsAndSuch; ?>

</body>

</html>