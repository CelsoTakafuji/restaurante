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
<title><?php echo $nome ?>: Falha na Avaliação</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	
	<div id="center">
		<h1>Falha na Avaliação</h1>
		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<p>&nbsp;</p>
			<div class="error">A comida já foi classificada!</div>
			<p>Você está vendo esta página porque você já avaliou este alimento. <a href="minha-conta.php">Clique aqui</a> para voltar à sua conta e avaliar um outro alimento.</p>
		</div>
	</div>

	<?php require('/incluir-rodape.php'); ?>

</div>
</body>
</html>