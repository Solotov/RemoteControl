<?php
	include "include/settings.php";
	
	if(isset($_GET["img"])) {
		if(strlen($_GET["img"]) > 100) {
			$conn = new mysqli($host,$user,$pass, "controler");
			$sql = "INSERT INTO `screenshot`(`ip`, `base64`) VALUES (".$_SERVER['REMOTE_ADDR'].",".$_GET["img"].")";
			$conn->query($sql);
			$conn->close();
		} else {
			die;
		}
	} else {
		die;
	}
	
?>