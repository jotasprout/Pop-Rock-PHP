<?php
    require_once '../page_pieces/stylesAndScripts.php';
    $artistGenre = $_GET['artistGenre'];
    echo $artistGenre;

    $connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$genreArtistsRecentWithArt = "SELECT a.artistSpotID AS artistSpotID, a.artistArtSpot AS artistArtSpot, a.artistNameSpot AS artistNameSpot, g.genre AS genre, p1.pop AS pop, p1.date AS date
    FROM artistsSpot a
    JOIN (SELECT p.*
			FROM popArtists p
			INNER JOIN (SELECT artistSpotID, pop, max(date) AS MaxDate
						FROM popArtists  
						GROUP BY artistSpotID) groupedp
			ON p.artistSpotID = groupedp.artistSpotID
			AND p.date = groupedp.MaxDate) p1
	ON a.artistSpotID = p1.artistSpotID
	JOIN genres g ON a.artistSpotID = g.artistID WHERE g.genre = '$artistGenre'   
    ORDER BY a.artistNameSpot ASC";
    
$result = mysqli_query($connekt, $genreArtistsRecentWithArt);

$myPeeps = array ();

if (mysqli_num_rows($result) > 0) {
	$rows = array();
	while ($row = mysqli_fetch_array($result)) {
		$rows[] = $row;
	}
	$myPeeps = json_encode($rows);
}

else {
	echo "Nope. Nothing to see here.";
}
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
 <div id="fluidCon"></div> <!-- end of fluidCon -->
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
    const myPeeps = <?php echo $$myPeeps; ?>;
    d3.json(myPeeps, function(dataset) {
        console.log(dataset);
        // Width and height
        var w = 2400;
        var h = 265;
        var barPadding = 1;
        //const widen = dataset.length;
        
        const artistGenre = dataset[0].genre;

        const genreTitle = d3.select("#genreHeader")
            .data(dataset)
            .append("text")
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
                return d.artistArtSpot;
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
                return d.artistNameSpot;
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
        <script src="https://www.roxorsoxor.com/poprock/page_pieces/navbarIndex.js"></script>
</body>

</html>