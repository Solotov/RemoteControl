<?php

	include "include/settings.php";
	
	$conn = new mysqli($host, $user, $pass, "controler");
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$sql = 'SELECT COUNT(*) FROM `user` WHERE `ip` = "'.$ip.'"';
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	if ($row['COUNT(*)'] > 0) {
		$sql = 'SELECT COUNT(*) FROM `task_to` WHERE `ip` = "'.$ip.'"';
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		if ($row['COUNT(*)'] > 0) {
			$sql = 'SELECT `task`, `value` FROM `task_to` WHERE `ip` = "'.$ip.'"';
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			
			echo $row["task"].",".$row["value"];
			
			$sql = 'DELETE FROM `task_to` WHERE `ip` = "'.$ip.'"';
			$conn->query($sql);
			$conn->close();
		} else {
			
			$sql = 'SELECT COUNT(*) FROM `completed` WHERE `ip` = "'.$ip.'"';
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			if ($row['COUNT(*)'] > 0) {
				$conn->close();
				die;
			}
			
			$sql = "SELECT `task`, `value` FROM `task_all`";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			
			echo $row["task"].",".$row["value"];
			
			$sql = 'INSERT INTO `completed`(`ip`) VALUES ("'.$ip.'")';
			$conn->query($sql);
			$conn->close();
		}
	} else {
		$conn->close();
		die;
	}
	
?>