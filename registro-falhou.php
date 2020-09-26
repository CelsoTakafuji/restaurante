<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	require_once('admin/conteudo-site.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $nome ?>: Falha no Registro</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
</script>
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	
	<div id="center">
		<h1>Falha no Registro</h1>
		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<p>&nbsp;</p>
			<div class="error">O registro falhou!</div>
			<p>Você está vendo esta página porque sua tentativa de criar uma nova conta falhou. Você usou um endereço de e-mail que já está em uso. <a href="login-registrar.php">Clique aqui</a> para tentar novamente. Ou <a href="JavaScript: resetPassword()">Clique aqui</a> para redefinir sua senha.</p>
		</div>
	</div>
	
	<?php require('/incluir-rodape.php'); ?>	
</div>
</body>
</html>