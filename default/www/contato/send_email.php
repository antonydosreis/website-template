<?php
	$email_company = "email@site.com";

	$name = $_POST['nome'];
	$email = $_POST['email'];
	$phone = $_POST['telefone'];
	$message = $_POST['mensagem'];
	$send_date = date('d/m/Y');
	$shipping_time = date('H:i:s');

	$file = "
	<style type='text/css'>
		body {
			margin:10px;
			font-size: 16px;
		}
	</style>
	<html>
		<p><b>name:</b><br>$name</p>
		<p><b>Email:</b><br>$email</p>
		<p><b>Telefone:</b><br>$phone</p>
		<p><b>Mensagem:</b><br>$message</p>
		<p>Este email foi enviado em <b>$send_date</b> às <b>$shipping_time</b></p>
	</html>
	";
	$destino = $email_company;
	$assunto = "Contato pelo Site - $name";

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$name.'<'.$email.'>';

	$enviar_email = mail($destino, $assunto, $file, $headers);
	if($enviar_email){
		echo " <meta http-equiv='refresh' content='3;URL=index.php'>";
		echo "E-MAIL ENVIADO COM SUCESSO!";
	} else {
		echo "erro ao enviar o e-mail";
	}

?>