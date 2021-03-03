<?php
	include("../www/include/db_connect.inc.php");
	$sqlInfo = $pdo->query("SELECT * FROM info");
	$infoInfo = $sqlInfo->fetchAll();

	if(isset($_POST['salvar'])){
		$id = $_POST['id'];
		$campo = str_replace(' ', '_', $_POST['campo']);
		$tipo = $_POST['tipo'];
		$aba = $_POST['aba'];
		$valor = $_POST['valor'];

		$sql = $pdo->prepare("UPDATE info SET campo = ?, tipo = ?, aba = ?, valor = ? WHERE id = ?");
		$sql->execute(array($campo,$tipo,$aba,$valor,$id));
		header("Location:insert.php"); 
	}
	if(isset($_POST['cadastrar'])){
		$campo = str_replace(' ', '_', $_POST['campo']);
		$tipo = $_POST['tipo'];
		$aba = $_POST['aba'];
		$valor = $_POST['valor'];

		$sql = $pdo->prepare("INSERT INTO info (campo, tipo, aba, valor) VALUES (?,?,?,?)");
		$sql->execute(array($campo,$tipo,$aba,$valor));
		header("Location:insert.php"); 
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Insert/Edit BD</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Cadastrar</h2>
		<form method="post">
			<input type="text" name="campo" placeholder="Campo">
			<input type="text" name="tipo" placeholder="Tipo">
			<input type="text" name="aba" placeholder="Aba">
			<input type="text" name="valor" placeholder="Valor">
			<input type="submit" name="cadastrar" value="Cadastrar">
		</form>
		<h2>Editar</h2>
		<table>
			<tr>
				<th></th>
				<th>Campo</th>
				<th>Tipo</th>
				<th>Aba</th>
				<th>Valor</th>
				<th></th>
			</tr>
			<?php
			for ($i=0; $i < sizeof($infoInfo); $i++) { ?>
				<form method="post">
					<tr>
						<input type="hidden" name="id" value="<?= $infoInfo[$i]['id'] ?>">
						<td><?= $i ?></td>
						<td><input type="text" name="campo" value="<?= str_replace('_', ' ', $infoInfo[$i]['campo']) ?>"></td>
						<td><input type="text" name="tipo" value="<?= $infoInfo[$i]['tipo'] ?>"></td>
						<td><input type="text" name="aba" value="<?= $infoInfo[$i]['aba'] ?>"></td>
						<td><input type="text" name="valor" value="<?= $infoInfo[$i]['valor'] ?>"></td>
						<td><input type="submit" name="salvar" value="Salvar"></td>
					</tr>
				</form>
			<?php } ?>
		</table>
	</body>
</html>