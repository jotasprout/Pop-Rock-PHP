<?php

include 'page_pieces/sesh.php';
require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$artistInfo = "SELECT artistID, artistName FROM artists ORDER BY artistName ASC;";

$getit = $connekt->query( $artistInfo );

if(!$getit){ echo 'Cursed-Crap. Did not run the query.'; }	

?>


<!doctype html>
<html>
<head>
    <title>Adding A New Orphan Artist's Albums</title>
    <meta charset='UTF-8'> 
    <?php echo $stylesAndSuch; ?>
</head>

<body>

<div class = "container">

    <form class="form-horizontal" id="addalbums" action="" method="post">
        <fieldset>
                <legend>Dynamic Select An Artist Menu 2000</legend>
            <div class="form-group">

                <div class="col-lg-4">
                    <select class="form-control" id="artistMenu" name="artistMenu">
                        <option value="">- Choose -</option>
                        <?php
                            while ( $row = mysqli_fetch_array( $getit ) ) {
                                $artistID = $row[ "artistID" ];
                                $artistName = $row[ "artistName" ];
                        ?>
                            <option value="<?php echo $artistID ?>"><?php echo $artistName ?></option>

                        <?php 
                            } // end of while
                        ?>
                    
                    </select>
                </div>   
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            
        </fieldset>
    </form>

    <table id="artistInfo">

    </table>

</div> <!-- end of Container -->
<?php echo $scriptsAndSuch; ?>
<!--
<script type="application/javascript" charset="utf-8" src="functions/makeArtistsMenu.js"></script>
-->
</body>

</html>

