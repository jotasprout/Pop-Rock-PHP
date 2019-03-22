<?php 
    $artistID = $_GET['artistID'];
	require_once 'page_pieces/stylesAndScripts.php';
	require_once 'page_pieces/navbar_rock.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Artist Data | PopRock</title>
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
    <?php echo $navbar ?>
    <p>Please be patient while data loads.</p>
    <p>If, after the page loads, it is empty, or the wrong discography displays, <a href='https://www.roxorsoxor.com/poprock/index.php'>choose an artist</a> from the <a href='https://www.roxorsoxor.com/poprock/index.php'>Artists List</a> first.</p>


    <p><img id="forArt"></p>
    <p><strong>Popularity</strong> on <strong>Spotify</strong>: <span id="forCurrentPopularity"></span></p> 
    <p><strong>Followers</strong> on <strong>Spotify</strong>:  <span id="forCurrentFollowers"></span></p> 
	<p><strong>Listeners</strong> on <strong>LastFM</strong>: <span id="forCurrentListeners">No data yet</span></p> 
    <p><strong>Playcount</strong> on <strong>LastFM</strong>:  <span id="forCurrentPlaycount">No data yet</span></p> 

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 id="artistPop" class="panel-title">This artist's popularity on Spotify over time</h3>
		</div> <!-- close panel-heading -->

		<div class="panel-body">
            <div id="forArtistChart"></div> <!-- close forChart -->
		</div> <!-- panel body -->
    </div> <!-- close Panel Primary -->
    
    <div class="panel panel-primary">
		<div class="panel-heading">
			<h3 id="albumPop" class="panel-title">This Artist's Albums Current Popularity</h3>
		</div>

		<div class="panel-body">
			<div id="recordCollection"></div>
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

    const artistName = dataset[0].artistName;

    const artistTitle = d3.select("#artistPop")
            .text(artistName + "'s popularity on Spotify over time");   

    const currentPopArtist = dataset[0].pop;

    const currentPop = d3.select("#forCurrentPopularity")
            .text(currentPopArtist);               

    const dataFollowers = dataset[0].followers;
    let followers = String(dataFollowers).replace(/(.)(?=(\d{3})+$)/g,'$1,');

    const artistFollowers = d3.select("#forCurrentFollowers")
            .text(followers);  

    const artistArt = dataset[0].artistArt;

    d3.select("#forArt")
            .data(dataset)
            .attr("src", artistArt)
            .attr("height", 128);
            //.attr("width", auto)

    dataset.forEach(function(d) {
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

});

</script>
	
<script type="text/javascript">
    d3.json("functions/createAlbumsD3.php?artistID=<?php echo $artistID ?>", function(dataset) {
        console.log(dataset);
        // Width and height
        var w = 2400;
        var h = 265;
        var barPadding = 1;

        const artistName = dataset[0].artistName;

        const artistTitle = d3.select("#albumPop")
            .text(artistName + "'s albums' current popularity");
        
        // Create SVG element
        var svg = d3.select("#recordCollection")
            .append("svg")
            .attr("width", w)
            .attr("height", h);
        // Rectangles
        svg.selectAll("rect")
            .data(dataset)
            .enter()
            .append("rect")
            .attr("x", function (d,i) {
                return i * 65;
            })
            .attr("y", function(d) {
                return h - 64 - (d[4] * 2)
            })
            .attr("width", 64)
            .attr("height", function(d) {
                return (d[4] * 2);
            });
        // Images
        svg.selectAll("image")
            .data(dataset)
            .enter()
            .append("svg:image")
            .attr("xlink:href", function (d){
                return d.albumArt;
                console.log(d.albumArt);
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

<script>

    d3.json("functions/getCurrentLastFM.php?artistID=<?php echo $artistID; ?>", function(dataset) {
        
        console.log(dataset);
        
        var data = dataset;

        const dataListeners = data.artistListeners;
        let listeners = String(dataListeners).replace(/(.)(?=(\d{3})+$)/g,'$1,');

        const listen = d3.select("#forCurrentListeners")
               .text(listeners);   

        const dataPlaycount = data.artistPlaycount;
        let playcount = String(dataPlaycount).replace(/(.)(?=(\d{3})+$)/g,'$1,');

        const play = d3.select("#forCurrentPlaycount")
               .text(playcount); 

    });   
     
</script>

<?php echo $scriptsAndSuch; ?>

</body>

</html>