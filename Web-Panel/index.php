<?php

	

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
						<tr class="row100 body">
							<td class="cell100 column1">127.0.0.1</td>
							<td class="cell100 column2">Vlad</td>
							<td class="cell100 column3">ABCD-EFJD-0000-1111</td>
							<td class="cell100 column4">None</td>
							<td class="cell100 column5"><a href="new_task.php"><button class="green-bt">Add task</button></a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>