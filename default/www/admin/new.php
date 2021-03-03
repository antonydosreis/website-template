<?php
	session_start();
	include("../include/db_connect.inc.php");
	if(isset($_POST['cadastrar'])){
		$usuario = $_POST['usuario'];
		$senha = $_POST['senha'];
		$criptografada = password_hash($senha, PASSWORD_DEFAULT);
		if($usuario == '' || $senha == ''){
			echo '<p class="aviso">Preencha todos os campos!</p>';
		}else{
			$sql = $pdo->prepare("INSERT INTO usuarios VALUES (?,?,?)");
			$sql->execute([null,$usuario, $criptografada]);
			echo '<p class="aviso" style="background-color: green;">Usuário cadastrado con sucesso!</p>';
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
				<input type="text" name="usuario" placeholder="Usuário" autofocus>
				<p>Senha</p>
				<input type="password" name="senha" placeholder="Senha">
				<input type="submit" name="cadastrar" value="Cadastrar">
			</form>
		</div>
	</body>
</html>