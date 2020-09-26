<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	if(isset($_POST['Submit'])){
		//verificar se há erros de conexão
		$db_error=false;
		//tentar se conectar ao DB, se não apresentar erro
		if(!@mysql_connect ($_POST['dbHost'],$_POST['dbUser'],$_POST['dbPass'])){
			$db_error=true;
			$error_msg="Desculpe, esses detalhes não estão correctos. Aqui está o erro exato: ".mysql_error();
		}
		 
		if(!$db_error and !@mysql_select_db($_POST['dbName'])){
			$db_error=true;
			$error_msg="O host, nome de usuário e senha estão corretos. Mas algo está errado com o banco de dados fornecido. Aqui está o erro MySQL:".mysql_error();
		}
	}
?>
<?php
	if(isset($_POST['Submit']) AND $db_error==false){
		//Função de higienizar os valores recebidos do formulário. Impede SQL Injection
		function limpar($str) {
			$str = @trim($str);
			if(get_magic_quotes_gpc()) {
				$str = stripslashes($str);
			}
			return mysql_real_escape_string($str);
		}
	}
?>
<?php
	if(isset($_POST['Submit']) AND $db_error==false){
		//Criar um manipulador de conexão se a conexão foi bem-sucedida
		$connect_code="<?php
		define('DB_HOST', '".limpar($_POST['dbHost'])."');
		define('DB_USER', '".limpar($_POST['dbUser'])."');
		define('DB_PASSWORD', '".limpar($_POST['dbPass'])."');
		define('DB_DATABASE', '".limpar($_POST['dbName'])."');
		?>";
	}
?>
<?php
	$write_success=false; //para testar no código
	if(isset($_POST['Submit']) AND !empty($connect_code) AND $db_error==false){
		//verifique as permissões de gravação e escrever o manipulador de conexão em arquivos de config.php para o usuário e administrador
		if(!is_writable("../connection/config.php") AND !is_writable("../admin/connection/config.php")){
			$error_msg="<p>Desculpe, o instalador não pode escrever para <b> ../connection/config.php ou ../admin/connection/config.php ou ambos os arquivos</b>. Você terá que editar o(s) arquivo(s) mesmo ou permissões chmod para 644 para o(s) arquivo(s) e repetir esta etapa. Aqui está o que você precisa inserir nesse arquivo (s):<br/><br/>
			<textarea rows='5' cols='50' onclick='this.select();'>$connect_code</textarea></p>";
		}
		else{
			//escreva no arquivo de configuração de usuário
			$fp_user = fopen('../connection/config.php', 'wb');
			fwrite($fp_user,$connect_code);
			fclose($fp_user);
			chmod('../connection/config.php', 0666); //evitar permissão de gravação de todos
			
			//escreva no arquivo de configuração de administração
			$fp_admin = fopen('../admin/connection/config.php', 'wb');
			fwrite($fp_admin,$connect_code);
			fclose($fp_admin);
			chmod('../admin/connection/config.php', 0666); //evitar permissão de gravação de todos
			
			//escrever em instalar arquivo de configuração
			$fp_install = fopen('connection/config.php', 'wb');
			fwrite($fp_install,$connect_code);
			fclose($fp_install);
			chmod('connection/config.php', 0666); //evitar permissão de gravação de todos
			
			$write_success=true; //alterar para true
		}
	}

?>
<?php
	if(isset($_POST['Submit']) AND !empty($connect_code) AND $write_success==true AND $db_error==false){
		//se a conexão foi estabelecida com sucesso, importar tabelas no banco de dados
		$mysqlDatabaseName =limpar($_POST['dbName']);
		$mysqlUserName =limpar($_POST['dbUser']);
		$mysqlPassword =limpar($_POST['dbPass']);
		$mysqlHostName =limpar($_POST['dbHost']);
		$mysqlImportFilename ='database/rs.sql';
		
		//NÃO EDITAR a linha abaixo
		// Importar banco de dados e a saída somente se houver um erro
		//$command="mysql -h {$mysqlHostName} -u '{$mysqlUserName}' -p '{$mysqlPassword}' '{$mysqlDatabaseName}' <  '{$mysqlImportFilename}'";
		$command='mysql -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' .$mysqlImportFilename;
		$output=array();
		@shell_exec($command,$output,$worked);
		
		switch($worked){
			case 0:
				$okay_msg="<p>Import file <b>$mysqlImportFilename</b> successfully imported to database <b>$mysqlDatabaseName</b>.</p>";
				@header("Location: database/rs.php");
				break;
			case 1:
				$error_msg="<p>Ocorreu um erro quando o instalador tentou preencher o banco de dados. Por favor, repita este passo com cuidado com detalhes de conexão apropriados.</p>";
				break;
		}
	}
	
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Passo 3: Conexão</title>
<link href="stylesheets/install_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/install.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Conexão de banco de dados</h1>
<a href="index.php">Bem-vindo</a> -> <a href="requisitos.php">Requisitos</a> -> <a href="conexao.php">Conexão</a>
</div>
<div id="container">
	<fieldset><legend>Detalhes da conexão</legend>
		<form id="conForm" name="conForm" method="post" action="conexao.php" onsubmit="return validarConexao(this)">
		  <table width="930" border="1" align="center">
			<tr>
				<td colspan="2" style="text-align:center;"><?php if(!empty($error_msg) AND $db_error==true) echo "<span style='color:red;'>$error_msg</span>"; else if(!empty($error_msg)) echo "<span style='color:red;'>$error_msg</span>";?></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Campos obrigatórios</td>
			</tr>
			<tr>
			  <th>Nome do banco de dados </th>
			  <td><font color="#FF0000">* </font><input name="dbName" type="text" class="textfield" id="dbName" maxlength="25" placeholder="Digite o nome do banco de dados" required/></td>
			</tr>
			<tr>
			  <th>Host do banco de dados </th>
			  <td><font color="#FF0000">* </font><input name="dbHost" type="text" class="textfield" id="dbHost" maxlength="25" placeholder="Digite o nome do host do banco de dados" required/></td>
			</tr>
			<tr>
			  <th>Usuário do banco de dados </th>
			  <td><font color="#FF0000">* </font><input name="dbUser" type="text" class="textfield" id="dbUser" maxlength="25" placeholder="Inserir nome de usuário de banco de dados" required/></td>
			</tr>
			<tr>
			  <th>Senha do banco de dados </th>
			  <td><font color="#FF0000">* </font><input name="dbPass" type="password" class="textfield" id="dbPass" maxlength="25" placeholder="Digite a senha do banco de dados"/><input name="local" type="checkbox" class="" id="local"/>Uso local</td>
			</tr>
			<tr>
			  <td colspan="4" align="center"><input type="reset" value="Limpar Campos" /></td>
			</tr>
			<tr>
			  <td colspan="4" align="center"><input type="submit" name="Submit" value="Clique Aqui para estabelecer conexão e proceder" /></td>
			</tr>
		  </table>
		</form>
	</fieldset>
</div>

<?php require('incluir-rodape.php'); ?>

</div>
</body>
</html>