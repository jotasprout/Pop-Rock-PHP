<?php

	session_save_path ($_SERVER['DOCUMENT_ROOT'] . '/tmp');	
	session_start();
	// session_unset();
	// session_destroy();
	// session_start();
	if ($_POST['artist']) {
		$artistID = $_POST['artist'];
		$_SESSION['artist'] = $artistID;	
	} elseif ($_SESSION['artist']) {
		$artistID = $_SESSION['artist'];
		$_SESSION['artist'] = $artistID;
	} else {
		echo 'There is no session artist, baby!';
	}

?>