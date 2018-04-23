<?php
    require_once '../stylesAndScripts.php';
    require_once '../navbar_rock.php';
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <?php echo $stylesAndSuch; ?>
    <script src="https://d3js.org/d3.v4.min.js"></script>
</head>

<body>
<DIV class="container">
	    
        <?php echo $navbar ?> <!-- /navbar -->
        <div id="chart"></div>

<script>

    d3.json("createD3.php", function(dataset) {

        var w = 1000;
        var h = 200;
        var barPadding = 1;

        var svg = d3.select("#chart")
            .append("svg")
            .attr("width", w)
            .attr("height", h)
            .attr("fill", "yellow");

        svg.selectAll("rect")
            .data(dataset)
            .enter()
            .append("rect")
            .attr("x", function (d,i) {
                return i * 65;
            })
            .attr("y", function(d) {
                return h - (d[4] + 64)
            })
            .attr("width", 64)
            .attr("height", function(d) {
                return (d[4] + 64);
            });
/*
        svg.selectAll("svg:image")
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
            .attr("y", 64)
            .attr("width", 64)
            .attr("height", 64);
*/           

    });



</script>
							</div> <!-- main -->

<footer class="footer">

    

</footer>
</div> 	<!-- /container -->	

<?php echo $scriptsAndSuch; ?>	
</body>

</html>