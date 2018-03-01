<?php
	include "include/settings.php";
	
	if(isset($_GET["user"]) and isset($_GET["hwid"])) {
		if(strlen($_GET["hwid"]) < 17) {
			$conn = new mysqli($host,$user,$pass, "controler");
			$sql = 'INSERT INTO `user`(`ip`, `user`, `hwid`) VALUES ("'.$_SERVER['REMOTE_ADDR'].'", "'.$_GET["user"].'", "'.$_GET["hwid"].'")';
			$conn->query($sql);
			$conn->close();
		} else {
			die;
		}
	} else {
		die;
	}
	
?>