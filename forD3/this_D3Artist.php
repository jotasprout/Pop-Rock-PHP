<?php 
	include '../sesh.php';
	$artistID = $_SESSION['artist'];
	$_SESSION['artist'] = $artistID;
	require_once '../stylesAndScripts.php';
	require_once '../navbar_rock.php';
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

			<script>
				d3.json("createD3c.php", function(dataset) {
					console.log(dataset);
				});
				
			</script>

		</div> <!-- close forChart -->

    </div> <!-- close container -->
    
    <?php echo $scriptsAndSuch; ?>
	<script src="https://www.roxorsoxor.com/poprock/sortThisArtist.js"></script>
</body>

</html>