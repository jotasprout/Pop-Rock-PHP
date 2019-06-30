<?php 
    require_once '../rockdb.php';
    require_once '../page_pieces/stylesAndScripts.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Drag-n-Drop 2</title>
    <!--
        <script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
        <link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'> 
        <script src='https://d3js.org/d3.v4.min.js'></script>
        <link rel='stylesheet' href='lineGraphStyles.css'>
    
    -->
    <?php echo $stylesAndSuch; ?>  
    <link rel='stylesheet' href='dragDrop.css'>
</head>

<body>

<div class="container">
<div id="fluidCon"></div> <!-- end of fluidCon -->
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Drag and Drop Artists</h3>
		</div>
		<div class="panel-body">
            <div id="forD3"></div> <!-- /for chart -->
        </div> <!-- panel body -->
	</div> <!-- close Panel Primary -->
</div> <!-- /container -->

<script>

const w = 850;
const h = 800;
	
const margin = {
	top: 20,
	right: 20,
	bottom: 20,
	left: 20
};
	
const spacepadding = 10;	

const drag = d3.drag();

d3.json("dragDropCompare.php", function (dataset) {

    console.log(dataset);

    let droppedArtists = dataset.splice(0,5);

    const svg = d3.select("#forD3")
                  .append("svg")
				  .attr("width", w)
				  .attr("height", h);
	/*
	const bg = svg.append("rect")
				  .style("fill", "gray")
				  .attr("width", w)
				  .attr("height", h);
	*/
	const dragFrom = svg.append("rect")
					//.attr("class", "space")
					.attr("id", "dragFrom")
					.style("fill", "red")
					.attr("x", margin.left)
					.attr("y", margin.top)
                    .attr("width", w - (margin.left + margin.right))
                    .attr("height", 240);
	
	let dropToReady = false;
	
	const dropTo = svg.append("rect")
					//.attr("class", "space")
					.attr("id", "dropTo")
					.attr("fill", "blue")
					.attr("x", margin.left)
					.attr("y", h/2 - (margin.top + margin.bottom))
                    .attr("width", w - (margin.left + margin.right))
                    .attr("height", h/2 + margin.top)
					.attr("data-ready", false)
					.on("mouseover", function(){
						dropToReady = true;
						//console.log("dropTo is " + dropToReady);
					})
					.on("mouseout", function(){
						dropToReady = false;
						//console.log("dropTo is " + dropToReady);
					});

	//d3.selectAll(".choice").call(drag);
	
	console.log(dataset);
	console.log(droppedArtists);

    const barPadding = 1;

    const innerTo = {
        top: h/2 - margin.bottom + spacepadding,
        right: w - margin.right + spacepadding,
        left: margin.left + spacepadding,
        bottom: margin.bottom + spacepadding
    };
    
    const faces = svg.selectAll("#dragFrom").data(dataset).enter()
		.append("g")
		.attr("transform", function (d,i){
			xOff = (i%10) * 75 + margin.left + spacepadding;
			yOff = Math.floor(i/10) * 75 + margin.top + spacepadding;
			return "translate(" + xOff + "," + yOff + ")";
		});
	
	faces.append("svg:image")
		 .attr("xlink:href", function(d){
			return d.artistArtSpot;
		})
		.attr("data-artistName", (d) => d.artistNameSpot)
		.attr("data-artistPop", (d) => d.pop)
		.attr("data-artistSpotID", (d) => d.artistSpotID)
		.attr("data-popDate", (d) => d.date)
		.attr("class", "choice")
		.append("title")
        .text((d) => d.artistNameSpot);
        
    
	// Column Chart

	// Columns representing popularity
	svg.selectAll("rect")
		.data(droppedArtists)
		.enter()
		.append("rect")
		.attr("x", function (d,i) {
			return innerTo.left + (i * 65);
		})
		.attr("y", function(d) {
			return h - innerTo.bottom - 64 - (d.pop * 2)
		})
		.attr("width", 64)
		.attr("height", function(d) {
			return (d.pop * 2);
		});

    // photo of artist
	svg.selectAll("image")
		.data(droppedArtists)
		.enter()
		.append("svg:image")
		.attr("xlink:href", function (d){
			return d.artistArtSpot;
		})
		.attr("x", function (d,i) {
			return innerTo.left + (i * 65);
		})
		.attr("y", function(d) {
			return h - innerTo.bottom - 64;
		})
		.attr("width", 64)
		.attr("height", 64)
		.append("title")
		.text(function(d){
			return d.artistNameSpot;
		});			   
        
    // Popularity text Labels atop columns
    svg.selectAll("text")
		.data(droppedArtists)
		.enter()
		.append("text")
		.text(function(d){
			return d.pop;
		})
		.attr("text-anchor", "middle")
		.attr("x", function (d, i){
			return innerTo.left + (i * 65 + 65 / 2);
		})
		.attr("y", function(d){
			return h - innerTo.bottom - 64 - (d.pop * 2) - 5;
		})
		.attr("font-family", "sans-serif")
		.attr("font-size", "11px")
		.attr("fill", "white");
});

</script>

<?php echo $scriptsAndSuch; ?>	
<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbarIndex.js"></script>
<script src="https://www.roxorsoxor.com/poprock/dragdrop/dragdrop.js"></script>
</body>
</html>