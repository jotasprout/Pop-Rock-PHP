<?php
    require_once '../stylesAndScripts.php';
    require_once '../navbar_rock.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Albums in D3</title>
	<?php echo $stylesAndSuch; ?>
	<script src='https://d3js.org/d3.v4.min.js'></script>
</head>

<body>
		<DIV class="container">
	    
		    <?php echo $navbar ?> <!-- /navbar -->

			<div id="forChart"> <!-- main -->
<!--			
	<script type="text/javascript">
		d3.json("createD3.php", function(data) {
			console.log(data);

			d3.select("body").selectAll("div")
				.data(data)
				.enter()
				.append("div")
				.attr("class", "bar")
				.style("height", function(d) {
					return d[4] + "px";
				});
		});
	</script>
-->
			<script type="text/javascript">
				d3.json("createD3.php", function(dataset) {
					console.log(dataset);
					//Width and height
					var w = 500;
					var h = 100;
					var barPadding = 1;
					
					//Create SVG element
					var svg = d3.select("#forChart")
								.append("svg")
								.attr("width", w)
								.attr("height", h);

					//Rectangles
					svg.selectAll("rect")
					   .data(dataset)
					   .enter()
					   .append("rect")
					   .attr("x", function(d, i) {
					   		return i * (w / dataset.length);
					   })
					   .attr("y", function(d) {
					   		return h - (d[4] * 4);
					   })
					   .attr("width", w / dataset.length - barPadding)
					   .attr("height", function(d) {
					   		return d[4] * 10;
					   })
					   .attr("fill", function(d){
					   		return "rgb(0, 0, " + (d * 10) + ")";
					   	})
					   .on("mouseover", function() {
					   		d3.select(this)
					   			.attr("fill", "red");
					   })
					   .on("mouseout", function(d) {
						   d3.select(this)
						   		.transition()
						   		.duration(250)
								.attr("fill", "rgb(0, 0, " + (d * 10) + ")");
					   });
					
					//Labels
					svg.selectAll("text")
						.data(dataset)
						.enter()
						.append("text")
						.text(function(d){
							return d[4];
						})
						.attr("text-anchor", "middle")
						.attr("x", function (d, i){
							return i * (w / dataset.length) + (w / dataset.length - barPadding) / 2;
						})
						.attr("y", function(d){
							return h - (d[4] * 4) + 14;
						})
						.attr("font-family", "sans-serif")
						.attr("font-size", "11px")
						.attr("fill", "white");
				});		
			</script>			
				
							</div> <!-- main -->

			<footer class="footer">

				

			</footer>
		</div> 	<!-- /container -->	

		<?php echo $scriptsAndSuch; ?>	
</body>

</html>