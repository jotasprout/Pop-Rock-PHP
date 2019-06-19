<?php 
	require_once 'page_pieces/stylesAndScripts.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Albums Scatterplot | PopRock</title>
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
	
    d3.json("BlackSabbathalbumsLastFM.json", function(dataset) {
        console.log(dataset);
        
		
        const w = 1000;
		const h = 1000;
		const padding = 50;
		
		const minplays, maxplays;

        const artistName = "Black Sabbath";

        const artistTitle = d3.select("#name")
            .text(artistName + "'s albums' current popularity on Spotify");
        
        
        var svg = d3.select("#recordCollection")
            .append("svg")
            .attr("width", w)
            .attr("height", h);
        
        svg.selectAll("circle")
            .data(dataset)
            .enter()
            .append("circle")
            .attr("cx", function (d) {
                return d[2];
            })
            .attr("cy", function(d) {
                return d[3]
            })
            .attr("r", 5);
        // Images
        svg.selectAll("image")
            .data(dataset)
            .enter()
            .append("svg:image")
            .attr("xlink:href", function (d){
                return d.albumArtSpot;
                console.log(d.albumArtSpot);
            })
            .attr("x", function (d,i) {
                return i * 65;
            })
            .attr("y", function(d) {
                return h - 64
            })
            .attr("width", 64)
            .attr("height", 64)
            .append("title")
            .text(function(d){
                return d.albumName;
            });			   
        
        // Labels
        svg.selectAll("text")
            .data(dataset)
            .enter()
            .append("text")
            .text(function(d){
                return d[4];
            })
            .attr("text-anchor", "middle")
            .attr("x", function (d, i){
                return i * 65 + 65 / 2;
            })
            .attr("y", function(d){
                return h - 64 - (d[4] * 2) - 5;
            })
            .attr("font-family", "sans-serif")
            .attr("font-size", "11px")
            .attr("fill", "white");
    });		
</script>	


<?php echo $scriptsAndSuch; ?>77777

<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbar.js"></script>
</body>

</html>