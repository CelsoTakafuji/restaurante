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
<title><?php echo $nome ?>:Sobre Nós</title>
<script type="text/javascript" src="swf/swfobject.js"></script>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	
	<div id="center">
	  <h1>Sobre nós <?php echo $nome; ?></h1>
	  <div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
	  <h3>Sobre nós</h3>
		<?php echo $sobre_nos_descricao; ?>
	  <h3>Visão</h3>
		<?php echo $sobre_nos_visao; ?>
	  <h3>Missão</h3>
		<?php echo $sobre_nos_missao; ?>
	  </div>
	</div>

	<?php require('/incluir-rodape.php'); ?>
</div>

</body>
</html>
