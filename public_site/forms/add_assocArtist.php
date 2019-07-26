<?php
$artistMBID = $_GET['artistMBID'];
$artistSpotID = $_GET['artistSpotID'];

$artistArtMBFilePath = "https://www.roxorsoxor.com/poprock/artist-art/";

require_once '../rockdb.php';
require_once '../page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect. Screwed up like this: ' . mysqli_connect_error() . '</p>';
};

// check if form is being submitted.
if (isset($_POST['submit'])){
	// If form is being submitted, process the form
	
    // THESE VARIABLES TAKE INFO FROM THE FORM FIELDS AND PUT IN DB TABLES
    $primaryArtistArtSpot = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['primaryArtistArtSpot']));
    $primaryArtistArtMBFilename = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['primaryArtistArtMBFilename']));
    $primaryArtistNameSpot = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['primaryArtistNameSpot']));
    $primaryArtistNameMB = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['primaryArtistNameMB']));
    $assocArtistName = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['assocArtistName']));
	$primaryArtistSpotID = $_POST['primaryArtistSpotID'];
    $primaryArtistMBID = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['primaryArtistMBID']));
	$assocArtistSpotID = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['assocArtistSpotID']));
    $assocArtistMBID = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['assocArtistMBID']));
	
	// UPDATE ARTISTS of SPOTIFY
    $updateArtistSpot = "UPDATE artistsSpot SET artistNameSpot='$primaryArtistNameSpot', artistMBID='$primaryArtistMBID' WHERE artistSpotID='$primaryArtistSpotID'";
    
    $retval = $connekt->query($updateArtistSpot);
    
    // Feedback of whether UPDATE worked or not
	if(!$retval){
		// if update did NOT work
		die('Crap. Could not update this artist because: ' . mysqli_error($connekt));
	}
	else
	{
		// if update worked, go back to artist page
		header("Location: https://www.roxorsoxor.com/poprock/artist_ChartsSpot.php?artistSpotID=" . $artistSpotID . "&artistMBID=" . $artistMBID);
    }
    
    // UPDATE ARTISTS of MusicBrainz
    $updateArtistMB = "UPDATE artistsMB SET artistNameMB='$primaryArtistNameMB', artistMBID='$primaryArtistMBID', artistArtMB='$primaryArtistArtMBFilename' WHERE artistMBID='$primaryArtistMBID'";

	$retval2 = $connekt->query($updateArtistMB);
    
    	// Feedback of whether UPDATE worked or not
	if(!$retval2){
		// if update did NOT work
		die('Crap. Could not update this artist because: ' . mysqli_error($connekt));
	}
	else
	{
		// if update worked, go back to artist page
		header("Location: https://www.roxorsoxor.com/poprock/artist_ChartsSpot.php?artistSpotID=" . $artistSpotID . "&artistMBID=" . $artistMBID);
    }
    
    // INSERT ASSOCIATED ARTIST into artistAssocArtists TABLE
    //if ($assocArtistSpotID != "" && $assocArtistMBID != ""){
         $insertArtistAssocArtists = "INSERT INTO artistAssocArtists SET assocArtistSpotID='$assocArtistSpotID', assocArtistMBID='$assocArtistMBID', primaryArtistSpotID='$primaryArtistSpotID', assocArtistName='$assocArtistName', primaryArtistName='$primaryArtistName', primaryArtistMBID='$primaryArtistMBID'";

        $retval3 = $connekt->query($insertArtistAssocArtists);	

            // Feedback of whether UPDATE worked or not
        if(!$retval3){
            // if update did NOT work
            die('Crap. Could not update this artist because: ' . mysqli_error($connekt));
        } else {
            // if update worked, go back to artist page
            header("Location: https://www.roxorsoxor.com/poprock/artist_ChartsSpot.php?artistSpotID=" . $artistSpotID . "&artistMBID=" . $artistMBID);
        };    
    //};

    
}
else // if the form isn't being submitted, get the data from the db and display the form
{
	// THESE VARIABLES POPULATE THE FORM FIELDS WITH EXISTING INFO
    
    // confirm id is valid and is numeric/larger than 0)
	if (isset($_GET['artistSpotID'])){
		// query db
		//$artistSpotID = $_GET['artistSpotID'];
		//$artistMBID = $_GET['artistMBID'];

		$queryZ = "
			SELECT z.artistNameSpot, z.artistMBID, z.artistSpotID, z.artistArtSpot, mb.artistArtMB, a.assocArtistSpotID, mb.artistNameMB
                FROM artistsSpot z 
                LEFT JOIN artistsMB mb ON z.artistMBID = mb.artistMBID
				LEFT JOIN artistAssocArtists a ON a.primaryArtistSpotID = z.artistSpotID
				WHERE z.artistSpotID='" . $artistSpotID . "';";
		
		$resultZ = mysqli_query($connekt, $queryZ) or die(mysqli_error($connekt));
		
		$row = mysqli_fetch_array($resultZ);
		
		// check that the 'artistMBID' matches up with a row in the database
		if($row){
            $primaryArtistArtSpot = $row['artistArtSpot'];
			$primaryArtistArtMBFilename = $row['artistArtMB'];
            $primaryArtistNameMB = $row['artistNameMB'];
            $primaryArtistNameSpot = $row['artistNameSpot'];
            $primaryArtistMBID = $row['artistMBID'];
			$primaryArtistSpotID = $row['artistSpotID'];

			if($primaryArtistArtMBFilename == "" || $primaryArtistArtMBFilename == null) {
                $prettyFace = $artistArtMBFilePath . "nope.png";
            } else {
                $prettyFace = $artistArtMBFilePath . $primaryArtistArtMBFilename;
            };				
		}
		else // if no match, display error
		{
			echo "No results!";
		}
	}
	else // if the 'artistMBID' in the URL isn't valid, or if there is no 'artistMBID' value, display an error
	{
		echo $error;
	}
} // end of what to do if form isn't being submitted
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="user-scalable=no, width=device-width" />
<meta charset="UTF-8">
<title>Edit <?php echo $primaryArtistNameSpot; ?></title>
<?php echo $stylesAndSuch; ?>
</head>
<body>
<div class="container-fluid">	
		
	<div id="fluidCon">
	</div> <!-- end of fluidCon -->
	
	<!-- main -->
	<div class="panel panel-primary">
		<div class="panel-heading"><h3 class="panel-title">Edit <?php echo $primaryArtistNameSpot; ?></h3></div>
			<div class="panel-body">
				<!-- Panel Content -->
	
	<!-- // SOME OF THESE FORM FIELDS RECEIVE VARIABLES FROM DB ... ALL OF THESE SEND INFO TO DB -->
	
	<form class="form-horizontal" action="" method="post">
		
		<fieldset>
		
        <!-- Artist Art from Spotify -->
		<div class="form-group">  
			<div class="col-lg-2 rightNum">
				<img src='<?php echo $primaryArtistArtSpot ?>' class="indexArtistArt" id="primaryArtistArtSpot">
			</div>
			<div class="col-lg-4 align-top">
				<label class="control-label" for="primaryArtistArtSpot">Artist Art Spotify</label>
				<input class="form-control" type="text" name="primaryArtistArtSpot" value="<?php echo $primaryArtistArtSpot; ?>" readonly/>
			</div>
		</div> 
        <!-- /Artist Art from Spotify -->  

		<div class="form-group"> <!-- Row ArtMB --> 	
			<div class="col-lg-2 rightNum">
				<img src='<?php echo $prettyFace ?>' class="indexArtistArt" id="primaryArtistArtMB">
			</div>		
			<div class="col-lg-4 align-top">
				<label class="control-label" for="primaryArtistArtMBFilename">Artist Art MB</label>
				<input class="form-control" type="text" name="primaryArtistArtMBFilename" value="<?php echo $primaryArtistArtMBFilename; ?>" />
			</div>
		</div> <!-- /Row ArtMB -->				   

		<div class="form-group"> <!-- Primary Artist Spotify Name --> 			
			<label class="col-lg-2 control-label" for="primaryArtistNameSpot">Primary Artist Name Spotify</label>			
			<div class="col-lg-4">
				<input class="form-control" type="text" name="primaryArtistNameSpot" value="<?php echo $primaryArtistNameSpot; ?>" />
			</div>
		</div> <!-- /Primary Artist Spotify Name -->
            
		<div class="form-group"> <!-- Primary Artist MB Name --> 			
			<label class="col-lg-2 control-label" for="primaryArtistNameMB">Primary Artist Name MB</label>			
			<div class="col-lg-4">
				<input class="form-control" type="text" name="primaryArtistNameMB" value="<?php echo $primaryArtistNameMB; ?>" />
			</div>
		</div> <!-- /Primary Artist MB Name -->	
            
			
		<div class="form-group"> <!-- Primary Artist Spotify ID --> 
			<!-- Column 1 -->
			<label class="col-lg-2 control-label" for="primaryArtistSpotID">Primary Artist Spotify ID</label>
			<!-- Column 2 -->
			<div class="col-lg-4">
				<input class="form-control" type="primaryArtistSpotID" name="primaryArtistSpotID"  value="<?php echo $primaryArtistSpotID; ?>" readonly/>
			</div>
		</div> <!-- /Primary Artist Spotify ID --> 	

		<div class="form-group"> <!-- Primary Artist MBID --> 
			<!-- Column 1 -->
			<label class="col-lg-2 control-label" for="primaryArtistMBID">Primary Artist MBID</label>
			<!-- Column 2 -->
			<div class="col-lg-4">
				<input class="form-control" type="text" name="primaryArtistMBID" value="<?php echo $primaryArtistMBID; ?>" />
			</div>
		</div> <!-- /Primary Artist MBID -->	

						
		<div class="form-group"> <!-- Assoc Artist Name --> 			
			<label class="col-lg-2 control-label" for="assocArtistName">Assoc Artist Name</label>			
			<div class="col-lg-4">
				<input class="form-control" type="text" name="assocArtistName"/>
			</div>
		</div> <!-- /Primary Artist MB Name -->	
            
		<div class="form-group"> <!-- Add Associated Artist SpotID --> 
			<!-- Column 1 -->
			<label class="col-lg-2 control-label" for="assocArtistSpotID">Assoc Artist Spotify ID</label>
			<!-- Column 2 -->
			<div class="col-lg-3">
				<input class="form-control" type="assocArtistSpotID" name="assocArtistSpotID" />
			</div> 
			<!-- Column 3 -->
			<div class="col-lg-3">
				<input class="form-control" type="assocArtistNameSpot" name="assocArtistNameSpot"  value="Name coming soon via AJAX" readonly/>
			</div>
			
		</div> <!-- end of Add Associated Artist SpotID -->

		<div class="form-group"> <!-- Add Associated Artist MBID --> 
			<!-- Column 1 -->
			<label class="col-lg-2 control-label" for="assocArtistMBID">Assoc Artist MBID</label>
			<!-- Column 2 -->
			<div class="col-lg-3">
				<input class="form-control" type="assocArtistMBID" name="assocArtistMBID" />
			</div>
			<!-- Column 3 -->
			<div class="col-lg-3">
				<input class="form-control" type="assocArtistNameMB" name="assocArtistNameMB"  value="Name coming soon via AJAX" readonly/>
			</div>            

		</div> <!-- Add Associated Artist SpotID -->			
					
			<!-- Last Row -->
			<div class="form-group"> <!-- Last Row -->	
				<div class="col-lg-4 col-lg-offset-2">
					<button class="btn btn-primary" type="submit" name="submit">Update</button>
				</div>
			</div>
			<!-- /Last Row -->
		</fieldset>
	</form>

	</div> <!-- /panel-body -->
