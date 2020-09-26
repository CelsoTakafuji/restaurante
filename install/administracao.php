<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	//verificar a ligação e conexão com um banco de dados
	require_once('../connection/config.php');
	
	$db_error=false;
	
	//Conectar ao servidor MySQL
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		$db_error=true;
		$error_msg="Falha ao conectar ao servidor: " . mysql_error();
	}
	
	//Escolha um banco de dados
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		$db_error=true;
		$error_msg="Não é possível selecionar banco de dados: " . mysql_error();
	}
?>
<?php
	//Função para limpar os valores recebidos do formulário. Impede SQL Injection
	function limpar($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
?>
<?php
	if(isset($_POST['Submit']) AND $db_error==false){
		//obter detalhes de administração do formulário e limpar os valores POST
		$adminName = limpar($_POST['adminName']);
		$adminPass = limpar($_POST['adminPass']);
		

		//Criar a query INSERT
		$qry = "INSERT INTO admin (usuario, senha) VALUES('$adminName','".md5($adminPass)."')";
		$result = @mysql_query($qry);
		
		//Verificar se a consulta foi bem sucedida ou não, e imprimir apenas se falhou
		if($result) {
			$okay_msg= "<p>Conta de administrador criada com sucesso.</p>";
			header("location: concluido.php");
			exit();
		}else {
			$error_msg="<p>Criação da conta de administrador falhou! Algo deu errado em algum lugar. Aqui está o erro MySQL:</p>" . mysql_error();
		}
	}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Passo 4: Administração</title>
<link href="stylesheets/install_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/install.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Credenciais - Admin Login </h1>
<a href="index.php">Bem-vindo</a> -> <a href="requisitos.php">Requisitos</a> -> <a href="conexao.php">Conexão</a> -> <a href="administracao.php">Administração</a>
</div>
<div id="container">
	<fieldset><legend>Detalhes administrador</legend>
		<form id="adminForm" name="adminForm" method="post" action="administracao.php" onsubmit="return validarAdmin(this)">
		  <table width="930" border="1" align="center">
		  	<tr>
				<td colspan="2" style="text-align:center;"><?php if(!empty($error_msg) AND $db_error==true) echo "<span style='color:red;'>$error_msg</span>"; else if(!empty($error_msg)) echo "<span style='color:red;'>$error_msg</span>";?></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Campos obrigatórios</td>
			</tr>
			<tr>
			  <th>Nome de usuário administrador </th>
			  <td><font color="#FF0000">* </font><input name="adminName" type="text" class="textfield" id="adminName" maxlength="25" placeholder="Defina o nome de usuário do administrador" required/></td>
			</tr>
			<tr>
			  <th>Senha do administrador </th>
			  <td><font color="#FF0000">* </font><input name="adminPass" type="password" class="textfield" id="adminPass" maxlength="25" placeholder="Defina a senha do administrador" required/></td>
			</tr>
			<tr>
			  <td colspan="4" align="center"><input type="reset" value="Limpar Campos" /></td>
			</tr>
			<tr>
			  <td colspan="4" align="center"><input type="submit" name="Submit" value="Clique aqui para criar a conta de administrador e proceder" /></td>
			</tr>
		  </table>
		</form>
	</fieldset>
</div>

<?php require('incluir-rodape.php'); ?>

</div>
</body>
</html>