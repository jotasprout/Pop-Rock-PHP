<?php 
    $artistID = $_GET['artistID'];
	require_once 'page_pieces/stylesAndScripts.php';
	require_once 'page_pieces/navbar_rock.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>This Artist</title>
	<?php echo $stylesAndSuch; ?>
	<style type="text/css">
		.line {
			fill: none;
			stroke: #00BFFF;
			stroke-width: 2;
		}

        #title {
            font-size: 24px;
            font-weight: bold;
            fill: white;
        }

        .axis {
            font-size: 14px;
        }

        .axis line {
            stroke: yellow;
        }

        .axis path {
            stroke: yellow;
        }

        .axis text {
            fill: yellow;
        }
	</style>
</head>

<body>

<div class="container">
	<?php echo $navbar ?>

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">This Artist's Popularity On Spotify Over Time</h3>
		</div>

		<div class="panel-body">
		<div id="forArt"></div> <!-- close forArt -->
		<div id="forArtistChart"></div> <!-- close forChart -->
		</div> <!-- panel body -->

    </div> <!-- close Panel Primary -->
    
    <div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">This Artist's Albums Current Popularity</h3>
		</div>

		<div class="panel-body">
		<table class="table" id="recordCollection">
            <thead>
                <tr>
                    <th>Album Art</th>
                    <th onClick="sortColumn('albumName', 'ASC')"><div class="pointyHead">Album Name</div></th>
                    <th onClick="sortColumn('year', 'DESC')"><div class="pointyHead">Released</div></th>
                    <th onClick="sortColumn('pop', 'ASC')"><div class="pointyHead">Popularity</div></th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src='<?php echo $albumArt ?>' height='64' width='64'></td>
                    <!-- NEED TO CREATE FUNCTION IN NEXT LINE -->
                    <td><a href='https://www.roxorsoxor.com/poprock/thisAlbum_TracksList.php?albumID=<?php echo $albumID ?>'><?php echo $albumName ?></a></td>
                    <td><?php echo $albumReleased ?></td>
                    <td><?php echo $albumPop ?></td>

                </tr>
            </tbody>
			</table>
		</div> <!-- panel body -->

	</div> <!-- close Panel Primary -->

</div> <!-- close container -->

<script>

var w = 1100;
var h = 400;
var padding = 40;

var dataset, xScale, yScale, xAxis, yAxis, line;

d3.json("functions/createArtistD3.php?artistID=<?php echo $artistID; ?>", function(data) {
    
    console.log(data);
    
    var dataset = data;

    var parseTime = d3.timeParse("%y-%m-%d");

    console.log("Artist name is " + data[0].artistName)

    const title = data[0].artistName;

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
                .range([padding, w - padding]);


    yScale = d3.scaleLinear()
               .domain(d3.extent(data, function(d) { return d.pop; }))
               .range([h - padding, padding]);
               
    const xAxis = d3.axisBottom()
                    .scale(xScale);

    const yAxis = d3.axisLeft()
                    .scale(yScale);

    var line = d3.line()
                .x(function(d) { return xScale(d.date); })
                .y(function(d) { return yScale(d.pop); });

    var svg = d3.select("#forArtistChart")
                    .append("svg")
                    .attr("width", w)
                    .attr("height", h);

    svg.append("path")
        .datum(dataset)
        .attr("class", "line")
        .attr("d", line);

    svg.append("g")
       .call(xAxis)
       .attr("transform", "translate(0," + (h - padding) + ")")
       .attr("class", "axis");

    svg.append("g")
       .call(yAxis)
       .attr("transform", "translate(" + padding + ",0)")
       .attr("class", "axis");

    svg.append("text")
       .style("text-anchor", "middle")
       .attr("id", "title")
       .attr("x", w/2)
       .attr("y", 25)
       .text(`${title}`);
});

</script>

<?php echo $scriptsAndSuch; ?>

</body>

</html>