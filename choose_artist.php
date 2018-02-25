<?php
    session_start();
    require_once 'auth.php';
        // Fetch saved access token
        $accessToken = $_SESSION['accessToken'];


    // site pages only get from my DB so they don't need auth
    require_once 'rockdb.php';
    require 'artists.php';
    require 'vendor/autoload.php';
    require_once 'stylesAndScripts.php';
    require_once 'navbar_rock.php';


    
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
    
    <form class="form-horizontal" id="rockinForm" action="handle_albums.php" method="post">
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
echo "<option value='" . $BonJovi->get_artistID() . "'>" . $BonJovi->get_artistName() . "</option>";
echo "<option value='" . $KateBush->get_artistID() . "'>" . $KateBush->get_artistName() . "</option>";
echo "<option value='" . $Cars->get_artistID() . "'>" . $Cars->get_artistName() . "</option>";
echo "<option value='" . $DepecheMode->get_artistID() . "'>" . $DepecheMode->get_artistName() . "</option>";
echo "<option value='" . $DireStraits->get_artistID() . "'>" . $DireStraits->get_artistName() . "</option>";
echo "<option value='" . $Eurythmics->get_artistID() . "'>" . $Eurythmics->get_artistName() . "</option>";
echo "<option value='" . $JGeilsBand->get_artistID() . "'>" . $JGeilsBand->get_artistName() . "</option>";
echo "<option value='" . $JudasPriest->get_artistID() . "'>" . $JudasPriest->get_artistName() . "</option>";
echo "<option value='" . $LLCoolJ->get_artistID() . "'>" . $LLCoolJ->get_artistName() . "</option>";
echo "<option value='" . $MC5->get_artistID() . "'>" . $MC5->get_artistName() . "</option>";
echo "<option value='" . $TheMeters->get_artistID() . "'>" . $TheMeters->get_artistName() . "</option>";
echo "<option value='" . $MoodyBlues->get_artistID() . "'>" . $MoodyBlues->get_artistName() . "</option>";
echo "<option value='" . $Radiohead->get_artistID() . "'>" . $Radiohead->get_artistName() . "</option>";
echo "<option value='" . $RageAgainstTheMachine->get_artistID() . "'>" . $RageAgainstTheMachine->get_artistName() . "</option>";
echo "<option value='" . $RufusFeatChakaKhan->get_artistID() . "'>" . $RufusFeatChakaKhan->get_artistName() . "</option>";
echo "<option value='" . $NinaSimone->get_artistID() . "'>" . $NinaSimone->get_artistName() . "</option>";
echo "<option value='" . $SisterRosettaTharpe->get_artistID() . "'>" . $SisterRosettaTharpe->get_artistName() . "</option>";
echo "<option value='" . $LinkWray->get_artistID() . "'>" . $LinkWray->get_artistName() . "</option>";
echo "<option value='" . $Zombies->get_artistID() . "'>" . $Zombies->get_artistName() . "</option>";
echo "<option value='" . $ChakaKhan->get_artistID() . "'>" . $ChakaKhan->get_artistName() . "</option>";
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
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
</div> <!-- /container -->


<?php echo $scriptsAndSuch; ?>
</body>

</html>