<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	//Iniciar sessão
	session_start();
	
	//Limpar as variáveis armazenadas em sessão
	unset($_SESSION['SESS_ADMIN_ID']);
	unset($_SESSION['SESS_ADMIN_NAME']);
?>
<?php
	require_once('conteudo-site.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Deslogar</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Deslogar </h1>
		<p align="center">&nbsp;</p>
	</div>
	
	<h4 align="center" class="err">Você foi desconectado.</h4>
	<p align="center"><a href="login-form.php">Clique Aqui</a> para logar</p>

	<?php require('incluir-rodape.php'); ?>

</div>
</body>
</html>
