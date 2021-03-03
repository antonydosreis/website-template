<?php
	session_start();
	include("../include/db_connect.inc.php");
	$sqlInfo = $pdo->query("SELECT * FROM info");
	$infoInfo = $sqlInfo->fetchAll();

	if(isset($_POST['login'])){
		$usuario = $_POST['usuario'];
		$senha = $_POST['senha'];
		$sql = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
		$sql->execute([$usuario]);

		if($sql->rowCount() == 1){
			$info = $sql->fetch();
			if(password_verify($senha, $info['senha'])){
				$_SESSION['login'] = true;
				$_SESSION['id'] = $info['id'];
				$_SESSION['usuario'] = $info['usuario'];
				header("Location: index.php");
				die();
			}else{
				echo '<p class="aviso">Usuário ou senha incorretos!</p>';
			}
		}else{
			echo '<p class="aviso">Usuário ou senha incorretos!</p>';
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
				<input type="text" name="usuario" placeholder="Usuário" autofocus>
				<p>Senha</p>
				<input type="password" name="senha" placeholder="Senha">
				<input type="submit" name="login" value="Entrar">
			</form>
		</div>
	</body>
</html>