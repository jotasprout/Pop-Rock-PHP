<?php

include 'sesh.php';
$artistID = $_POST['artist'];
// $artistID = $_SESSION['artist'];
$_SESSION['artist'] = $artistID;

require_once 'rockdb.php';
require_once 'navbar_rock.php';
require_once 'stylesAndScripts.php';
require_once 'albums.php';
require_once 'sortingHat.php';

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>My Album Info</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">

	<?php echo $navbar ?>
	
	<!-- main -->
	
<div class="panel panel-primary">

	<div class="panel-heading">
		<h3 class="panel-title">Album Info from My DB</h3>
	</div>

	<div class="panel-body"> 
		
		<!-- Panel Content --> 
		<table class="table" id="recordCollection">

			<tr>
				<th>Album Art</th>
				<th onClick="sortColumn('<?php echo $albumName ?>', 'ASC')">Album Name</th>
				<th onClick="sortColumn('<?php echo $albumReleased ?>', 'ASC')">Released</th>
				<th onClick="sortColumn('<?php echo $albumPop ?>', 'ASC')">Popularity</th>
				<th>Date</th>
			</tr>

			<?php
				showAlbums ($artistID);
			?>

		</table>

	</div> <!-- panel body -->

<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2018</p></footer>
</div> <!-- panel panel-primary -->
    </div> <!-- closing container -->
	
<?php echo $scriptsAndSuch; ?>

</body>
</html>