<?php 
    if (!isset($_COOKIE['artistID'])) {
        $artistID = $_COOKIE['artistID'];
    } else {
        // below doesn't work ... worry about it later
       // header('location: https://www.roxorsoxor.com/poprock/choose_artist.php');
    };
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

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">This Artist's Popularity Over Time</h3>
		</div>

		<div class="panel-body">
		<div id="forArt"></div> <!-- close forChart -->
		<div id="forChart"></div> <!-- close forChart -->
		</div> <!-- panel body -->

	</div> <!-- close Panel Primary -->

</div> <!-- close container -->

<script>

var w = 800;
var h = 300;
var padding = 40;

var dataset, xScale, yScale, xAxis, yAxis, line;

d3.json("functions/createArtistD3.php", function(data) {
    
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

<?php echo $scriptsAndSuch; ?>

</body>

</html>