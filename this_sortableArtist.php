<?php 

include 'sesh.php';
// $artistID = $_SESSION['artist'];
$artistID = $_POST['artist'];
$_SESSION['artist'] = $artistID;

require_once 'rockdb.php';
require_once 'stylesAndScripts.php';
require_once 'navbar_rock.php';
require_once 'artists.php';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};

$artistInfoAll = "SELECT a.artistID, a.artistName, b.pop, b.date 
	FROM artists a
		INNER JOIN popArtists b ON a.artistID = b.artistID
			WHERE a.artistID = '$artistID'
				ORDER BY b.date ASC";

$getit = $connekt->query($artistInfoAll);

if(!$getit){
	echo 'Cursed-Crap. Did not run the query.';
}	

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>This Artist</title>
    <?php echo $stylesAndSuch; ?>
    <script src='https://d3js.org/d3.v4.min.js'></script>
</head>

<body>

    <div class="container">
        <?php echo $navbar ?>

        <!-- D3 chart goes here -->
		<?php if(!empty($getit)) { ?>
		
        <table class="table" id="artistTable">
			<thead>
				<tr>
					<th>Artist Name</th>
					<th>Popularity</th>
					<th  onClick="sortColumn('date', 'DESC')"><div class="pointyHead">Date</div></th>
				</tr>	
			</thead>
			<tbody>

			<?php

			while ($row = mysqli_fetch_array($getit)) {
				// $artistID = $row["artistID"];
				$artistName = $row["artistName"];
				$artistPop = $row["pop"];
				$popDate = $row["date"];
			?>
							
			<tr>
				<td><?php echo $artistName ?></td>
				<td><?php echo $artistPop ?></td>
				<td><?php echo $popDate ?></td>
			</tr>

			<?php 
				} // end of while
			?>

			</tbody>
        </table>

		<?php 
		} // end of if
		?>

		<!--
        <footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
		-->
    </div> <!-- close container -->
    
    <?php echo $scriptsAndSuch; ?>
	<script src="https://www.roxorsoxor.com/poprock/sortThisArtist.js"></script>
</body>

</html>