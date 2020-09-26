<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Passo 5: Concluído</title>
<link href="stylesheets/install_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/install.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Concluído </h1>
<a href="index.php">Bem-vindo</a> -> <a href="requirements.php">Requisitos</a> -> <a href="connection.php">Conexão</a> -> <a href="administration.php">Administração</a> -> <a href="done.php">Concluído</a>
</div>
<div id="container">
	<fieldset><legend>Instalação Completa</legend>
		<table border="1" width="930" align="center">
			<form id="concluidoForm" name="concluidoForm" action="../admin/login-form.php">
				<tr>
					<td>Se você chegou até aqui, espero que a instalação tenha sido bem executada. Para confirmar isso, clique no botão abaixo para fazer login no painel de controle do administrador. Se você não pode entrar, então algo deu errado em algum lugar. Siga as instruções cuidadosamente e repita a instalação. Boa sorte:-)</td>
				</tr>
				<tr>
					<td align="center"><input type="submit" value="Clique aqui para finalizar" /></td>			
				</tr>
			</form>
		</table>
	</fieldset>
</div>

<?php require('incluir-rodape.php'); ?>

</div>
</body>
</html>