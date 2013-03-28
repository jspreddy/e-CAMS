<?php
	//this script returns the current time on the server.
	//used in the ajax load of the profile count down javascript
	date_default_timezone_set("Asia/Calcutta");
	echo date("Y, m, d, H, i, s");
?>