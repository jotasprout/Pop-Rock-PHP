<?php 
    $artistSpotID = $_GET['artistSpotID'];
    $artistMBID = $_GET['artistMBID'];
    require_once 'page_pieces/stylesAndScripts.php';
    
    $artistArtMBFilePath = "https://www.roxorsoxor.com/poprock/artist-art/";

    $connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

    if ( !$connekt ) {
        echo 'Darn. Did not connect. Screwed up like this: ' . mysqli_connect_error() . '</p>';
    };

    $blackSabbath_MBID = '5182c1d9-c7d2-4dad-afa0-ccfeada921a8';

    $gatherOpeningTracks = "SELECT v.artistNameMB, v.trackNameMB, v.trackNumber, v.albumNameMB, v.albumArtMB, v.yearReleased, v.trackPlaycount, max(v.dataDate) AS MaxDataDate
    FROM (
        SELECT z.trackMBID, z.trackNameMB, z.trackNumber, z.albumNameMB, z.yearReleased, z.artistNameMB, z.albumArtMB, p.dataDate, p.trackPlaycount
            FROM (
                SELECT t.*, r.albumNameMB, r.albumArtMB, a.artistNameMB, r.yearReleased
                    FROM tracksMB t
                    INNER JOIN albumsMB r ON r.albumMBID = t.albumMBID
                    JOIN artistsMB a ON r.artistMBID = a.artistMBID
                    WHERE a.artistMBID = '$artistMBID' AND t.trackNumber = '1'
            ) z
        JOIN tracksLastFM p 
            ON z.trackMBID = p.trackMBID					
    ) v
    GROUP BY v.trackMBID
    ORDER BY v.yearReleased ASC";


    $getit = $connekt->query( $gatherOpeningTracks );

    if ( !$getit ) {
        echo '<p>Cursed-Crap. Did not run the query. Screwed up like this: ' . mysqli_error($connekt) . '</p>';
    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Opening Tracks | PopRock</title>
	<?php echo $stylesAndSuch; ?>
	<style type="text/css">

	</style>
</head>

<body>

<div class="container-fluid">
<div id="fluidCon">
</div> <!-- end of fluidCon -->

	
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
	
	
<script type="text/javascript">
    d3.json("functions/createAlbumsD3.php?artistSpotID=<?php echo $artistSpotID ?>", function(dataset) {
        console.log(dataset);
        // Width and height
        var w = 2400;
        var h = 265;
        var barPadding = 1;

        const artistNameSpot = dataset[0].artistNameSpot;

        const artistTitle = d3.select("#albumPop")
            .text(artistNameSpot + "'s albums' current popularity on Spotify");
        
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
                return d.albumNameSpot;
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