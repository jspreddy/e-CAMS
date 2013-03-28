<?php
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else{
?>
<div class="footer">
	Developer | <a href="#">jspreddy</a>
</div>
<?php
}?>