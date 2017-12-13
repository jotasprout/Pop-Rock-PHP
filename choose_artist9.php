<?php
    session_start();
    
    require 'artists.php';
    require 'vendor/autoload.php';
    require_once 'stylesAndScripts.php';

    // Fetch saved access token
    $accessToken = $_SESSION['accessToken'];
    
    $GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
    $GLOBALS['api']->setAccessToken($accessToken);
    
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Choose an Artist</title>
    <?php echo $stylesAndSuch; ?>
</head>

<body>
	<div class="container">
    
    <form class="form-horizontal" id="rockinForm" action="handle_albums8.php" method="post">
        <fieldset>
            <legend>Ye Olde Select An Artist Menu</legend>

            <div class="form-group"> <!-- Row 1 -->
<!--                        
            <label class="col-lg-2 control-label" for="artist">Ye Olde Select An Artist Menu</label>
-->
                <div class="col-lg-4">
                    <select class="form-control" id="artist" name="artist">
                        <option value="">- Choose -</option>

<?php
echo "<option value='" . $aliceCooper->get_artistID() . "'>" . $aliceCooper->get_artistName() . "</option>";
echo "<option value='" . $hollywoodVampires->get_artistID() . "'>" . $hollywoodVampires->get_artistName() . "</option>";
echo "<option value='" . $davidBowie->get_artistID() . "'>" . $davidBowie->get_artistName() . "</option>";
echo "<option value='" . $bobDylan->get_artistID() . "'>" . $bobDylan->get_artistName() . "</option>";
echo "<option value='" . $meatLoaf->get_artistID() . "'>" . $meatLoaf->get_artistName() . "</option>";
echo "<option value='" . $johnMellencamp->get_artistID() . "'>" . $johnMellencamp->get_artistName() . "</option>";
echo "<option value='" . $stooges->get_artistID() . "'>" . $stooges->get_artistName() . "</option>";
echo "<option value='" . $bruceSpringsteen->get_artistID() . "'>" . $bruceSpringsteen->get_artistName() . "</option>";
echo "<option value='" . $kiss->get_artistID() . "'>" . $kiss->get_artistName() . "</option>";
echo "<option value='" . $iggyPop->get_artistID() . "'>" . $iggyPop->get_artistName() . "</option>";
echo "<option value='" . $popWilliamson->get_artistID() . "'>" . $popWilliamson->get_artistName() . "</option>";
echo "<option value='" . $rollingStones->get_artistID() . "'>" . $rollingStones->get_artistName() . "</option>";
echo "<option value='" . $tomPetty->get_artistID() . "'>" . $tomPetty->get_artistName() . "</option>";
echo "<option value='" . $tpHeartbreakers->get_artistID() . "'>" . $tpHeartbreakers->get_artistName() . "</option>";
echo "<option value='" . $travelingWilburys->get_artistID() . "'>" . $travelingWilburys->get_artistName() . "</option>";
echo "<option value='" . $bobSeger->get_artistID() . "'>" . $bobSeger->get_artistName() . "</option>";
echo "<option value='" . $johnnyCash->get_artistID() . "'>" . $johnnyCash->get_artistName() . "</option>";
echo "<option value='" . $zzTop->get_artistID() . "'>" . $zzTop->get_artistName() . "</option>";
echo "<option value='" . $u2->get_artistID() . "'>" . $u2->get_artistName() . "</option>";
echo "<option value='" . $blackSabbath->get_artistID() . "'>" . $blackSabbath->get_artistName() . "</option>";
echo "<option value='" . $ironMaiden->get_artistID() . "'>" . $ironMaiden->get_artistName() . "</option>";
echo "<option value='" . $HeavenHell->get_artistID() . "'>" . $HeavenHell->get_artistName() . "</option>";
echo "<option value='" . $ozzyOsbourne->get_artistID() . "'>" . $ozzyOsbourne->get_artistName() . "</option>";
echo "<option value='" . $dio->get_artistID() . "'>" . $dio->get_artistName() . "</option>";
echo "<option value='" . $ronnieJamesDio->get_artistID() . "'>" . $ronnieJamesDio->get_artistName() . "</option>";
echo "<option value='" . $jethroTull->get_artistID() . "'>" . $jethroTull->get_artistName() . "</option>";
echo "<option value='" . $garyNuman->get_artistID() . "'>" . $garyNuman->get_artistName() . "</option>";
echo "<option value='" . $prince->get_artistID() . "'>" . $prince->get_artistName() . "</option>";
echo "<option value='" . $acdc->get_artistID() . "'>" . $acdc->get_artistName() . "</option>";
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
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
</div> <!-- /container -->


<?php echo $scriptsAndSuch; ?>
</body>

</html>