<?php
	include("../include/db_connect.inc.php");
	$sqlInfo = $pdo->query("SELECT * FROM info");
	$infoInfo = $sqlInfo->fetchAll();
	$dir = "../";
	include("../include/global_var.inc.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php include("include/head.inc.php") ?>
	<!--título--><title>TÍTULO</title>
	<meta property="og:title" content="TÍTULO">
	<meta name="twitter:title" content="TÍTULO">
	<!--descrição--><meta name="description" content="DESCRIÇÃO">
	<meta property="og:site_name" content="DESCRIÇÃO">
	<meta property="og:description" content="DESCRIÇÃO">
	<meta name="twitter:description" content="DESCRIÇÃO">
	<!--link--><link rel="canonical" href="https://LINK.com.br">
	<meta property="og:url" content="https://LINK.com.br">
	<!--imagem--><meta property="og:image" content="https://site.com/templates/images/BANNER.jpg">
	<meta name="twitter:image" content="https://site.com/templates/images/BANNER.jpg">
	<meta name="twitter:card" content="summary_large_image">
	<meta property="og:image:type" content="image/jpg">
	<meta property="og:image:width" content="1920">
	<meta property="og:image:height" content="1080">
	<!--twitter--><meta name="twitter:site" content="@twitter">
	<meta name="twitter:creator" content="@twitter">
	<!--css--><link rel="stylesheet" type="text/css" href="templates/css/style.css">
</head>
<body>
	<?php include("../include/header.inc.php") ?>
	<form action="enviar_email.php" name="formulario_contato" method="post">
		<input type="text" name="nome" placeholder="Nome" required>
		<input type="email" name="email" placeholder="Email" required>
		<input type="tel" name="telefone" placeholder="(DD) 9 9999 9999" required>
		<textarea name="mensagem" placeholder="Sua mensagem" rows="4" required></textarea>
		<input type="submit" name="enviar" id="botao_enviar" value="Enviar">
	</form>
	<?php include("../include/footer.inc.php") ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://kit.fontawesome.com/a076d05399.js"></script>
	<script type="text/javascript" src="../templates/js/script.js"></script>
</body>
</html>