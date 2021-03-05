<?php
	session_start();
	include("../include/db_connect.inc.php");
	$sqlInfo = $pdo->query("SELECT * FROM info");
	$infoInfo = $sqlInfo->fetchAll();

	if(isset($_POST['login'])){
		$user = $_POST['user'];
		$password = $_POST['password'];
		$sql = $pdo->prepare("SELECT * FROM users WHERE user = ?");
		$sql->execute([$user]);

		if($sql->rowCount() == 1){
			$info = $sql->fetch();
			if(password_verify($password, $info['password'])){
				$_SESSION['login'] = true;
				$_SESSION['id'] = $info['id'];
				$_SESSION['user'] = $info['user'];
				header("Location: index.php");
				die();
			}else{
				echo '<p class="warning">Usuário ou password incorretos!</p>';
			}
		}else{
			echo '<p class="warning">Usuário ou password incorretos!</p>';
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login - Painel administrativo</title>
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
				<h1>Entrar</h1>
				<p>Usuário</p>
				<input type="text" name="user" placeholder="Usuário" autofocus>
				<p>Senha</p>
				<input type="password" name="password" placeholder="Senha">
				<input type="submit" name="login" value="Entrar">
			</form>
		</div>
	</body>
</html>