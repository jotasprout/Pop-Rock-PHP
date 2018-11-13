<?php
$artistID = $_COOKIE['artistID'];
//	include 'page_pieces/sesh.php';
//	echo $_SESSION['artist'];
//	$artistID = $_SESSION['artist'];
//	echo $artistID;
//	$_SESSION['artist'] = $artistID;
	require "functions/class.artist.php";
    require_once 'page_pieces/stylesAndScripts.php';
    require_once 'page_pieces/navbar_rock.php';
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Album Info from My DB in D3</title>
	<?php echo $stylesAndSuch; ?>
</head>

<body>
<?php echo $navbar ?> <!-- /navbar -->

 <div class="container">
    <!--  -->
    <div id="forChart"></div> <!-- /for chart -->
</div> <!-- /container -->
		 	<!--  -->			 

<script type="text/javascript">
    d3.json("functions/createD3b.php", function(dataset) {
        console.log(dataset);
        // Width and height
        var w = 2400;
        var h = 265;
        var barPadding = 1;
        
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
            .attr("height", 64);			   
        
        
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
</body>

</html>