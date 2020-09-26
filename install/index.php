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
<title>Passo 1: Bem-vindo</title>
<link href="stylesheets/install_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/install.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>RSv1.0.0 Instalação</h1>
<a href="index.php">Bem-vindo</a>
</div>
<div id="container">
	<fieldset><legend>Instruções de instalação</legend>
		<table border="1" width="930" align="center">
			<form id="bemVindoForm" name="bemVindoForm" action="requisitos.php">
				<tr>
					<td align="center">Antes de prosseguir, certifique-se de que você tenha entendido o seguinte:</td>
				</tr>
				<tr>
					<td>1. A base de dados para RSv1.0.0 já foi criada. Isso é feito por VOCÊ!</td>	
				</tr>
				<tr>
					<td>2. Você tem que colocar o nome do banco, máquina, usuário e senha em algum lugar.</td>	
				</tr>
				<tr>
					<td>3. Você tem colocar o nome de usuário e senha de administrador em algum lugar.</td>			
				</tr>
				<tr>
					<td>4. A instalação pode falhar em qualquer etapa. É de sua responsabilidade completar a instalação!</td>			
				</tr>
				<tr>
					<td>5. Você deve excluir esta pasta de instalação após uma instalação bem-sucedida de RSv1.0.0 de sua conta de hospedagem (por razões de segurança como eles sempre dizem;-)).</td>			
				</tr>
				<tr>
					<td align="center"><input type="submit" value="Clique Aqui para Proceder" /></td>			
				</tr>
			</form>
		</table>
	</fieldset>
</div>

<?php require('incluir-rodape.php'); ?>

</div>
</body>
</html>