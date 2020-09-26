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
<title><?php echo $nome ?>:Acesso Negado</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	
	<div id="center">
		<h1>Acesso negado</h1>
		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<div class="error">403 Acesso negado!</div>
			<?php echo $outros_acesso_negado; ?>
		</div>
	</div>
	
	<?php require('/incluir-rodape.php'); ?>
</div>
</body>
</html>