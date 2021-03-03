<?php
	$email_empresa = "email@site.com";

	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
	$mensagem = $_POST['mensagem'];
	$data_envio = date('d/m/Y');
	$hora_envio = date('H:i:s');

	$arquivo = "
	<style type='text/css'>
		body {
			margin:10px;
			font-size: 16px;
		}
	</style>
	<html>
		<p><b>Nome:</b><br>$nome</p>
		<p><b>Email:</b><br>$email</p>
		<p><b>Telefone:</b><br>$telefone</p>
		<p><b>Mensagem:</b><br>$mensagem</p>
		<p>Este email foi enviado em <b>$data_envio</b> às <b>$hora_envio</b></p>
	</html>
	";
	$destino = $email_empresa;
	$assunto = "Contato pelo Site - $nome";

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$nome.'<'.$email.'>';

	$enviar_email = mail($destino, $assunto, $arquivo, $headers);
	if($enviar_email){
		echo " <meta http-equiv='refresh' content='3;URL=index.php'>";
		echo "E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário";
	} else {
		echo "erro ao enviar o e-mail";
	}

?>