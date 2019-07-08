<?php 
	require_once 'page_pieces/stylesAndScripts.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
	
	<?php echo $stylesAndSuch; ?>

</head>

<body>

<div class="container-fluid">
	
<div id="fluidCon"></div> <!-- end of fluidCon -->

    <div class="panel panel-primary">
		<div class="panel-heading">
			<h3 id="name" class="panel-title">Opening Tracks</h3>

            <!-- Bar chart of first tracks -->
            <!-- Then multi-line chart for all tracks -->

		</div>
		<div class="panel-body">
			<div id="popchart"></div>
		</div> <!-- panel body -->
	</div> <!-- close Panel Primary -->

</div> <!-- close container-fluid -->

<script type="text/javascript">
	
		
</script>	


<?php echo $scriptsAndSuch; ?>

<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbarIndex.js"></script>
</body>

</html>