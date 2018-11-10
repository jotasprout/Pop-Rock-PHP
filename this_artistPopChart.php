<?php 
	$artistID = $_COOKIE['artistID'];
	require_once 'page_pieces/stylesAndScripts.php';
	require_once 'page_pieces/navbar_rock.php';
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
			stroke: yellow;
			stroke-width: 1;
		}
	</style>
</head>

<body>

<div class="container">
	<?php echo $navbar ?>
	<div id="forChart">

	<script>

		var w = 800;
		var h = 300;
		var padding = 40;

		var dataset, xScale, yScale, xAxis, yAxis, line;

		d3.json("functions/createD3c.php", function(data) {
			
			console.log(data);
			
			var dataset = data;

			var parseTime = d3.timeParse("%y-%m-%d");

			dataset.forEach(function(d) {
				// date = parseTime(d.date);
				d.date = new Date(d.date);
				d.pop = +d.pop;
			});

			xScale = d3.scaleTime()
						.domain([
							d3.min(dataset, function(d) { return d.date; }),
							d3.max(dataset, function(d) { return d.date; })
						])
						.range([0,w]);

			yScale = d3.scaleLinear()
						.domain([0,100])
						.range([h, 0]);

			var line = d3.line()
						.x(function(d) { return xScale(d.date); })
						.y(function(d) { return yScale(d.pop); });

			var svg = d3.select("#forChart")
							.append("svg")
							.attr("width", w)
							.attr("height", h);

			svg.append("path")
				.datum(dataset)
				.attr("class", "line")
				.attr("d", line);

		});
		
	</script>

	</div> <!-- close forChart -->

</div> <!-- close container -->

<?php echo $scriptsAndSuch; ?>
<!--
<script src="https://www.roxorsoxor.com/poprock/functions/sortThisArtist.js"></script>
-->

</body>

</html>