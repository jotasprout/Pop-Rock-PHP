<?php 
    $artistMBID = $_GET['artistMBID'];
    $artistSpotID = $_GET['artistSpotID'];
	require_once 'page_pieces/stylesAndScripts.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Artist LastFM Charts | PopRock</title>
	<?php echo $stylesAndSuch; ?>
	<style type="text/css">

	</style>
</head>

<body>

<div class="container-fluid">
<div id="fluidCon"></div> <!-- end of fluidCon -->
<!-- 
    <p>If, after the page loads, it is empty, or the wrong discography displays, <a href='https://www.roxorsoxor.com/poprock/index.php'>choose an artist</a> from the <a href='https://www.roxorsoxor.com/poprock/index.php'>Artists List</a> first.</p>
 -->
<div class="panel panel-primary">

    <div class="panel-heading">
        <h3 class="panel-title" id="topHead">Current Stats for </h3>
    </div> <!-- close panel-heading -->
        
  <div class="panel-body">

       <div class="row">

            <div class="col-md-2 popStyle">
                <img id="forArt">
            </div> <!-- End of Column 1 -->

            <div class="col-md-3">
                <ul class="list-group">
                    	<li class="list-group-item d-flex justify-content-between align-items-center">
							Popularity on Spotify
							<span class="badge badge-primary badge-pill" id="forCurrentPopularity"></span>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							Followers on Spotify
							<span class="badge badge-primary badge-pill" id="forCurrentFollowers"></span>
						</li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Listeners on LastFM
                        <span class="badge badge-primary badge-pill" id="forCurrentListeners">No data yet</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Playcount on LastFM
                        <span class="badge badge-primary badge-pill" id="forCurrentPlaycount">No data yet</span>
                    </li>
                </ul>
            </div> <!-- End of Column 2 -->

            <div class="col-md-7"></div>

        </div> <!-- End of row -->
        
  </div> <!-- End of Card Body -->
</div> <!-- End of Card -->
	
<!-- START OF ROW #2 WITH POPULARITY LINE GRAPH AND FOLLOWERS LINE GRAPH -->	
	
<div class="row"> <!-- Start of Row 2 -->	
    <div class="col-md-6"> <!-- Start of Column 1 -->
    </div> <!-- End of Column 1 -->
    <div class="col-md-6"> <!-- Start of Column 2 -->
    </div> <!-- End of Column 2 -->
</div> <!-- End of row 2 -->	

	
	<!-- START OF ROW #3 WITH ALBUMS COLUMNS -->
	
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
    
var w = 740;
var h = 400;
var padding = 40;

var dataset, xScale, yScale, xAxis, yAxis, line;
    
d3.json("functions/get_artist_LastFM.php?artistSpotID=<?php echo $artistSpotID; ?>&artistMBID=<?php echo $artistMBID ?>", function(dataset) {

    console.log(dataset);
    const data = dataset;
    console.log(data);


    const artistNameMB = dataset[0].artistNameMB;
    console.log(artistNameMB);

    const artistTitle = d3.select("#albumPop")
        .text(artistNameMB + "'s albums' current popularity on Spotify");

    const nameInTitle = d3.select("title")
            .text(artistNameMB + "'s current stats on Spotify and LastFM")    

    const topHeading = d3.select("#topHead")
            .text(artistNameMB + "'s current stats on Spotify and LastFM");   

    const artistArtMB = dataset[0].artistArtMB;
    d3.select("#forArt")
            .data(dataset)
            .attr("src", artistArtMB)
            .attr("height", 166);
            //.attr("width", auto)
    
    const dataListeners = data[0].artistListeners;
    let listeners = String(dataListeners).replace(/(.)(?=(\d{3})+$)/g,'$1,');
    const artistListeners = d3.select("#forCurrentListeners")
                              .text(listeners);   

    const dataPlaycount = data[0].artistPlaycount;
    let playcount = String(dataPlaycount).replace(/(.)(?=(\d{3})+$)/g,'$1,');
    const artistPlaycount = d3.select("#forCurrentPlaycount")
                              .text(playcount); 

});   
     
</script>
    
    
<script>

var w = 740;
var h = 400;
var padding = 40;

var dataset, xScale, yScale, xAxis, yAxis, line;

d3.json("functions/createArtistSpotD3.php?artistSpotID=<?php echo $artistSpotID; ?>&artistMBID=<?php echo $artistMBID ?>", function(data) {
    
    console.log(data);
    
    var dataset = data;

    const artistNameSpot = dataset[0].artistNameSpot;

    const currentPopArtist = dataset[0].pop;

    const currentPop = d3.select("#forCurrentPopularity")
            .text(currentPopArtist);               

    const dataFollowers = dataset[0].followers;
    let followers = String(dataFollowers).replace(/(.)(?=(\d{3})+$)/g,'$1,');

    const artistFollowers = d3.select("#forCurrentFollowers")
            .text(followers);  

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
               //.domain(d3.extent(data, function(d) { return d.pop; }))
               // Above is lowest to highest
               // Below is 0-100 
               .domain([0, 100])
               .range([h - padding, padding]);

    const xAxis = d3.axisBottom()
                    .scale(xScale)
                    .tickFormat(d3.timeFormat("%b"));

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
    
<!--    
<script>
	d3.json("functions/get_assocArtists.php?artistSpotID=<?php //echo $artistSpotID ?>&artistMBID=<?php //echo $artistMBID ?>", function (assocData) {

	console.log(assocData);

	
	const assocFaces = d3.select("#assocArtists");
	
	assocFaces.selectAll("img")
			  .data(assocData)
			  .enter()
			  .append("img")
			  .attr("src", function (d){
				if (d.artistArtMB == "" || d.artistArtMB == null || d.artistArtMB == undefined) {
					console.log("artistArt is " + d.artistArtSpot);
					return d.artistArtMB;
				} else {
					console.log("artistArtMB is " + d.artistArtMB);
					return d.artistArtMB;
				};
			  })
			  .attr("x", function (d,i) {
				return i * 65;
			  })
			  .attr("height", 128)
			  .attr("title", (d) => d.assocArtistName);
});

</script>		
-->		
	
<script type="text/javascript">
    d3.json("functions/createAlbumsD3.php?artistSpotID=<?php echo $artistSpotID ?>", function(dataset) {
        console.log(dataset);
        // Width and height
        var w = 2400;
        var h = 265;
        var barPadding = 1;
        
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



<?php echo $scriptsAndSuch; ?>
    
<script>
const artistSpotID = '<?php echo $artistSpotID; ?>';
const artistMBID = '<?php echo $artistMBID ?>';
</script>

<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbar.js"></script>
</body>

</html>