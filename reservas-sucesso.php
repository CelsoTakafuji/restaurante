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
<title><?php echo $nome ?>: Reserva com sucesso</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	
	<div id="center">
		<h1>Reserva com sucesso</h1>
		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<p>&nbsp;</p>
			<div class="sucesso">Mesas/Salão de festas reservado com sucesso!</div>
			<p><a href="minha-conta.php">Clique Aqui</a> para voltar à sua conta.</p>
		</div>
	</div>
	
	<?php require('/incluir-rodape.php'); ?>
	
</div>
</body>
</html>
