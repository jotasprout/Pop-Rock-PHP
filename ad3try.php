<?php
	require_once 'rockdb.php';
    require_once 'stylesAndScripts.php';
	require_once 'navbar_rock.php';
	require_once 'artists.php';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>D3: Loading data from a CSV file</title>
		<?php echo $stylesAndSuch; ?>
		<script src='https://d3js.org/d3.v4.min.js'></script>
	</head>

	<body>

		<DIV class="container">
	    
		    <?php echo $navbar ?> <!-- /navbar -->

			<div> <!-- main -->

			<script type="text/javascript">
				d3.json("getDataAndConvertToD3.php", function(data) {
					console.log(data);
				});
			</script>

			</div> <!-- main -->

			<footer class="footer">
				<p>&copy; Sprout Means Grow 2016</p>
			</footer>
		</div> 	<!-- /container -->	

		<?php echo $scriptsAndSuch; ?>	
	</body>
</html>