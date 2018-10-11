<?php
    require 'functions/artists.php';
    require 'data_text/artists_arrays_objects.php';
    require_once 'page_pieces/stylesAndScripts.php';
    require_once 'page_pieces/navbar_rock.php';  

    // delete any old cookie
    $cookieSelfDestruct = time() - 3600;
    //setcookie ('artistID', '', $cookieSelfDestruct, '/', 'roxorsoxor.com');
    setcookie ('artistID', false, $cookieSelfDestruct, '/', 'roxorsoxor.com');
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
    <!--
 <form class="form-horizontal" id="rockinForm" action="handle_tracks.php" method="post"> 
-->

<form class="form-horizontal" id="rockinForm" action="this_artistPopList.php" method="post">
        <fieldset>
            <legend>Ye Olde Select An Artist Menu</legend>

            <div class="form-group"> <!-- Row 1 -->

                <div class="col-lg-4">
                    <select class="form-control" id="artist" name="artist">
                        <option value="">- Choose -</option>

                        <?php
                        include 'page_pieces/artist_menu.php';
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
<footer class="footer"></footer>
</div> <!-- /container -->


<?php echo $scriptsAndSuch; ?>
</body>

</html>