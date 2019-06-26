<?php
$artistMBID = $_GET['artistMBID'];
$artistSpotID = $_GET['artistSpotID'];

require_once '../rockdb.php';
require_once '../page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect. Screwed up like this: ' . mysqli_connect_error() . '</p>';
};

// check if form is being submitted.
if (isset($_POST['submit'])){
	// If form is being submitted, process the form
	// First, get form data and make sure it is valid
	$artistSpotID = $_POST['artistSpotID'];
    $artistName = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['artistName']));
    $artistArt = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['artistArt']));
	$artistMBID = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['artistMBID']));
	$assocArtistSpotID = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['assocArtistSpotID']));
	$artistArtFilename = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['artistArtMB']));
	$artistArtMB = "https://www.roxorsoxor.com/poprock/artist-art/" . $artistArtFilename;
	
	// save data to database
	$updateArtistSpot = "UPDATE artists SET artistName='$artistName', artistMBID='$artistMBID' WHERE artistSpotID='$artistSpotID'";
    $retval = $connekt->query($updateArtistSpot);
    
    $updateArtistMB = "UPDATE artistsMB SET artistName='$artistName', artistMBID='$artistMBID', artistArtMB='$artistArtMB' WHERE artistMBID='$artistMBID'";
	$retval2 = $connekt->query($updateArtistMB);
	
    $updateArtistAssocArtists = "INSERT INTO artistAssocArtists SET assocArtistName='$artistName', assocArtistSpotID='$assocArtistSpotID', assocArtistMBID='$artistMBID', primaryArtistName='$artistName', primaryArtistSpotID='$artistSpotID', primaryArtistMBID='$artistMBID'";
	$retval3a = $connekt->query($updateAssocArtists);	

    $updateArtistAssocArtists2 = "INSERT INTO artistAssocArtists SET assocArtistName='$artistName', assocArtistSpotID='$assocArtistSpotID', assocArtistMBID='$artistMBID', primaryArtistName='$artistName', primaryArtistSpotID='$artistSpotID', primaryArtistMBID='$artistMBID'";
	$retval3b = $connekt->query($updateAssocArtists2);	
	/**/
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
}
else // if the form isn't being submitted, get the data from the db and display the form
{
	// confirm id is valid and is numeric/larger than 0)
	if (isset($_GET['artistSpotID'])){
		// query db
		$artistSpotID = $_GET['artistSpotID'];
		$artistMBID = $_GET['artistMBID'];
		
		$queryJ = "
		SELECT z.artistName, z.artistMBID, z.artistSpotID, z.artistArt, mb.artistArtMB
			FROM artists z 
			JOIN artistsMB mb ON z.artistMBID = mb.artistMBID
			WHERE z.artistSpotID='" . $artistSpotID . "';";

		$queryZ = "
			SELECT z.artistName, z.artistMBID, z.artistSpotID, z.artistArt, mb.artistArtMB, a.assocArtistSpotID
                FROM artists z 
                LEFT JOIN artistsMB mb ON z.artistMBID = mb.artistMBID
				LEFT JOIN artistAssocArtists a ON a.primaryArtistSpotID = z.artistSpotID
				WHERE z.artistSpotID='" . $artistSpotID . "';";
		
		$resultZ = mysqli_query($connekt, $queryZ) 
			or die(mysqli_error($connekt));
		
		$row = mysqli_fetch_array($resultZ);
		
		// check that the 'artistMBID' matches up with a row in the databse
		if($row){
			$artistName = $row['artistName'];
            $artistMBID = $row['artistMBID'];
            $artistArtMB = $row['artistArtMB'];
            $artistArt = $row['artistArt'];
			$artistSpotID = $row['artistSpotID'];
			$assocArtistSpotID = $row['assocArtistSpotID'];
			if($row["artistArtMB"] == "") {
				$artistArtMB = "nope.png";
			}
			else {
				$artistArtMB = $row["artistArtMB"];
			}				
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
<title>Edit <?php echo $artistName; ?></title>
<?php echo $stylesAndSuch; ?>
</head>
<body>
<div class="container-fluid">	
		
	<div id="fluidCon">
	</div> <!-- end of fluidCon -->
	
	<!-- main -->
	<div class="panel panel-primary">
		<div class="panel-heading"><h3 class="panel-title">Edit <?php echo $artistName; ?></h3></div>
			<div class="panel-body">
				<!-- Panel Content -->
	
	<!-- This form displays user profile info from the database -->
	
	<form class="form-horizontal" action="" method="post">
		
		<fieldset>

		<div class="form-group"> <!-- Row ArtSpot --> 
			<div><img src='<?php echo $artistArtSpot ?>'></div>
			<label class="col-lg-2 control-label" for="artistArtSpot">Artist Art Spotify</label>
			<div class="col-lg-4">
				<input class="form-control" type="text" name="artistArtSpot" value="<?php echo $artistArtSpot; ?>" readonly/>
			</div>
		</div>
			<!-- /Row ArtSpot -->  

		<div class="form-group"> <!-- Row ArtMB --> 	
			<div><img src='<?php echo $artistArtMB ?>'></div>		
			<label class="col-lg-2 control-label" for="artistArtMB">Artist Art MB</label>			
			<div class="col-lg-4">
				<input class="form-control" type="text" name="artistArtMB" value="<?php echo $artistArtMB; ?>" />
			</div>
		</div>
		<!-- /Row ArtMB -->				   

		<div class="form-group"> <!-- Primary Artist Spotify Name --> 			
			<label class="col-lg-2 control-label" for="primaryArtistName">Primary Artist Spotify Name</label>			
			<div class="col-lg-4">
				<input class="form-control" type="text" name="primaryArtistName" value="<?php echo $artistNameSpot; ?>" />
			</div>
		</div>
		<!-- /Primary Artist Spotify Name -->
			
		<div class="form-group"> <!-- Primary Artist Spotify ID --> 
			<!-- Column 1 -->
			<label class="col-lg-2 control-label" for="artistSpotID">Primary Artist Spotify ID</label>
			<!-- Column 2 -->
			<div class="col-lg-4">
				<input class="form-control" type="artistSpotID" name="artistSpotID"  value="<?php echo $artistSpotID; ?>" readonly/>
			</div>
		</div>
		<!-- /Primary Artist Spotify ID --> 	

		<div class="form-group"> <!-- Primary Artist MBID --> 
			<!-- Column 1 -->
			<label class="col-lg-2 control-label" for="artistMBID">Primary Artist MBID</label>
			<!-- Column 2 -->
			<div class="col-lg-4">
				<input class="form-control" type="text" name="artistMBID" value="<?php echo $artistMBID; ?>" />
			</div>
		</div>
		<!-- /Primary Artist MBID -->	

		<div class="form-group"> <!-- Primary Artist MB Name --> 			
			<label class="col-lg-2 control-label" for="primaryArtistNameMB">Primary Artist MB Name</label>			
			<div class="col-lg-4">
				<input class="form-control" type="text" name="primaryArtistNameMB" value="<?php echo $artistNameMB; ?>" />
			</div>
		</div>
		<!-- /Primary Artist MB Name -->							
			
		<div class="form-group"> <!-- Add Associated Artist SpotID --> 
			<!-- Column 1 -->
			<label class="col-lg-2 control-label" for="assocArtistSpotID">Add Associated Artist SpotID</label>
			<!-- Column 2 -->
			<div class="col-lg-3">
				<input class="form-control" type="assocArtistSpotID" name="assocArtistSpotID"  value="<?php echo $assocArtistSpotID; ?>" />
			</div>
			<!-- Column 3 
			<div class="col-lg-3">
				<input class="form-control" type="assocArtistNameSpot" name="assocArtistNameSpot"  value="<?php //echo $assocArtistNameSpot; ?>" readonly/>
			</div>
			-->
		</div> <!-- /Add Associated Artist SpotID -->

		<div class="form-group"> <!-- Add Associated Artist MBID --> 
			<!-- Column 1 -->
			<label class="col-lg-2 control-label" for="assocArtistMBID">Add Associated Artist MBID</label>
			<!-- Column 2 -->
			<div class="col-lg-3">
				<input class="form-control" type="assocArtistMBID" name="assocArtistMBID"  value="<?php echo $assocArtistMBID; ?>" />
			</div>
			<!-- Column 3 
			<div class="col-lg-3">
				<input class="form-control" type="assocArtistNameMB" name="assocArtistNameMB"  value="<?php //echo $assocArtistNameMB; ?>" readonly/>
			</div>
			-->
		</div> <!-- /Add Associated Artist SpotID -->			
					
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
	echo "Artists associated with " . $artistNameSpot;
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

	$getAssocArtists = "SELECT r.assocArtistNameSpot, r.assocArtistNameMB, r.assocArtistSpotID, r.assocArtistMBID, a.assocArtistArtSpot, m.assocArtistArtMB
						FROM artistAssocArtists r
						LEFT JOIN artists a ON r.assocArtistSpotID = a.artistSpotID
						LEFT JOIN artistsMB m ON m.artistMBID = '$artistMBID'
						WHERE r.primaryArtistSpotID = '$artistSpotID';";

	$result0 = mysqli_query($connekt, $getAssocArtists);

	/**/
	if(!$result0){
		echo 'Cursed-Crap. Did not run the query.';
	}

	if (mysqli_num_rows($result0) > 0) {
		/**/
		while ($row = mysqli_fetch_array($result0)) {
			echo "<tr>
					<td><img src='" . $row['artistArtSpot'] . "' height='64' width='64'></td>
					<td>" . $row['artistNameSpot'] . "</td>
					<td><img src='" . $row['artistArtMB'] . "' height='64' width='64'></td>
					<td>" . $row['artistNameMB'] . "</td>								
				</tr>";
		}
		echo json_encode($rows);
		
	} else {
		echo "Nope. Nothing to see here. Screwed up like this: " . mysqli_error($result0) . "</p>";
	}

    echo "</tbody></table>";
	// When attempt is complete, connection closes
    mysqli_close($connekt);
?>

</div> <!-- /well -->	

	</div> <!-- /container-fluid --> 
<script>
	const artistSpotID = '<?php echo $artistSpotID; ?>';
	const artistMBID = '<?php echo $artistMBID ?>';
</script>
<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbar.js"></script>
</body>
</html>