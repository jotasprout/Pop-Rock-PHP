<?php
    session_start();
    
    require 'artists.php';
    require 'vendor/autoload.php';
    require_once 'stylesAndScripts.php';

    // Fetch saved access token
    $accessToken = $_SESSION['accessToken'];
    
    // Do I need the next two lines?
    $GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
    $GLOBALS['api']->setAccessToken($accessToken);
    // What happened to my globals? Where are they? Is this where they're set?
    
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Choose a Christian Artist</title>
    <?php echo $stylesAndSuch; ?>
</head>

<body>
	<div class="container">
    
    <form class="form-horizontal" id="rockinForm" action="show_albums.php" method="post">
        <fieldset>
            <legend>Select a Christian Artist</legend>

            <div class="form-group"> <!-- Row 1 -->
                <div class="col-lg-4">
                    <select class="form-control" id="artist" name="artist">
                        <option value="">- Choose -</option>

<?php
// I really need to make an artist array ... the following is just stupid
echo "<option value='" . $oneBadPig->get_artistID() . "'>" . $oneBadPig->get_artistName() . "</option>";
echo "<option value='" . $stryper->get_artistID() . "'>" . $stryper->get_artistName() . "</option>";
echo "<option value='" . $bloodgood->get_artistID() . "'>" . $bloodgood->get_artistName() . "</option>";
echo "<option value='" . $bride->get_artistID() . "'>" . $bride->get_artistName() . "</option>";
echo "<option value='" . $steveTaylor->get_artistID() . "'>" . $steveTaylor->get_artistName() . "</option>";
echo "<option value='" . $stPerfectFoil->get_artistID() . "'>" . $stPerfectFoil->get_artistName() . "</option>";
echo "<option value='" . $stDanielsonFoil->get_artistID() . "'>" . $stDanielsonFoil->get_artistName() . "</option>";
echo "<option value='" . $chagallGuevara->get_artistID() . "'>" . $chagallGuevara->get_artistName() . "</option>";
echo "<option value='" . $vengeanceRising->get_artistID() . "'>" . $vengeanceRising->get_artistName() . "</option>";
echo "<option value='" . $freedomSoul->get_artistID() . "'>" . $freedomSoul->get_artistName() . "</option>";
echo "<option value='" . $pid->get_artistID() . "'>" . $pid->get_artistName() . "</option>";
echo "<option value='" . $sfc->get_artistID() . "'>" . $sfc->get_artistName() . "</option>";
echo "<option value='" . $dcTalk->get_artistID() . "'>" . $dcTalk->get_artistName() . "</option>";
echo "<option value='" . $dynamicTwins->get_artistID() . "'>" . $dynamicTwins->get_artistName() . "</option>";
echo "<option value='" . $eRoc->get_artistID() . "'>" . $eRoc->get_artistName() . "</option>";
echo "<option value='" . $resurrectionBand->get_artistID() . "'>" . $resurrectionBand->get_artistName() . "</option>";
echo "<option value='" . $xlDBD->get_artistID() . "'>" . $xlDBD->get_artistName() . "</option>";
echo "<option value='" . $crucified->get_artistID() . "'>" . $crucified->get_artistName() . "</option>";
echo "<option value='" . $playdough->get_artistID() . "'>" . $playdough->get_artistName() . "</option>";

echo "<option value='" . $saint->get_artistID() . "'>" . $saint->get_artistName() . "</option>";
echo "<option value='" . $twelthTribe->get_artistID() . "'>" . $twelthTribe->get_artistName() . "</option>";
echo "<option value='" . $seventySevens->get_artistID() . "'>" . $seventySevens->get_artistName() . "</option>";
echo "<option value='" . $mortification->get_artistID() . "'>" . $mortification->get_artistName() . "</option>";
echo "<option value='" . $klank->get_artistID() . "'>" . $klank->get_artistName() . "</option>";
echo "<option value='" . $livingSacrifice->get_artistID() . "'>" . $livingSacrifice->get_artistName() . "</option>";
echo "<option value='" . $sayWhat->get_artistID() . "'>" . $sayWhat->get_artistName() . "</option>";
echo "<option value='" . $barrenCross->get_artistID() . "'>" . $barrenCross->get_artistName() . "</option>";
echo "<option value='" . $jerusalem->get_artistID() . "'>" . $jerusalem->get_artistName() . "</option>";
echo "<option value='" . $lustControl->get_artistID() . "'>" . $lustControl->get_artistName() . "</option>";
echo "<option value='" . $argylePark->get_artistID() . "'>" . $argylePark->get_artistName() . "</option>";
echo "<option value='" . $deliverance->get_artistID() . "'>" . $deliverance->get_artistName() . "</option>";
echo "<option value='" . $tourniquet->get_artistID() . "'>" . $tourniquet->get_artistName() . "</option>";
echo "<option value='" . $mortal->get_artistID() . "'>" . $mortal->get_artistName() . "</option>";
echo "<option value='" . $circleDust->get_artistID() . "'>" . $circleDust->get_artistName() . "</option>";
echo "<option value='" . $deitiphobia->get_artistID() . "'>" . $deitiphobia->get_artistName() . "</option>";
echo "<option value='" . $rosarium->get_artistID() . "'>" . $rosarium->get_artistName() . "</option>";
echo "<option value='" . $mxpx->get_artistID() . "'>" . $mxpx->get_artistName() . "</option>";
echo "<option value='" . $whitecross->get_artistID() . "'>" . $whitecross->get_artistName() . "</option>";
echo "<option value='" . $ninetyPoundWuss->get_artistID() . "'>" . $ninetyPoundWuss->get_artistName() . "</option>";
echo "<option value='" . $ghotiHook->get_artistID() . "'>" . $ghotiHook->get_artistName() . "</option>";
echo "<option value='" . $fiveIronFrenzy->get_artistID() . "'>" . $fiveIronFrenzy->get_artistName() . "</option>";
echo "<option value='" . $larryNorman->get_artistID() . "'>" . $larryNorman->get_artistName() . "</option>";
echo "<option value='" . $scaterdFew->get_artistID() . "'>" . $scaterdFew->get_artistName() . "</option>";
?>

                    </select>
                </div>
            </div><!-- /Row 1 -->

            <div class="form-group"> <!-- Row 2 -->
                <div class="col-lg-4 col-lg-offset-2">
                    <button class="btn btn-primary" type="submit" name="submit">Get Artist Shizzle</button>
                </div>
            </div><!-- /Row 2 -->
        </fieldset>
    </form>

</div> <!-- /container -->

<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
<?php echo $scriptsAndSuch; ?>
</body>

</html>