<?php 
	require_once 'page_pieces/stylesAndScripts.php';
    require_once 'page_pieces/navbar_rock.php'; 
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>These Artists Popularity</title>
    
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

        .artistName {
            font-size: 14px;
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
			<h3 class="panel-title">These Artists Popularity Over Time</h3>
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
const paddingBottom = 150;

var dataset, xScale, yScale, xAxis, yAxis, line;

d3.json("functions/multiArtistsPop2.php", function(data) {

        console.log(data);
    
        var dataset = data;

        var parseTime = d3.timeParse("%y-%m-%d");

        const title = "Inductees for Class of 2019";

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
                        .attr("height", h + paddingBottom);

        const dataNest = d3.nest()
                        .key(function(d) { return d.artistID;})
                        .entries(data);

        const color = d3.scaleOrdinal(d3.schemeCategory10);

        dataNest.forEach(function(d) {
            svg.append("path")
               .attr("class", "line")
               .style("stroke", function(){
                   return d.color = color(d.key);
               })
               .attr("d", line(d.values));
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

        
        dataNest.forEach(function(d, i) {

            svg.append("svg:image")
               .attr("xlink:href", d.values[0].artistArt)
               .attr("x", (i) * 110)
               .attr("y", h + 50)
               .attr("width", 64)
               .attr("height", 64);

            svg.append("rect")
               .attr("x", (i) * 110)
               .attr("y", h + 50)
               .attr("width", 64)
               .attr("height", 64)
               .style("stroke", function(){
                   return d.color = color(d.key);
               })
               .style("stroke-width", 4)
               .style("fill-opacity", 0);

            svg.append("text")
                .style("text-anchor", "middle")
                .attr("class", "artistName")
                .attr("x", (i) * 110 + 32)
               .attr("y", h + paddingBottom)
                .text(d.values[0].artistName)
                .attr("fill", function(){
                   return d.color = color(d.key);
               });
        })
        
        

    })
</script>

<?php echo $scriptsAndSuch; ?>

</body>

</html>