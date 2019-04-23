<?php
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$artistGenre = $_GET['artistGenre'];

?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Artists Compare Bar Chart</title>
	<?php echo $stylesAndSuch; ?>
</head>

<body>

 <div class="container">
    <?php echo $navbar ?> 
    <p>Please be patient while data loads.</p>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 id="genreHeader" class="panel-title">These Artists' Current Popularity On Spotify</h3>
		</div>

		<div class="panel-body">
            <div id="forChart"></div> <!-- /for chart -->
        </div> <!-- panel body -->

	</div> <!-- close Panel Primary -->

    
</div> <!-- /container -->		 

<script type="text/javascript">
    d3.json("functions/genreArtists_popCurrentBars_Query.php?artistGenre=<?php echo $artistGenre; ?>", function(dataset) {
        console.log(dataset);
        // Width and height
        var w = 2400;
        var h = 265;
        var barPadding = 1;
        const widen = dataset.length;
        
        const artistGenre = dataset[0].genre;

        const genreTitle = d3.select("#genreHeader")
            //.data(dataset)
            //.append("text")
            .text(artistGenre + " -- Artists Current Popularity on Spotify");

        // Create SVG element
        var svg = d3.select("#forChart")
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
                return h - 64 - (d.pop * 2)
            })
            .attr("width", 64)
            .attr("height", function(d) {
                return (d.pop * 2);
            });
          
        // Images
        svg.selectAll("image")
            .data(dataset)
            .enter()
            .append("svg:image")
            .attr("xlink:href", function (d){
                return d.artistArt;
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
                return d.artistName;
            });			   
        
        // Popularity Labels atop columns
        svg.selectAll("text")
            .data(dataset)
            .enter()
            .append("text")
            .text(function(d){
                return d.pop;
            })
            .attr("text-anchor", "middle")
            .attr("x", function (d, i){
                return i * 65 + 65 / 2;
            })
            .attr("y", function(d){
                return h - 64 - (d.pop * 2) - 5;
            })
            .attr("font-family", "sans-serif")
            .attr("font-size", "11px")
            .attr("fill", "white");
    });		
</script>				


		<?php echo $scriptsAndSuch; ?>	
</body>

</html>