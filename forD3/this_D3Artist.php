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
	<style type="text/css">
		.line {
			fill: none;
			stroke: teal;
			stroke-width: 0.5;
		}
	</style>
</head>

<body>
	<?php echo $navbar ?>

    <div class="container">
        
		<div id="forChart">

			<script>

				var w = 800;
				var h = 300;
				var padding = 40;

				var dataset, xScale, yScale, xAxis, yAxis, line;

				d3.json("createD3c.php", function(data) {
					
					var dataset = data;

					console.log(dataset);

					console.table(dataset, ["date", "pop"] );
				});
				
			</script>

		</div> <!-- close forChart -->

    </div> <!-- close container -->
    
    <?php echo $scriptsAndSuch; ?>
	<script src="https://www.roxorsoxor.com/poprock/sortThisArtist.js"></script>
</body>

</html>