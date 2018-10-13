<?php
	if(!isset($_SESSION['users']) && $_SESSION['users'] != true){
		header("Location: index.php");
	}
?>