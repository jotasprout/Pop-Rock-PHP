<?php

session_start();
require_once 'rockdb.php';
require_once 'navbar_rock.php';
require_once 'stylesAndScripts.php';
require_once 'albums.php';
require_once 'tracks.php';

$artistID = $_SESSION['artist'];
$_SESSION['artist'] = $artistID;

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Tracks of My Database</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">

<?php echo $navbar ?>

<!-- main -->

<div class="panel panel-primary">
<div class="panel-heading">
	<h3 class="panel-title">Latest Tracks Info from My Database</h3>
</div>
<div class="panel-body"> 

<table class="table">
	<tr><th>Album Name</th><th>Track Name</th><th>Track Popularity</th></tr>
	<?php
		showTracks ($artistID);
	?>
</table>
</div> <!-- panel body -->
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2018</p></footer>
</div> <!-- panel panel-primary -->
    </div> <!-- closing container -->
</body>
</html>