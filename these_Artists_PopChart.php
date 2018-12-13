<?php 
	require_once 'page_pieces/stylesAndScripts.php';
	require_once 'page_pieces/navbar_rock.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>These Artists Popularity</title>
    <!--
    <script src="https://unpkg.com/d3-fetch"></script>
    -->
    
    <script src="js/d3-fetch.v1.min.js"></script>
    
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
			<h3 class="panel-title">This Artist's Popularity Over Time</h3>
		</div>

		<div class="panel-body">
		<div id="forArt"></div> <!-- close forChart -->
		<div id="forChart"></div> <!-- close forChart -->
		</div> <!-- panel body -->

	</div> <!-- close Panel Primary -->

</div> <!-- close container -->

<script>

var w = 1100;
var h = 400;
var padding = 40;

var dataset, xScale, yScale, xAxis, yAxis, line;

const noms2019 = ["0UKfenbZb15sqhfPC6zbt3", "4WquJweZPIK9qcfVFhTKvf", "0nJUwPwC9Ti4vvuJ0q3MfT", "1P8IfcNKwrkQP5xJWuhaOC", "2d0hyoQ5ynDBnkvAbJKORj", "0dmPX6ovclgOy8WWJaFEUU", "0Lpr5wXzWLtDWm1SjNbpPb", "1YLsqPcFg1rj7VvhfwnDWm"];

const induct2019 = ["7bu3H8JO7d0UbMoVzbo70s", "6H1RjVyNruCmrBEWRbD0VZ", "7crPfGd2k81ekOoSqQKWWz", "4qwGe91Bz9K2T8jXTZ815W", "4Z8W4fKeB5YxbusRsdQVPb", "3fhOTtm0LBJ3Ojn4hIljLo", "2jgPkn6LuUazBoBk6vvjh5"];

d3.json("functions/multiArtistsPop.php", {
    method: "POST",
    body: JSON.stringify({
        artists: `${noms2019}`
    }),
    headers: {
        "content-type": "application/json; charset=UTF-8"
    }
}, function(data) {

        console.log(data);
    
        var dataset = data;

        var parseTime = d3.timeParse("%y-%m-%d");

        const title = "Nominees for Class of 2019";

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
                .domain([0, 100])
                .range([h - padding, padding]);
                
        const xAxis = d3.axisBottom()
                        .scale(xScale);

        const yAxis = d3.axisLeft()
                        .scale(yScale);

        var line = d3.line()
                    .x(function(d) { return xScale(d.date); })
                    .y(function(d) { return yScale(d.pop); });

        var svg = d3.select("#forChart")
                        .append("svg")
                        .attr("width", w)
                        .attr("height", h);

        const dataNest = d3.nest()
                        .key(function(d) { return d.artistID;})
                        .entries(data);

        dataNest.forEach(function(d) {
            svg.append("path")
            //.datum(dataset)
            // took out above because TnT does not have it
            .attr("class", "line")
            //.attr("d", line);
            // took out above because TnT code is so different as follows
            .attr("d", line(d.values))
        })

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
    }).catch(err => {
        console.log(err);
    });

</script>

<?php echo $scriptsAndSuch; ?>

</body>

</html>