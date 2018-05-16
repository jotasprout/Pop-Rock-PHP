<?php 
	include '../sesh.php';
	$artistID = $_SESSION['artist'];
	$_SESSION['artist'] = $artistID;
	// what about artist class?
	require_once 'rockdb.php';
	require_once '../stylesAndScripts.php';
	require_once '../navbar_rock.php';
	require_once 'artists.php';
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>This D3 Artist</title>
    <?php echo $stylesAndSuch; ?>
</head>

<body>
	<?php echo $navbar ?>

    <div class="container">
        
		<div id="forChart">

		</div>

    </div> <!-- close container -->
    
    <?php echo $scriptsAndSuch; ?>
	<script src="https://www.roxorsoxor.com/poprock/sortThisArtist.js"></script>
</body>

</html>