<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	require_once('auth.php');
	require_once('conteudo-site.php');
?>
<?php
	//Verificar se a variável da linha de partida foi passada na URL ou não
	if (!isset($_GET['iniciarpagina']) or !is_numeric($_GET['iniciarpagina'])) {
		//O valor da linha de partida será 0 (zero) porque nada foi encontrado em URL
		$iniciarpagina = 0;
	//Caso contrário, tomar o valor da URL
	} else {
		$iniciarpagina = (int)$_GET['iniciarpagina'];
	}
	$regspagina = 10;
?>
<?php
	//Incluir detalhes da conexão com o banco de dados
	require_once('connection/config.php');
	
	//Conectar ao servidor MySQL
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
    if(!$link) {
        die('Falha ao conectar ao servidor: ' . mysql_error());
    }
	
    //Selecionar o banco de dados
    $db = mysql_select_db(DB_DATABASE);
    if(!$db) {
        die("Não foi possível selecionar o banco de dados!");
    }
	
	//Configurar charset do banco de dados
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');	
	
	//selecionar todos os registros da tabela admin. Retornar um erro se não há registros nas tabelas
	$resultado = mysql_query("SELECT * FROM admin LIMIT $iniciarpagina, $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error());
	
	//selecionar todos os registros da tabela admin. Retornar um erro se não há registros nas tabelas
	$resultado_2 = mysql_query("SELECT * FROM admin LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error());
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Perfil</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Perfil </h1>
		<?php require('incluir-menu.php'); ?>
	</div>
	
	<div id="container">
		<!--
			<fieldset><legend>Atualização da sua senha de administrador</legend>
				<form id="alterarSenhaForm" name="alterarSenhaForm" method="post" action="alterar-senha-exec.php?id=<?php echo $_SESSION['SESS_ADMIN_ID'];?>" onsubmit="return validarAlteracaoSenha(this)">
				  <table width="400" border="1" align="center">
					<tr>
						<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Campos obrigatórios</td>
					</tr>
					<tr>
					  <th width="124">Senha atual</th>
					  <td width="168"><font color="#FF0000">* </font><input name="senha" type="password" class="textfield" id="senha" maxlength="15" placeholder="Fornecer a senha atual do administrador" required/></td>
					</tr>
					<tr>
					  <th>Nova Senha</th>
					  <td><font color="#FF0000">* </font><input name="senhanova" type="password" class="textfield" id="senhanova" maxlength="15" placeholder="Fornecer a nova senha do administrador" required/></td>
					</tr>
					<tr>
					  <th>Confirmar Nova Senha</th>
					  <td><font color="#FF0000">* </font><input name="senhanovaconf" type="password" class="textfield" id="senhanovaconf" maxlength="15" placeholder="Repita a nova senha do administrador" required/></td>
					</tr>
					<tr>
					  <td colspan="2" align="center" bgcolor="#dddddd">
						<input type="reset" value="Limpar Campos" />
						<input type="submit" name="Submit" value="Alterar" />
					</td>
					</tr>
				  </table>
				 </form>
			</fieldset>
			
		<p>&nbsp;</p>
		<hr>			
		-->


		
			<fieldset><legend>Novo Admin</legend>
			<table width="450" align="center" border="1">
				<form name="adminForm" id="adminForm" action="admin-exec.php" method="post" enctype="multipart/form-data" onsubmit="return this">
				<tr align="center">
					<th>Usuário</th>
					<th>Senha</th>
				</tr>
				<tr align="center">
					<td><input type="text" name="usuario" id="usuario" class="textfield" maxlength="15" placeholder="Login de usuário admin" required/></td>
					<td><input type="password" name="senha" id="senha" class="textfield" maxlength="15" placeholder="Senha de usuário admin" required/></td>
				</tr>
				<tr bgcolor="#dddddd">
					<td colspan="5" align="center"><label>Ação(ões) <input type="submit" name="Submit" value="Adicionar" /></label></td>
				</tr>
				</form>
			</table>
			</fieldset>
		
		<hr>
		
			<fieldset><legend>Lista de admistradores</legend>
				<table border="1" width="950" align="center">
					<tr>
						<td class="paginacao" colspan="4" align="right">
							<?php
							//Criar um link "Anterior"
							$prev = $iniciarpagina - $regspagina;
							//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
							if ($prev >= 0)
							echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpagina='.$prev.'"><-Anterior</a>';
							
							if ($prev >= 0 AND mysql_num_rows($resultado) == $regspagina)
							//Criar um separador
							echo ' | ';
							
							if (mysql_num_rows($resultado) == $regspagina && mysql_num_rows($resultado_2) > 0)
							//Criar um link "Próximo"
							echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpagina='.($iniciarpagina + $regspagina).'">Próximo-></a>';
							?>
						</td>
					</tr>
					<tr class="tituloTabela">
						<th>Código do Administrador</th>
						<th>Usuário</th>
						<th>Alterar Senha</th>
						<th>Ação(ões)</th>
					</tr>

					<?php
						//loop através de todas as linhas da tabela
						while ($row = mysql_fetch_array($resultado)){
						echo "<form id=\"adminForm\" name=\"adminForm\" method=\"post\" action=\"alterar-admin.php\" onsubmit=\"return this\">";
						echo "<tr>";
							echo "<td align=\"center\">".$row['id_admin']."</td>";
							echo "<td><input size=\"12\" name=\"usuario\" type=\"text\" class=\"textfield\" id=\"usuario\" maxlength=\"20\" placeholder=\"Usuário do administrador\" value=\"".$row['usuario']."\" required/></td>";
							echo "<td><input size=\"7\" name=\"senha\" type=\"password\" class=\"textfield\" id=\"senha\" maxlength=\"25\" placeholder=\"Nova senha\" /></td>";
							echo "<td bgcolor=\"#dddddd\" width=\"145\" align=\"center\">";
								echo "<input type=\"button\" value=\"Remover\" onclick=\"parent.location='remover-admin.php?id=". $row['id_admin'] ."'\">";
								echo " ";
								echo "<input type=\"hidden\" name=\"id_admin\" value=\"".$row['id_admin']."\" />";
								echo "<input type=\"submit\" name=\"Alterar\" value=\"Alterar\" />";
							echo "</td>";
						echo "</tr>";
						echo "</form>";
					}
					?>
					<tr>
						<td class="paginacao" colspan="8" align="right">
							<?php
							//Criar um link "Anterior"
							$prev = $iniciarpagina - $regspagina;
							//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
							if ($prev >= 0)
							echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpagina='.$prev.'"><-Anterior</a>';
							
							if ($prev >= 0 AND mysql_num_rows($resultado) == $regspagina)
							//Criar um separador
							echo ' | ';
							
							if (mysql_num_rows($resultado) == $regspagina && mysql_num_rows($resultado_2) > 0)
							//Criar um link "Próximo"
							echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpagina='.($iniciarpagina + $regspagina).'">Próximo-></a>';
							?>
						</td>
					</tr>
				</table>
			</fieldset>
		<hr>
		
	</div>
	
	<?php require('incluir-rodape.php'); ?>
	
	<?php
		if (isset($_GET['sucesso'])){
			echo("<script type=\"text/javascript\">alert('Administrador alterado com sucesso!');</script>");
		}
	?>
	
</div>
</body>
</html>
