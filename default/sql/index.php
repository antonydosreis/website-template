<?php
	include("../www/include/db_connect.inc.php");
	$sqlInfo = $pdo->query("SELECT * FROM info");
	$infoInfo = $sqlInfo->fetchAll();

	if(isset($_POST['save'])){
		$id = $_POST['id'];
		$field = str_replace(' ', '_', $_POST['field']);
		$type = $_POST['type'];
		$tab = $_POST['tab'];
		$value = $_POST['value'];

		$sql = $pdo->prepare("UPDATE info SET field = ?, type = ?, tab = ?, value = ? WHERE id = ?");
		$sql->execute(array($field,$type,$tab,$value,$id));
		header("Location:insert.php"); 
	}
	if(isset($_POST['register'])){
		$field = str_replace(' ', '_', $_POST['field']);
		$type = $_POST['type'];
		$tab = $_POST['tab'];
		$value = $_POST['value'];

		$sql = $pdo->prepare("INSERT INTO info (field, type, tab, value) VALUES (?,?,?,?)");
		$sql->execute(array($field,$type,$tab,$value));
		header("Location:insert.php"); 
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Insert/Edit DB</title>
		<meta charset="utf-8">
		<style>
			table, tr{ border: 1px solid #ccc; border-collapse: collapse; border-spacing: 0; }
			table input{ border: none; }
			table input[type=submit]{ border: 1px solid #bbb; }
			th{ background-color: #eee; }
			.long{ width: 500px; }
		</style>
	</head>
	<body>
		<h2>Register</h2>
		<form method="post">
			<input type="text" name="field" placeholder="field">
			<input type="text" name="type" placeholder="type">
			<input type="text" name="tab" placeholder="tab">
			<input type="text" name="value" placeholder="value">
			<input type="submit" name="register" value="Register">
		</form>
		<h2>Edit</h2>
		<table>
			<tr>
				<th></th>
				<th>Field</th>
				<th>Type</th>
				<th>Tab</th>
				<th>Value</th>
				<th></th>
			</tr>
			<?php
			for ($i=0; $i < sizeof($infoInfo); $i++) { ?>
				<form method="post">
					<tr>
						<input type="hidden" name="id" value="<?= $infoInfo[$i]['id'] ?>">
						<td><?= $i ?></td>
						<td><input type="text" name="field" value="<?= str_replace('_', ' ', $infoInfo[$i]['field']) ?>"></td>
						<td><input type="text" name="type" value="<?= $infoInfo[$i]['type'] ?>"></td>
						<td><input type="text" name="tab" value="<?= $infoInfo[$i]['tab'] ?>"></td>
						<td><input type="text" name="value" value="<?= $infoInfo[$i]['value'] ?>" class="long"></td>
						<td><input type="submit" name="save" value="Save"></td>
					</tr>
				</form>
			<?php } ?>
		</table>
	</body>
</html>