</div> <!-- /panel IS THIS PRIMARY? -->

<div class="well">	
	
	<?php
	echo "Artists associated with " . $primaryArtistNameSpot;
	// Start creating an HTML table for Assigned Cases and create header row
	echo "<table class='table table-striped table-hover '><thead><tr>
	<th>Spotify Face</th>
	<th>Spotify Name</th>
	<th>MB Face</th>
	<th>MB Name</th>
	</tr></thead>";
	echo "<tbody>";

	$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );
	// Connection test and feedback
	if (!$connekt) {
		echo 'Darn. Did not connect. Screwed up like this: ' . mysqli_error($connekt) . '</p>';
	}

	$getAssocArtists = "SELECT r.assocArtistName, r.assocArtistSpotID, r.assocArtistMBID, a.assocArtistArtSpot, m.assocArtistArtMB
						FROM artistAssocArtists r
						LEFT JOIN artistsSpot a ON r.assocArtistSpotID = a.artistSpotID
						LEFT JOIN artistsMB m ON m.artistMBID = '$artistMBID'
						WHERE r.primaryArtistSpotID = '$artistSpotID';";

	$result0 = mysqli_query($connekt, $getAssocArtists);

	
	/**/
	if(!$result0){
		echo 'Cursed-Crap. Did not run the query.';
	}

	//if (mysqli_num_rows($result0) > 0) {
		
		while ($row = mysqli_fetch_array($result0)) {
			echo "<tr>
					<td><img src='" . $row['assocArtistArtSpot'] . "' height='64' width='64'></td>
					<td>" . $row['assocArtistNameSpot'] . "</td>
					<td><img src='" . $row['assocArtistArtMB'] . "' height='64' width='64'></td>
					<td>" . $row['assocArtistNameMB'] . "</td>								
				</tr>";
		}
		//echo json_encode($rows);
/*		
	} else {
		echo "Nope. Nothing to see here. Screwed up like this: " . mysqli_error($result0) . "</p>";
	}
*/
    echo "</tbody></table>";
	// When attempt is complete, connection closes
    mysqli_close($connekt);
?>

</div> <!-- /well -->	

	</div> <!-- /container-fluid --> 
<script>
	const artistSpotID = '<?php echo $primaryArtistSpotID; ?>';
	const artistMBID = '<?php echo $primaryArtistMBID ?>';
</script>
<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbar.js"></script>
</body>
</html>