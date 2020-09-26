<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	require_once('conteudo-site.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Falhou</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Login Falhou </h1>
		<p align="center">&nbsp;</p>
	</div>
	
	<h4 align="center" class="err">Login Falhou!</h4>
	<p align="center">Por favor, verifique seu nome de usuário e senha e <a href="login-form.php">tente novamente</a>!</p>

	<?php require('incluir-rodape.php'); ?>

</div>
</body>
</html>
