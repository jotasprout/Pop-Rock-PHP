<?php

require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

?>

<!doctype html>
<html>
	
<head>
	<meta charset="UTF-8">
	<title>About Me</title>
	<?php echo $stylesAndSuch; ?>
</head>
	
<body>

<div class="container">

	<?php echo $navbar ?>
	
	<!-- main -->
	
<div class="panel panel-primary">

	<div class="panel-heading">
		<h3 class="panel-title">Learn All About Me</h3>


	</div>

	<div class="panel-body"> 
		
        <!-- Panel Content --> 
        <ul>
            <li><a href='https://github.com/jotasprout'>GitHub</a></li>
            <li><a href='https://www.linkedin.com/in/jotasprout/'>LinkedIn</a></li>
            <li><a href='https://www.instagram.com/jotasprout/'>Instagram</a></li>
            <!--
            <li><a href='https://www.roxorsoxor.com'>Resume: Dev-Focused</a></li>
            <li><a href='https://www.roxorsoxor.com'>Resume: Comprehensive</a></li>
            -->
            <li><a href='https://jotascript.wordpress.com'>"Blog"</a></li>
            <li><a href='https://www.twitter.com/sproutmeansgrow'>Twitter</a></li>
            <li><a href='https://www.reddit.com/user/jaysprout'>Reddit</a></li>
            <li><a href='https://www.facebook.com/jay.sprout.5'>Facebook</a></li>
        </ul>

	</div> <!-- panel body -->

</div> <!-- panel panel-primary -->

</div> <!-- closing container -->
	
<?php echo $scriptsAndSuch; ?>

</body>
	
</html>