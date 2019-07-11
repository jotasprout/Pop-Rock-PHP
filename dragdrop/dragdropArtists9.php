<?php 
    require_once '../rockdb.php';
    require_once '../page_pieces/stylesAndScripts.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Drag-n-Drop 9</title>
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
    
const innerTo = {
    top: h/2 - margin.bottom + spacepadding,
    right: w - margin.right + spacepadding,
    left: margin.left + spacepadding,
    bottom: margin.bottom + spacepadding
};
    
const svg = d3.select("#forD3")
			  .append("svg")
			  .attr("width", w)
			  .attr("height", h);

let dropToReady = false;
let dragFromReady = false;
let choiceReady = false;
let chosenReady = false;

const dragFrom = svg.append("rect")
					.attr("id", "dragFrom")
					.style("fill", "red")
					.attr("x", margin.left)
					.attr("y", margin.top)
					.attr("class", "dragFrom")
					.attr("width", w - (margin.left + margin.right))
					.attr("height", 240)
				    .on("mouseover", function(){
                      if (chosenReady == true){
                          dragFromReady = true;
                          console.log("dragFrom is " + dragFromReady);
                      };
				    })
				    .on("mouseout", function(){
                        dragFromReady = false;
                        console.log("dragFrom is " + dragFromReady);
				    });

    
const dropTo = svg.append("rect")
				  .attr("id", "dropTo")
				  .attr("fill", "blue")
				  .attr("x", margin.left)
				  .attr("y", h/2 - (margin.top + margin.bottom))
				  .attr("class", "dropTo")
				  .attr("width", w - (margin.left + margin.right))
				  .attr("height", h/2 + margin.top)
				  .on("mouseover", function(){
                      if (choiceReady == true){
                          dropToReady = true;
                          console.log("dropTo is " + dropToReady);
                      };
				  })
				  .on("mouseout", function(){
					dropToReady = false;
					console.log("dropTo is " + dropToReady);
				  });
    
