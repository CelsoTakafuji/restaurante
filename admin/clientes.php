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
	require_once('js/jscSis.php');
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
	
	//selecionar todos os registros da tabela clientes. Retornar um erro se não há registros nas tabelas
	if (isset($_POST['Pesquisar'])){
		$resultado = mysql_query("SELECT * FROM clientes WHERE CONCAT(nome,' ',sobrenome) LIKE '%$_POST[nomeCliente]%' LIMIT $iniciarpagina, $regspagina")
		or die("Não há registros para mostrar... \n" . mysql_error());

		$resultado_2 = mysql_query("SELECT * FROM clientes WHERE CONCAT(nome,' ',sobrenome) LIKE '%$_POST[nomeCliente]%' LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
		or die("Não há registros para mostrar... \n" . mysql_error());
	}else{
		$resultado = mysql_query("SELECT * FROM clientes LIMIT $iniciarpagina, $regspagina")
		or die("Não há registros para mostrar... \n" . mysql_error());
		
		$resultado_2 = mysql_query("SELECT * FROM clientes LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
		or die("Não há registros para mostrar... \n" . mysql_error());
	}
	
	//recuperar perguntas da tabela perguntas
	$perguntas=mysql_query("SELECT * FROM perguntas")
	or die("Algo está errado... \n" . mysql_error());
	
	//selecionar todos os registros da tabela clientes. Retornar um erro se não há registros nas tabelas
	$clientes = mysql_query("SELECT * FROM clientes")
	or die("Não há registros para mostrar... \n" . mysql_error());
	

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Clientes</title>
	<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
	<link rel="icon" type="image/png" href="../ico/chave.png" />
	<script language="JavaScript" src="validation/admin.js"></script>
</head>
	<body>
		<div id="page">
		<div id="header">
		<h1>Gestão de clientes</h1>
		<?php require('incluir-menu.php'); ?>
		</div>
		
		<div id="container">
			<fieldset><legend>Novo Cliente</legend>
				<form id="registroForm" name="registroForm" method="post" action="registro-exec.php" onsubmit="return validarRegistro(this)">
					<table width="500" border="1" align="center" cellpadding="2" cellspacing="0">
						<CAPTION><h2>REGISTRAR UMA NOVA CONTA DE CLIENTE</h2></CAPTION>
						<tr>
							<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Campos obrigatórios</td>
						</tr>
							<th>Nome </th>
							<td><font color="#FF0000">* </font><input size="25" name="nome" type="text" class="textfield" id="nome" maxlength="20" placeholder="Forneça o seu primeiro nome" required/></td>
						</tr>
						<tr>
							<th>Sobrenome </th>
							<td><font color="#FF0000">* </font><input size="25" name="sobrenome" type="text" class="textfield" id="sobrenome" maxlength="20" placeholder="Forneça o seu último nome" required/></td>
						</tr>
						<tr>
							<th width="124">E-mail</th>
							<td width="168"><font color="#FF0000">* </font><input name="email" type="email" class="textfield" id="email" maxlength="25" placeholder="Forneça o seu e-mail" required/></td>
						</tr>
						<tr>
							<th>Senha</th>
							<td><font color="#FF0000">* </font><input name="senha" type="password" class="textfield" id="senha" maxlength="25" placeholder="Forneça a sua senha" required/></td>
						</tr>
						<tr>
							<th>Confirmar Senha </th>
							<td><font color="#FF0000">* </font><input name="csenha" type="password" class="textfield" id="csenha" maxlength="25" placeholder="Repita a senha fornecida" required/></td>
						</tr>
						<tr>
							<th>Pergunta de Segurança </th>
							<td><font color="#FF0000">* </font>
								<select name="pergunta" id="pergunta">
									<option value="select">- Selecione a pergunta -
									<?php 
									//loop através de linhas da tabela perguntas
									while ($row=mysql_fetch_array($perguntas)){ 
										echo "<option value=$row[id_pergunta]>$row[pergunta]"; 
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th>Resposta de segurança</th>
							<td><font color="#FF0000">* </font><input name="resposta" type="text" class="textfield" id="resposta" maxlength="15" placeholder="Insira a sua resposta" required/></td>
						</tr>
						<tr>
							<td colspan="2" align="center" bgcolor="#dddddd">
								<input type="reset" value="Limpar Campos"/>
								<input type="submit" name="Adicionar" value="Adicionar" />
							</td>
						</tr>
					</table>
				</form>
			</fieldset>
			
			<hr>
		
			<fieldset><legend>Pesquisar Cliente</legend>
			<table width="300" align="center">
				<form name="pesqClienteForm" id="pesqClienteForm" action="clientes.php" method="post" onsubmit="return this">
					<tr>
						<th>Nome</th>
						<th>Ação(ões)</th>
					</tr>
					<tr>
						<td><input size="36" type="text" name="nomeCliente" class="textfield" maxlength="25" placeholder="Parte do Nome e/ou Sobrenome do cliente"/></td>
						<td align="center">
							<input type="submit" name="Pesquisar" value="Pesquisar" />
						</td>
					</tr>
				</form>
			</table>
			<p style="color:red" align="center">* Para limpar o filtro basta limpar o campo e acionar o botão Pesquisar.<p>
			</fieldset>
			
			<hr>
		
			<fieldset><legend>Lista de clientes</legend>
				<table border="1" width="950" align="center">
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
					<tr class="tituloTabela">
						<th>Cód.</th>
						<th>Nome</th>
						<th>Sobrenome</th>
						<th>E-mail</th>
						<th>Alterar Senha</th>
						<th>Pergunta</th>
						<th>Alterar Resposta</th>
						<th>Ação(ões)</th>
					</tr>

					<?php
						//loop através de todas as linhas da tabela
						while ($row = mysql_fetch_array($resultado)){
						echo "<form id=\"registroForm\" name=\"registroForm\" method=\"post\" action=\"alterar-cliente.php\" onsubmit=\"return validarRegistro(this)\">";
						echo "<tr>";
							echo "<td align=\"center\">".$row['id_cliente']."</td>";
							echo "<td><input size=\"7\" name=\"nome\" type=\"text\" class=\"textfield\" id=\"nome\" maxlength=\"20\" placeholder=\"Forneça o primeiro nome\" value=\"".$row['nome']."\" required/></td>";
							echo "<td><input size=\"12\" name=\"sobrenome\" type=\"text\" class=\"textfield\" id=\"sobrenome\" maxlength=\"20\" placeholder=\"Forneça o sobrenome\" value=\"".$row['sobrenome']."\" required/></td>";
							echo "<td><input size=\"12\" name=\"login\" type=\"text\" class=\"textfield\" id=\"login\" maxlength=\"25\" placeholder=\"Forneça o login\" value=\"".$row['login']."\" required/></td>";
							echo "<td><input size=\"7\" name=\"senha\" type=\"password\" class=\"textfield\" id=\"senha\" maxlength=\"25\" placeholder=\"Nova senha\" /></td>";
							
							//recuperar perguntas da tabela perguntas (ALTERAÇÃO)
							$perguntas_1=mysql_query("SELECT * FROM perguntas")
							or die("Algo está errado... \n" . mysql_error());
							
							echo "<td>";
								echo "<select name=\"id_pergunta\" id=\"id_pergunta\" style=\"font-size:9\">";
									echo "<option value=\"select\">- Selecione a pergunta -";
									//loop através de linhas da tabela perguntas
									while ($row_pergunta=mysql_fetch_array($perguntas_1)){ 
										echo "<option value=$row_pergunta[id_pergunta]";
										if($row_pergunta[id_pergunta] == $row[id_pergunta]){
											echo " selected=\"selected\" ";
										}
										echo">$row_pergunta[pergunta]"; 
									}
								echo "</select>";
							echo "</td>"; 
							
							echo "<td><input size=\"12\" name=\"resposta\" type=\"text\" class=\"textfield\" id=\"resposta\" maxlength=\"15\" placeholder=\"Resposta de segurança\" /></td>";
								
							echo "<td bgcolor=\"#dddddd\" width=\"145\" align=\"center\">";
								echo "<input type=\"button\" value=\"Remover\" onclick=\"parent.location='remover-cliente.php?id=". $row['id_cliente'] ."'\">";
								echo " ";
								echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$row['id_cliente']."\" />";
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
		
			<fieldset><legend>Alterar endereço/telefones(residencial/celular) de clientes</legend>
				<form name="selClienteForm" id="selClienteForm" action="clientes.php" method="post" onsubmit="return this">
				<table border="0" width="400" align="center">
					
					<tr>
						<td width="25%">Cliente</td>
						<td width="50%">
							<select name="id_cliente" id="id_cliente">
								<option value="0">- selecione o cliente -
								<?php 
								//loop através de linhas da tabela clientes
								while ($row=mysql_fetch_array($clientes)){
									echo "<option value=$row[id_cliente]>$row[nome] $row[sobrenome]"; 
								}
								?>
							</select>
						</td>
						<td width="25%"><input type="submit" name="Enviar" value="Enviar" /></td>
					</tr>
				</table>
				</form>
				
				<?php
					if(isset($_POST['Enviar']) || isset($_GET['id'])){
						if(isset($_POST['Enviar'])){
							$id_cliente = $_POST['id_cliente'];
						}else if (isset($_GET['id'])){
							$id_cliente = $_GET['id'];
						}
						
						if($id_cliente > 0){
							//selecionar registro da tabela enderecos filtrando pelo id do cliente. Retornar um erro se não há registros nas tabelas
							$endereco = mysql_query("SELECT * FROM enderecos WHERE id_cliente = '$id_cliente'")
							or die("Não há registros para mostrar... \n" . mysql_error());
							
							//Recuperar cliente da tabela clientes
							$cliente = mysql_query("SELECT * FROM clientes WHERE id_cliente = '$id_cliente'")
							or die("Não há registros para mostrar... \n" . mysql_error());
							
							$row_cliente = mysql_fetch_array($cliente);
							
							if(mysql_num_rows($endereco) > 0){
								$row = mysql_fetch_array($endereco);
				?>
				
				<form name="enderecoForm" id="enderecoForm" action="alterar-endereco.php" method="post" onsubmit="return this">
				<table border="1" width="950" align="center">
					<tr class="tituloTabela">
						<th>Código do Endereço</th>
						<th>Cliente</th>
						<th>Endereço</th>
						<th>CEP</th>
						<th>Cidade</th>
						<th>Celular</th>
						<th>Telefone</th>
						<th>Ação(ões)</th>
					</tr>
					<?php
					echo "<tr>";
						echo "<td align=\"center\">$row[id_endereco]</td>";
						echo "<td><input size=\"15\" readonly=\"readonly\" type=\"text\" name=\"cliente_nome\" id=\"cliente_nome\" class=\"textfield\" maxlength=\"15\" placeholder=\"Nome do Cliente\" value=\"".$row_cliente['nome']." ".$row_cliente['sobrenome']."\" required/></td>";
						echo "<td><input size=\"30\" type=\"text\" name=\"endereco\" id=\"endereco\" class=\"textfield\" maxlength=\"15\" placeholder=\"Endereço do Cliente\" value=\"".$row['endereco']."\" required/></td>";
						echo "<td><input size=\"8\" type=\"text\" name=\"cep\" id=\"cep\" class=\"textfield formCep\" maxlength=\"15\" placeholder=\"CEP do endereço do Cliente\" value=\"".$row['cep']."\" required/></td>";
						echo "<td><input size=\"10\" type=\"text\" name=\"cidade\" id=\"cidade\" class=\"textfield\" maxlength=\"15\" placeholder=\"Cidade do endereço do Cliente\" value=\"".$row['cidade']."\" required/></td>";
						echo "<td><input size=\"12\" type=\"tel\" name=\"celular\" class=\"textfield formCel\" id=\"celular\" maxlength=\"10\" placeholder=\"Digite o nº de celular\" value=\"".$row['celular']."\" required/>";
						echo "<td><input size=\"12\" type=\"tel\" name=\"telefone\" class=\"textfield formFone\"telefone\" maxlength=\"10\" placeholder=\"Digite o nº de telefone\" value=\"".$row['telefone']."\" required/>";
						echo "<td bgcolor=\"#dddddd\" width=\"145\" align=\"center\">";
							echo "<input type=\"button\" value=\"Remover\" onclick=\"parent.location='remover-endereco.php?id=". $row['id_endereco'] ."'\">";
							echo " ";
							echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$row['id_cliente']."\" />";
							echo "<input type=\"hidden\" name=\"id_endereco\" value=\"".$row['id_endereco']."\" />";
							echo "<input type=\"submit\" name=\"Alterar\" value=\"Alterar\" />";
						echo "</td>";
					echo "</tr>";
					?>
				</table>
				</form>
			
		<?php
				}else{
					echo "<p><b>O cliente selecionado não possuí endereço cadastrado! Você poderá cadastrar através do formulário abaixo.</b></p>";
		?>
				<form name="enderecoForm" id="enderecoForm" action="enderecos-exec.php" method="post" onsubmit="return this">
				<table border="1" width="960" align="center">
					<tr class="tituloTabela">
						<th>Cliente</th>
						<th>Endereço</th>
						<th>CEP</th>
						<th>Cidade</th>
						<th>Celular</th>
						<th>Telefone</th>
						<th>Ação(ões)</th>
					</tr>
					<?php
					echo "<tr>";
						echo "<td><input size=\"15\" readonly=\"readonly\" type=\"text\" name=\"cliente_nome\" id=\"cliente_nome\" class=\"textfield\" maxlength=\"15\" placeholder=\"Nome do Cliente\" value=\"".$row_cliente['nome']." ".$row_cliente['sobrenome']."\" required/></td>";
						echo "<td><input size=\"30\" type=\"text\" name=\"endereco\" id=\"endereco\" class=\"textfield\" maxlength=\"15\" placeholder=\"Endereço do Cliente\" required/></td>";
						echo "<td><input size=\"10\" type=\"text\" name=\"cep\" id=\"cep\" class=\"textfield formCep\" maxlength=\"15\" placeholder=\"CEP do endereço do Cliente\" required/></td>";
						echo "<td><input size=\"10\" type=\"text\" name=\"cidade\" id=\"cidade\" class=\"textfield\" maxlength=\"15\" placeholder=\"Cidade do endereço do Cliente\" required/></td>";
						echo "<td><input size=\"12\" type=\"tel\" name=\"celular\" class=\"textfield formCel\" id=\"celular\" maxlength=\"10\" placeholder=\"Digite o nº de celular\" required/>";
						echo "<td><input size=\"12\" type=\"tel\" name=\"telefone\" class=\"textfield formFone\"telefone\" maxlength=\"10\" placeholder=\"Digite o nº de telefone\" required/>";
						echo "<td bgcolor=\"#dddddd\" width=\"100\" align=\"center\">";
							echo "<input type=\"hidden\" name=\"id_cliente\" value=\"".$row_cliente['id_cliente']."\" />";
							echo "<input type=\"submit\" name=\"Adicionar\" value=\"Adicionar\" />";
						echo "</td>";
					echo "</tr>";
					?>
				</table>
				</form>
		<?php
					}
				}
			}
			echo "</fieldset>";
		
			mysql_free_result($resultado);
			mysql_close($link);
		?>
		
		</div>
		
		<?php require('incluir-rodape.php'); ?>
		
		</div>
	</body>
</html>