<?php
	session_start();
	include("../include/db_connect.inc.php");
	if($_SESSION['login'] != true){
		header('Location: login.php');
		die();
	}
	if(isset($_GET['get_out'])){
		session_destroy();
		header('Location: login.php');
		die();
	}
	$current_tab = "";
	if(isset($_GET['tab'])){$current_tab = $_GET['tab'];}

	$sqlInfo = $pdo->query("SELECT * FROM info");
	$infoInfo = $sqlInfo->fetchAll();

$filename = "access_counter.txt";
$fp = fopen($filename, 'r');
$count = fread($fp, filesize($filename));
fclose($fp);

	if(isset($_POST['save'])){
		foreach ($infoInfo as $key => $valueInfo) {
            $field = str_replace(' ', '_', $valueInfo['field']);

            if(isset($_POST[$field])){
            	$value = preg_replace( "/\n/", "<br>", $_POST[$field]);
            	
				$sql = $pdo->prepare("UPDATE info SET value = ? WHERE field = ?");
				$sql->execute(array($value,$field));
            }
            if(isset($_FILES[$field]) and $_FILES[$field]['name']!=""){
            	$value = $field.".".pathinfo($_FILES[$field]['name'])['extension'];
				move_uploaded_file($_FILES[$field]["tmp_name"],"../templates/images/".$value);
				$sql = $pdo->prepare("UPDATE info SET value = ? WHERE field = ?");
				$sql->execute(array($value,$field));
            }
            header("Location:index.php?tab=$current_tab");
        }
	}
	if(isset($_POST['register_photo'])){
		if(isset($_FILES['image']) and $_FILES['image']['name']!=""){
			$new_name_image = "image-".date('dmYHis').".".pathinfo($_FILES["image"]['name'])['extension'];
			$image = $_FILES['image'];
			move_uploaded_file($image["tmp_name"],"../templates/images/".$new_name_image);
			$sql = $pdo->prepare("INSERT INTO info (field, type, tab, value) VALUES (?,?,?,?)");
			$sql->execute([$new_name_image,'geral','Fotos',$new_name_image]);
			header("Location:index.php?tab=$current_tab");
		} 
	}
	if(isset($_POST['delete_photo'])){
		foreach ($infoInfo as $key => $valueInfo3) {
			$field = $valueInfo3['id'];
			if(isset($_POST['id'.str_replace(' ', '_', $field)])){
				$id = $_POST['id'.str_replace(' ', '_', $field)];

				$sql = $pdo->prepare("DELETE FROM info WHERE id = ?");
				$sql->execute(array($id));
				header("Location:index.php?tab=$current_tab"); 
			}
		}
	}
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
			<div class="content">
				<img src="../templates/images/logo2.png" style="height: 50px;">
				<a href="?sair"><i class="fas fa-user-circle"></i> Sair</a>
				<div class="clear"></div>
			</div>
		</header>
		<nav>
			<div class="content">
				<a href="?tab=Página inicial">Página inicial</a>
				<div class="dropdown">
					<span>Avançado</span>
					<div class="dropdown-content">
						<a href="?tab=SEO">SEO</a><br>
						<a href="?tab=Controle de acessos">Controle de acessos</a><br>
					</div>
				</div>
			</div>
		</nav>
		<div class="content">
			<?php if ($current_tab == "Controle de acessos") { ?>
				<br><br><p>Total de visitas ao site: <?= $count ?></p>
			<?php }else if ($current_tab == "Cadastrar fotos") { ?>
				<form method="post" class="form" enctype="multipart/form-data">
					<h2>Cadastrar fotos</h2>
					<p>image</p>
					<img src="preview.png" id="image_preview" alt="Nova image" title="Nova image" onclick="$('#image_file').trigger('click');">
					<input type="file" name="image" id="image_file" onchange="document.getElementById('image_preview').src = window.URL.createObjectURL(this.files[0])">
					<div class="clear"></div>
					<button type="submit" name="register_photo"><i class="fas fa-check"></i> Cadastrar</button>
				</form>
			<?php }else if ($current_tab == "Fotos") { ?>
				<?php foreach ($infoInfo as $key => $valueInfo) { ?>
					<?php if($valueInfo['tab'] == "Fotos"){ ?>
						<form method="post" class="form photo" enctype="multipart/form-data">
							<h2><?= $valueInfo['field'] ?></h2>
							<p>image</p>
							<img src="../templates/images/<?= $valueInfo['value'] ?>" alt="image atual" title="image atual">
							<div class="clear"></div>
							<input type="hidden" name="id<?= str_replace(' ', '_', $valueInfo['id']) ?>" value="<?= $valueInfo['id'] ?>">
							<button type="submit" name="delete_photo"><i class="fas fa-times"></i> excluir</button>
						</form>
					<?php } ?>
				<?php } ?>
			<?php }else{ ?>
				<form method="post" class="form" enctype="multipart/form-data" runat="server">
					<h2><?= $current_tab ?></h2>
					<?php foreach ($infoInfo as $key => $valueInfo) {
						if($valueInfo['tab'] == $current_tab){
							if($valueInfo['type'] == "texto"){ ?>
								<p><?= str_replace('_', ' ', $valueInfo['field']) ?></p>
								<input type="text" name="<?= $valueInfo['field'] ?>" value="<?= $valueInfo['value'] ?>">
								<hr>
							<?php }
							if($valueInfo['type'] == "texto_longo"){ ?>
								<p><?= str_replace('_', ' ', $valueInfo['field']) ?></p>
								<textarea name="<?= str_replace(' ', '_', $valueInfo['field']) ?>"><?= preg_replace("/<br>/", "\n", $valueInfo['value']) ?></textarea>
								<script>
									CKEDITOR.replace( '<?= str_replace(' ', '_', $valueInfo['field']) ?>' );
								</script>
								<hr>
							<?php }
							if($valueInfo['type'] == "imagem"){ ?>
								<p><?= str_replace('_', ' ', $valueInfo['field']) ?></p>
								<img src="../templates/images/<?= $valueInfo['value'] ?>" alt="image atual" title="image atual">
								<div class="arrow"><p><i class="fas fa-arrow-right"></i></p></div>
								<img src="preview.png" id="image_preview_<?= $valueInfo[1] ?>" alt="Nova image" title="Nova image" onclick="$('#image_file_<?= str_replace(' ', '_', $valueInfo[1]) ?>').trigger('click');">
								<input type="file" name="<?= str_replace(' ', '_', $valueInfo['field']) ?>" id="image_file_<?= str_replace(' ', '_', $valueInfo[1]) ?>" onchange="document.getElementById('image_preview_<?= $valueInfo[1] ?>').src = window.URL.createObjectURL(this.files[0])">
								<div class="clear"></div>
								<hr>
							<?php }
						} 
					} ?>
					<button type="submit" name="save"><i class="fas fa-check"></i> Salvar</button>
				</form>
			<?php } ?>
		</div>
		<link rel="preconnect" href="https://fonts.gstatic.com"><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700;800&display=swap" rel="stylesheet">
		<script src='https://kit.fontawesome.com/a076d05399.js'></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	</body>
</html>