<?php
	include("include/db_connect.inc.php");
	$sqlInfo = $pdo->query("SELECT * FROM info");
	$infoInfo = $sqlInfo->fetchAll();
	$dir = "";
	include("include/global_var.inc.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php include("include/head.inc.php") ?>
	<!--TITLE--><title>TITLE</title>
	<meta property="og:title" content="TITLE">
	<meta name="twitter:title" content="TITLE">
	<!--DESCRIPTION--><meta name="description" content="DESCRIPTION">
	<meta property="og:site_name" content="DESCRIPTION">
	<meta property="og:description" content="DESCRIPTION">
	<meta name="twitter:description" content="DESCRIPTION">
	<!--LINK--><link rel="canonical" href="https://LINK.com.br">
	<meta property="og:url" content="https://LINK.com.br">
	<!--IMAGE--><meta property="og:image" content="https://site.com/templates/images/BANNER.jpg">
	<meta name="twitter:image" content="https://site.com/templates/images/BANNER.jpg">
	<meta name="twitter:card" content="summary_large_image">
	<meta property="og:image:type" content="image/jpg">
	<meta property="og:image:width" content="1920">
	<meta property="og:image:height" content="1080">
	<!--TWITTER--><meta name="twitter:site" content="@twitter">
	<meta name="twitter:creator" content="@twitter">
	<!--CSS--><link rel="stylesheet" type="text/css" href="templates/css/style.css">
</head>
<body>
	<?php include("include/header.inc.php") ?>
	<?php include("include/footer.inc.php") ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
	<script type="text/javascript" src="../templates/js/script.js"></script>
</body>
</html>