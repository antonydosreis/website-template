<?php
	session_start();
	include("../include/db_connect.inc.php");
	if(isset($_POST['cadastrar'])){
		$user = $_POST['user'];
		$password = $_POST['password'];
		$encrypted = password_hash($password, PASSWORD_DEFAULT);
		if($user == '' || $password == ''){
			echo '<p class="warning">Preencha todos os campos!</p>';
		}else{
			$sql = $pdo->prepare("INSERT INTO users VALUES (?,?,?)");
			$sql->execute([null,$user, $encrypted]);
			echo '<p class="warning" style="background-color: green;">Usuário cadastrado con sucesso!</p>';
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Cadastrar usuário - Painel administrativo</title>
		<meta charset="utf-8">
		<link rel="icon" href="favicon.ico">
		<meta http-equiv="Content-Language" content="pt-br">
		<meta name="viewport" content="width=devide-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css"  href="style.css" />
	</head>
	<body>
		<div class="login">
			<img src="../templates/images/logo.png">
			<form method="post" class="login">
				<h1>Cadastrar usuário</h1>
				<p>Usuário</p>
				<input type="text" name="user" placeholder="Usuário" autofocus>
				<p>Senha</p>
				<input type="password" name="password" placeholder="Senha">
				<input type="submit" name="cadastrar" value="Cadastrar">
			</form>
		</div>
	</body>
</html>