<?php 
    require_once '../rockdb.php';
    //require_once '../data_text/artists_groups.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Drag-n-Drop</title>

    <script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
	<!--
    <script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
	-->
    <script src='https://d3js.org/d3.v4.min.js'></script>
	<!--
    Do I need the next line? Or is it included in d3?
	-->	
	<script src="https://d3js.org/d3-drag.v1.min.js"></script>

    <link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>   
    <link rel='stylesheet' href='dragDrop.css'>
	<link rel='stylesheet' href='lineGraphStyles.css'>
</head>

<body>

<script>

const w = 1000;
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
	
	//const picWidth = 64;
	//const picHeight = 64;

    const svg = d3.select("body")
                  .append("svg")
				  .attr("width", w + margin.left + margin.right)
				  .attr("height", h + margin.top + margin.bottom);
	
	const bg = svg.append("rect")
				  .style("fill", "gray")
				  .attr("width", w)
				  .attr("height", h);
	
	const dragFrom = svg.append("rect")
					.attr("class", "space")
					.attr("id", "dragFrom")
					.style("fill", "red")
					.attr("x", margin.left)
					.attr("y", margin.top);
	
	const dropTo = svg.append("rect")
					.attr("class", "space")
					.attr("id", "dropTo")
					.attr("fill", "blue")
					.attr("x", margin.left)
					.attr("y", 340);

	const faces = svg.selectAll("#dragFrom").data(dataset).enter()
		.append("g")
		.attr("transform", function (d,i){
			xOff = (i%10) * 75 + margin.left + spacepadding;
			yOff = Math.floor(i/10) * 75 + margin.top + spacepadding;
			return "translate(" + xOff + "," + yOff + ")";
		});
	
	faces.append("svg:image")
		 .attr("xlink:href", function(d){
			return d.artistArt;
		})
		.attr("data-artistName", (d) => d.artistName)
		.attr("data-artistPop", (d) => d.pop)
		.attr("data-artistSpotID", (d) => d.artistSpotID)
		.attr("data-popDate", (d) => d.date)
		.attr("class", "choice")
		.append("title")
		.text((d) => d.artistName);
	
	// DRAG HANDLER
	const dragHandler = d3.drag()
		.on("drag", function () {
			const mouse = d3.mouse(this);
			const picWidth = 64;
			const picHeight = 64;
			d3.select(this)
			  //.attr("x", d3.event.x)
			  //.attr("y", d3.event.y)
			  .attr("x", (mouse[0])-picWidth/2)
			  .attr("y", (mouse[1])-picWidth/2);
		});
	
	dragHandler(svg.selectAll(".choice"));
/*
	const drag = d3.drag()
				   .on("dragstart", function(){
					   // do some drag start stuff
				   })
				   .on("drag", function(){
					   // hey we are dragging let us update some stuff
				   })
				   .on("dragend", function(){
					   // we are done, end some stuff
				   });
*/
	//d3.selectAll(".choice").call(drag);
});

</script>





<script src="https://www.roxorsoxor.com/poprock/dragdrop/dragdrop.js"></script>
</body>
</html>