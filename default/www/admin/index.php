<?php
	session_start();
	include("../include/db_connect.inc.php");
	if($_SESSION['login'] != true){
		header('Location: login.php');
		die();
	}
	if(isset($_GET['sair'])){
		session_destroy();
		header('Location: login.php');
		die();
	}
	$aba_atual = "";
	if(isset($_GET['aba'])){$aba_atual = $_GET['aba'];}

	$sqlInfo = $pdo->query("SELECT * FROM info");
	$infoInfo = $sqlInfo->fetchAll();

$filename = "contador.txt";
$fp = fopen($filename, 'r');
$count = fread($fp, filesize($filename));
fclose($fp);

	if(isset($_POST['salvar'])){
		foreach ($infoInfo as $key => $valueInfo) {
            $campo = str_replace(' ', '_', $valueInfo['campo']);

            if(isset($_POST[$campo])){
            	$valor = preg_replace( "/\n/", "<br>", $_POST[$campo]);
            	
				$sql = $pdo->prepare("UPDATE info SET valor = ? WHERE campo = ?");
				$sql->execute(array($valor,$campo));
            }
            if(isset($_FILES[$campo]) and $_FILES[$campo]['name']!=""){
            	$valor = $campo.".".pathinfo($_FILES[$campo]['name'])['extension'];
				move_uploaded_file($_FILES[$campo]["tmp_name"],"../templates/images/".$valor);
				$sql = $pdo->prepare("UPDATE info SET valor = ? WHERE campo = ?");
				$sql->execute(array($valor,$campo));
            }
            header("Location:index.php?aba=$aba_atual");
        }
	}
	if(isset($_POST['cadastrar_foto'])){
		if(isset($_FILES['imagem']) and $_FILES['imagem']['name']!=""){
			$novo_nome_imagem = "imagem-".date('dmYHis').".".pathinfo($_FILES["imagem"]['name'])['extension'];
			$imagem = $_FILES['imagem'];
			move_uploaded_file($imagem["tmp_name"],"../templates/images/".$novo_nome_imagem);
			$sql = $pdo->prepare("INSERT INTO info (campo, tipo, aba, valor) VALUES (?,?,?,?)");
			$sql->execute([$novo_nome_imagem,'geral','Fotos',$novo_nome_imagem]);
			header("Location:index.php?aba=$aba_atual");
		} 
	}
	if(isset($_POST['excluir_foto'])){
		foreach ($infoInfo as $key => $valueInfo3) {
			$campo = $valueInfo3['id'];
			if(isset($_POST['id'.str_replace(' ', '_', $campo)])){
				$id = $_POST['id'.str_replace(' ', '_', $campo)];

				$sql = $pdo->prepare("DELETE FROM info WHERE id = ?");
				$sql->execute(array($id));
				header("Location:index.php?aba=$aba_atual"); 
			}
		}
	}


	$aux_abas = "";
    foreach ($infoInfo as $key => $valueInfoA) {
        if(!preg_match("/{$valueInfoA["aba"]}/", $aux_abas)){
            $aux_abas .= $valueInfoA["aba"].",";
        }
    }
    $aux_abas = substr($aux_abas, 0, -1);
    $abas = explode(',', $aux_abas);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Painel administrativo</title>
		<meta charset="utf-8">
		<link rel="icon" href="favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="canonical" href="https://link.com">
		<meta name="robots" content="noindex, nofollow">
		<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
	</head>
	<body>
		<header>
			<div class="bloco">
				<img src="../templates/images/logo2.png" style="height: 50px;">
				<a href="?sair"><i class="fas fa-user-circle"></i> Sair</a>
				<div class="clear"></div>
			</div>
		</header>
		<nav>
			<div class="bloco">
				<a href="?aba=Página inicial">Página inicial</a>
				<div class="dropdown">
					<span>Avançado</span>
					<div class="dropdown-content">
						<a href="?aba=SEO">SEO</a><br>
						<a href="?aba=Controle de acessos">Controle de acessos</a><br>
					</div>
				</div>
			</div>
		</nav>
		<div class="bloco">
			<?php if ($aba_atual == "Controle de acessos") { ?>
				<br><br><p>Total de visitar ao site: <?= $count ?></p>
			<?php }else if ($aba_atual == "Cadastrar fotos") { ?>
				<form method="post" class="formulario" enctype="multipart/form-data">
					<h2>Cadastrar fotos</h2>
					<p>Imagem</p>
					<img src="preview.png" id="image_preview" alt="Nova imagem" title="Nova imagem" onclick="$('#image_file').trigger('click');">
					<input type="file" name="imagem" id="image_file" onchange="document.getElementById('image_preview').src = window.URL.createObjectURL(this.files[0])">
					<div class="clear"></div>
					<button type="submit" name="cadastrar_foto"><i class="fas fa-check"></i> Cadastrar</button>
				</form>
			<?php }else if ($aba_atual == "Fotos") { ?>
				<?php foreach ($infoInfo as $key => $valueInfo) { ?>
					<?php if($valueInfo['aba'] == "Fotos"){ ?>
						<form method="post" class="formulario foto" enctype="multipart/form-data">
							<h2><?= $valueInfo['campo'] ?></h2>
							<p>Imagem</p>
							<img src="../templates/images/<?= $valueInfo['valor'] ?>" alt="Imagem atual" title="Imagem atual">
							<div class="clear"></div>
							<input type="hidden" name="id<?= str_replace(' ', '_', $valueInfo['id']) ?>" value="<?= $valueInfo['id'] ?>">
							<button type="submit" name="excluir_foto"><i class="fas fa-times"></i> excluir</button>
						</form>
					<?php } ?>
				<?php } ?>
			<?php }else{ ?>
				<form method="post" class="formulario" enctype="multipart/form-data" runat="server">
					<h2><?= $aba_atual ?></h2>
					<?php foreach ($infoInfo as $key => $valueInfo) {
						if($valueInfo['aba'] == $aba_atual){
							if($valueInfo['tipo'] == "texto"){ ?>
								<p><?= str_replace('_', ' ', $valueInfo['campo']) ?></p>
								<input type="text" name="<?= $valueInfo['campo'] ?>" value="<?= $valueInfo['valor'] ?>">
								<hr>
							<?php }
							if($valueInfo['tipo'] == "texto_longo"){ ?>
								<p><?= str_replace('_', ' ', $valueInfo['campo']) ?></p>
								<textarea name="<?= str_replace(' ', '_', $valueInfo['campo']) ?>"><?= preg_replace("/<br>/", "\n", $valueInfo['valor']) ?></textarea>
								<script>
									CKEDITOR.replace( '<?= str_replace(' ', '_', $valueInfo['campo']) ?>' );
								</script>
								<hr>
							<?php }
							if($valueInfo['tipo'] == "imagem"){ ?>
								<p><?= str_replace('_', ' ', $valueInfo['campo']) ?></p>
								<img src="../templates/images/<?= $valueInfo['valor'] ?>" alt="Imagem atual" title="Imagem atual">
								<div class="arrow"><p><i class="fas fa-arrow-right"></i></p></div>
								<img src="preview.png" id="image_preview_<?= $valueInfo[1] ?>" alt="Nova imagem" title="Nova imagem" onclick="$('#image_file_<?= str_replace(' ', '_', $valueInfo[1]) ?>').trigger('click');">
								<input type="file" name="<?= str_replace(' ', '_', $valueInfo['campo']) ?>" id="image_file_<?= str_replace(' ', '_', $valueInfo[1]) ?>" onchange="document.getElementById('image_preview_<?= $valueInfo[1] ?>').src = window.URL.createObjectURL(this.files[0])">
								<div class="clear"></div>
								<hr>
							<?php }
						} 
					} ?>
					<button type="submit" name="salvar"><i class="fas fa-check"></i> Salvar</button>
				</form>
			<?php } ?>
		</div>
		<link rel="preconnect" href="https://fonts.gstatic.com"><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;800&display=swap" rel="stylesheet">
		<script src='https://kit.fontawesome.com/a076d05399.js'></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	</body>
</html>