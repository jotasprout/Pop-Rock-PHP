<?php
$artistMBID = $_GET['artistMBID'];
$artistSpotID = $_GET['artistSpotID'];

require_once '../rockdb.php';
require_once '../page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect. Screwed up like this: ' . mysqli_connect_error() . '</p>';
};

// check if the form has been submitted.
if (isset($_POST['submit'])){
	// If form is being submitted, process the form
	// get form data, making sure it is valid
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
	
    $updateAssocArtists = "INSERT INTO artistAssocArtists SET PrimaryArtistName='$artistName', primaryArtistMBID='$artistMBID', primaryArtistSpotID='$artistSpotID', assocArtistSpotID='$assocArtistSpotID'";
	
	$retval3 = $connekt->query($updateAssocArtists);	
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
		<input type="hidden" name="artistMBID" value="<?php echo $artistMBID; ?>"/>
		<fieldset>
                     	
			<div class="form-group"> <!-- Row 2 --> 
				<!-- Column 1 -->				
				<label class="col-lg-2 control-label" for="artistName">Artist Name</label>
				<!-- Column 2 -->				
				<div class="col-lg-4">
					<input class="form-control" type="text" name="artistName" value="<?php echo $artistName; ?>" readonly/>
				</div>
			</div>
			<!-- /Row 2 -->

			<div class="form-group"> <!-- Row Art --> 
				<!-- Column 1 -->				
				<label class="col-lg-2 control-label" for="artistArtMB">Artist Art MB</label>
				<!-- Column 2 -->				
				<div class="col-lg-4">
					<input class="form-control" type="text" name="artistArtMB" value="<?php echo $artistArtMB; ?>" />
				</div>
			</div>
			<!-- /Row Art -->

			<div class="form-group"> <!-- Row Art --> 
				<!-- Column 1 -->				
				<label class="col-lg-2 control-label" for="artistArt">Artist Art Spotify</label>
				<!-- Column 2 -->				
				<div class="col-lg-4">
					<input class="form-control" type="text" name="artistArt" value="<?php echo $artistArt; ?>" readonly/>
				</div>
			</div>
			<!-- /Row Art -->            
			
			<div class="form-group"> <!-- Row 3 --> 
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="artistMBID">artistMBID</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="text" name="artistMBID" value="<?php echo $artistMBID; ?>" />
				</div>
			</div>
			<!-- /Row 3 -->
			
			<div class="form-group"> <!-- Row 4 --> 
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="artistSpotID">artistSpotID</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="artistSpotID" name="artistSpotID"  value="<?php echo $artistSpotID; ?>" readonly/>
				</div>
			</div>
			<!-- /Row 4 --> 					
			
			<div class="form-group"> <!-- Row 4 --> 
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="assocArtistSpotID">Associated Artist SpotID</label>
				<!-- Column 2 -->
				<div class="col-lg-3">
					<input class="form-control" type="assocArtistSpotID" name="assocArtistSpotID"  value="<?php echo $assocArtistSpotID; ?>" />
				</div>
				<!-- Column 3 
				<div class="col-lg-3">
					<input class="form-control" type="assocArtistName" name="assocArtistName"  value="<?php //echo $assocArtistName; ?>" readonly/>
				</div>
				-->
			</div>
					
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
</div> <!-- /panel -->
	

	</div> <!-- /container-fluid --> 
<script>
	const artistSpotID = '<?php echo $artistSpotID; ?>';
	const artistMBID = '<?php echo $artistMBID ?>';
</script>
<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbar.js"></script>
</body>
</html>