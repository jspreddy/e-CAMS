<?php
$format = 'Y-m-d H:i:s'; 

$date = date ( $format ); 
echo date ( $format, strtotime ( '-7 day' . $date ) );
?>