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
	<title>Formulário de Login</title>
	<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
	<link rel="icon" type="image/png" href="../ico/chave.png" />
	<script language="JavaScript" src="validation/admin.js">
	</script>
</head>
	<body>
		<div id="page">
			<div id="header">
				<h1>Administrador - Login </h1>
				<p align="center">&nbsp;</p>
			</div>

			<fieldset><legend>As credenciais do administrador</legend>
				<form id="loginForm" name="loginForm" method="post" action="login-exec.php" onsubmit="return validarLogin(this)">
				  <table width="300" border="1" align="center">
					<tr>
					  <td width="112"><b>Nome de usuário</b></td>
					  <td width="188"><input name="usuario" type="text" class="textfield" id="usuario" maxlength="15" placeholder="Entre com seu nome de usuário" required/></td>
					</tr>
					<tr>
					  <td><b>Senha</b></td>
					  <td><input name="senha" type="password" class="textfield" id="senha" maxlength="25" placeholder="Entre com a sua senha" required/></td>
					</tr>
					<tr>
					  <td><input type="reset" value="Limpar Campos" /></td>
					  <td><input type="submit" name="Submit" value="Logar" /></td>
					</tr>
				  </table>
				</form>
			</fieldset>
			
			<?php require('incluir-rodape.php'); ?>
		
		</div>
	</body>
</html>
