<?php 
    $artistSpotID = $_GET['artistSpotID'];
    $artistMBID = $_GET['artistMBID'];
	require_once 'page_pieces/stylesAndScripts.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Albums Scatterplot | PopRock</title>
	
	<?php echo $stylesAndSuch; ?>
	<style>
		.axis path,
		.axis line {
			fill: none;
			stroke: white;
			shape-rendering: crispEdges;
		}
		
		.axis text {
			font-family: sans-serif;
			fill: white;
		}
	
	</style>
</head>

<body>

<div class="container-fluid">
	
<div id="fluidCon"></div> <!-- end of fluidCon -->

    <div class="panel panel-primary">
		<div class="panel-heading">
			<h3 id="name" class="panel-title">ScatterPop</h3>
		</div>
		<div class="panel-body">
			<div id="popchart"></div>
		</div> <!-- panel body -->
	</div> <!-- close Panel Primary -->

</div> <!-- close container-fluid -->

<script type="text/javascript">
	
d3.json("functions/createAlbumsD3.php?artistSpotID=<?php echo $artistSpotID ?>", function(dataset) {
	console.log(dataset);

    const w = 1800;
    const h = 800;
    const margin = {
        top: 25,
        right: 25,
        bottom: 25,
        left: 25
    };
        
    const startYear = d3.min(dataset, function(d) { return d.yearReleased; });
    const stopYear = d3.max(dataset, function(d) { return d.yearReleased; });

    //const year = timeFormat('%Y');

    const rowConverter = function(d){
        return {
            title: d.title,
            yearReleased: parseTime(d.yearReleased),
            plays: d.plays
        };
    };

    const artistNameSpot = dataset[0].artistNameSpot;

	const artistTitle = d3.select("#name")
		                  .text(artistNameSpot + "'s albums' LastFM playcount as of xxx, 2019");
	
	const xScale = d3.scaleLinear()
					 .domain([
                        d3.min(dataset, function(d) { return d.yearReleased; }),
                        d3.max(dataset, function(d) { return d.yearReleased; })                  
                     ])
					 .range([margin.left, w-margin.right]);

    const pop = function(d){
        return d.pop;
    }

    const plays = function(d){
        return d.plays;
    }

	const yScale = d3.scaleLinear()
					 .domain([
                        d3.min(dataset, function(d) { return d.pop; }),
                        d3.max(dataset, function(d) { return d.pop; })                         
                     ])
					 .range([h-margin.bottom, margin.top]);


	var svg = d3.select("#popchart")
		.append("svg")
		.attr("width", w)
		.attr("height", h);

	// Images
	svg.selectAll("image")
		.data(dataset)
		.enter()
		.append("svg:image")
		.attr("xlink:href", function (d){
			return d.albumArtSpot;
		})
		.attr("x", function (d) {
			released = parseInt(d.yearReleased);
			return xScale(released);
		})
		.attr("y", function(d) {
			pop = parseInt(d.pop);
			return yScale(pop);
		})
		.attr("width", 64)
		.attr("height", 64)
	    .attr("transform", "translate(-32, -32)")
		.append("title")
		.text(function(d){
			return d.albumNameSpot;
		});
	
	const formatYear = d3.format("d");
	
	const xAxis = d3.axisBottom()
					.scale(xScale)
					.tickFormat(formatYear);
	
	svg.append("g")
		.attr("class", "axis")
	   .attr("transform", "translate(0," + (h-margin.bottom) + ")")
	   .call(xAxis);

});		
</script>	


<?php echo $scriptsAndSuch; ?>

<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbarIndex.js"></script>
</body>

</html>