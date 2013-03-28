<?php
	//logs the user out by destroying the sessions.
	session_start();
	session_destroy();
	header("Location: ../index.php?logout=true");
?>