d3.json("dragDropCompare.php", function (dataset) {
    
    let droppedArtists = dataset.splice(0,5);
    
    console.log(dataset);
    
	console.log(droppedArtists);
    
    let firstChoices = svg.selectAll("image")
                          .data(dataset);
    
    let firstChosen = svg.selectAll("image.chosen")
                          .data(droppedArtists); 
    
    function makeChoices(whichChoices){
        //svg.selectAll("image")
           //.data(dataset)
           whichChoices.enter()
           .append("svg:image")
           .attr("xlink:href", function(d){
                return d.artistArtSpot;
           })
           .attr("transform", function (d,i){
                xOff = (i%10) * 75 + margin.left + spacepadding;
                yOff = Math.floor(i/10) * 75 + margin.top + spacepadding;
                return "translate(" + xOff + "," + yOff + ")";
           })
           .attr("data-artistName", (d) => d.artistNameSpot)
           .attr("data-artistPop", (d) => d.pop)
           .attr("data-artistSpotID", (d) => d.artistSpotID)
           .attr("data-popDate", (d) => d.date)
           .attr("class", "choice")
           .append("title")
           .text((d) => d.artistNameSpot)
           .attr("initial-x", (d) => d.x)
           .attr("initial-y", (d) => d.y);       
    };
    
    function makeChosen(whichChosen){
        //svg.selectAll("image.chosen")
           //.data(droppedArtists)
           whichChosen.enter()
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
           .attr("data-artistName", (d) => d.artistNameSpot)
           .attr("data-artistPop", (d) => d.pop)
           .attr("data-artistSpotID", (d) => d.artistSpotID)
           .attr("data-popDate", (d) => d.date)
           .attr("class", "chosen")
           .append("title")
           .text((d) => d.artistNameSpot)
           .attr("initial-x", (d) => d.x)
           .attr("initial-y", (d) => d.y);        
    };
    
    function makeColumns(){
        svg.selectAll("rect.column")
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
           })
           .attr("class", "column")
           .exit()
           .remove();
    };
    
    // Popularity text Labels atop columns
    function makeColumnLabels(){
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
    }
    
	function moveitonover(chosen){
        droppedArtists.push(chosen);
        console.log ("Added " + chosen.artistNameSpot + " to Chosen.");
        console.log(droppedArtists);
        let oldindex = dataset.indexOf(chosen);
        dataset.splice(oldindex, 1);
        console.log ("Removed " + chosen.artistNameSpot + " from Choices.");
        console.log(dataset);
    };
    
    function makeachoice(choice){
        dataset.push(choice);
        console.log ("Added " + choice.artistNameSpot + " to Choices.");
        console.log(dataset);
        let oldindex = droppedArtists.indexOf(choice);
        droppedArtists.splice(oldindex, 1);
        console.log ("Removed " + choice.artistNameSpot + " from Chosen.");
        console.log(droppedArtists);
    };

    
    // CHOICE
    
    const choiceHandler = d3.drag()
        .on("start", function (d){
            console.log ("Picked up " + d.artistNameSpot);
            choiceReady = true;
            console.log("choiceReady is " + choiceReady);
            d3.select(this)
              .attr("x", d3.event.x)
              .attr("y", d3.event.y);
        })
        .on("drag", function (d) {
            const mouse = d3.mouse(this);
            const picWidth = 64;
            const picHeight = 64;
            //console.log ("Dragging " + d.artistNameSpot);
            d3.select(this)
              // the event x and y under Start was here
              .attr("x", (mouse[0])-picWidth/2)
              .attr("y", (mouse[1])-picHeight/2)
              .attr("pointer-events", "none");
        })
        .on("end", function (d) {
            
            choiceReady = false;
            console.log("choiceReady is " + choiceReady);
            
            if (dropToReady == true){
                
                moveitonover(d);

                let newindex = droppedArtists.indexOf(d);
                
                d3.select(this)
                  .attr("transform", "translate(0,0)")
                  .attr("x", function (d) {
                        return innerTo.left + (newindex * 65);
                  })
                  .attr("y", function(d) {
                        return h - innerTo.bottom - 64;
                  })
                  .attr("pointer-events", "auto")
                  .attr("class", "chosen");
                
                let u = svg.selectAll(".column")
                           .data(droppedArtists);    
                
                u.enter()
                 .append("rect")
                 .merge(u)
                 .attr("x", function (d,i) {
                    return innerTo.left + (i * 65);
                 })
                 .attr("y", function(d) {
                    return h - innerTo.bottom - 64 - (d.pop * 2)
                 })
                 .attr("width", 64)
                 .attr("height", function(d) {
                    return (d.pop * 2);
                 })
                 .attr("class", "column");
                
                u.exit()
                 .remove();
                /**/
                let t = svg.selectAll("text")
                           .data(droppedArtists);
                t.exit().remove();
                
                makeColumnLabels();
                choiceHandler(svg.selectAll(".choice"));
                chosenHandler(svg.selectAll(".chosen"));
            } else {
                d3.select(this)
                  .attr("x", "initial-x")
                  .attr("y", "initial-y")
                  .attr("pointer-events", "auto");
            };
	   });
 
    
    // CHOSEN
    
    const chosenHandler = d3.drag()
        .on("start", function (d){
            console.log ("Wait, what?");
            chosenReady = true;
            console.log("chosenReady is " + chosenReady);
        })
        .on("drag", function (d) {
            const mouse = d3.mouse(this);
            const picWidth = 64;
            const picHeight = 64;
            d3.select(this)
              // the event x and y under Start was here
              .attr("x", (mouse[0])-picWidth/2)
              .attr("y", (mouse[1])-picHeight/2)
              .attr("pointer-events", "none");
        })
        .on("end", function (d) {
            
            chosenReady = false;
            console.log("chosenReady is " + chosenReady);
            
            if (dragFromReady == true){
                
                makeachoice(d);
                let k = dataset.indexOf(d);

                //let newlength = dataset.length;
                console.log ("k = " + k);
                
                d3.select(this)
                    
                  .attr("x", function (d) {
                    return (k%10) * 75 + margin.left + spacepadding;
                  })
                  .attr("y", function(d) {
                    return Math.floor(k/10) * 75 + margin.top + spacepadding;
                  })
                  .attr("pointer-events", "auto")
                  .attr("class", "choice");         
                
                let u = svg.selectAll(".column")
                           .data(droppedArtists);    
                
                u.enter()
                 .append("rect")
                 .merge(u)
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
                
                u.exit()
                 .remove();
                /**/
                let t = svg.selectAll("text")
                           .data(droppedArtists);
                
                t.enter()
                 .append("text")
                 .merge(t)
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
                
                t.exit().remove();
                
                let v = svg.selectAll(".chosen")
                           .data(droppedArtists);

                v.enter()
                 .append("svg:image")
                 .merge(v)                
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
                 .attr("data-artistName", (d) => d.artistNameSpot)
                 .attr("data-artistPop", (d) => d.pop)
                 .attr("data-artistSpotID", (d) => d.artistSpotID)
                 .attr("data-popDate", (d) => d.date)
                 .attr("class", "chosen")
                 .append("title")
                 .text((d) => d.artistNameSpot)
                 .attr("initial-x", (d) => d.x)
                 .attr("initial-y", (d) => d.y); 
                
                v.exit().remove();
                
                choiceHandler(svg.selectAll(".choice"));
                chosenHandler(svg.selectAll(".chosen"));
            } else {
                d3.select(this)
                  .attr("x", "initial-x")
                  .attr("y", "initial-y")
                  .attr("pointer-events", "auto");
            };
	   });
    
    makeChoices(firstChoices);
    makeChosen(firstChosen);
    
    makeColumns();
    makeColumnLabels();
    
	choiceHandler(svg.selectAll(".choice"));
    chosenHandler(svg.selectAll(".chosen"));
    
});
        
</script>

<?php echo $scriptsAndSuch; ?>	
<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbarIndex.js"></script>
<script src="https://www.roxorsoxor.com/poprock/dragdrop/dragdrop.js"></script>
</body>
</html>