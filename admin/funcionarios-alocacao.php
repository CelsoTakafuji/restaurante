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
	$regspagina = 5;
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
    
    //Selecionar todos os registros da tabela de funcionarios. Retornar um erro se não há registros nas tabelas
    $resultado = mysql_query("SELECT * FROM funcionarios LIMIT $iniciarpagina, $regspagina")
    or die("Não há registros para mostrar... \n" . mysql_error());
	
    //Selecionar todos os registros da tabela de funcionarios. Retornar um erro se não há registros nas tabelas
    $resultado_2 = mysql_query("SELECT * FROM funcionarios LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
    or die("Não há registros para mostrar... \n" . mysql_error()); 
?>
<?php
    //Obter identificações de ordem da tabela pedidos com base na flag_0
    $flag_0 = 0;
    $pedidos = mysql_query("SELECT * FROM pedidos WHERE id_funcionario = '$flag_0'")
    or die("Não há registros para mostrar... \n" . mysql_error()); 
?>
<?php
    //Obter ids de reserva da tabela reservas com base na flag_0
    $flag_0 = 0;
    $reservas = mysql_query("SELECT * FROM reservas WHERE flag='$flag_0'")
    or die("Não há registros para mostrar... \n" . mysql_error()); 
?>
<?php
    //Selecionar todos os registros da tabela funcionarios. Retornar um erro se não há registros nas tabelas
    $funcionarios_1 = mysql_query("SELECT * FROM funcionarios")
    or die("Não há registros para mostrar... \n" . mysql_error());
?>
<?php
    //Selecionar todos os registros da tabela de funcionarios. Retornar um erro se não há registros nas tabelas
    $funcionarios_2 = mysql_query("SELECT * FROM funcionarios")
    or die("Não há registros para mostrar... \n" . mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Funcionários</title>
	<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
	<link rel="icon" type="image/png" href="../ico/chave.png" />
	<script language="JavaScript" src="validation/admin.js">
	</script>
	<script language="JavaScript">
		//abrir página em formato popup 
		function abrirPagina(pagina,width,height)
		{
			window.open(pagina,'abrir para visualização','toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=no,copyhistory=no,scrollbars=yes,width='.concat(width).concat(',height=').concat(height).concat(''));
		}
	</script>
</head>
	<body>
		<div id="page">
			<div id="header">
				<h1>Gerenciamento de Funcionários </h1>
				<?php require('incluir-menu.php'); ?>
			</div>
			
			<div id="container">
				<fieldset><legend>Novo Funcionário</legend>
					<table align="center">
					<tr>
					<td>
						<fieldset><legend>Novo Funcionário</legend>
							<form id="funcionariosForm" name="funcionariosForm" method="post" action="funcionarios-exec.php" onsubmit="return validarFuncionarios(this)">
							<table width="450" border="1" align="center">
								<tr>
									<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Campos obrigatórios</td>
								</tr>
								<tr>
								  <th>Primeiro Nome </th>
								  <td><font color="#FF0000">* </font><input name="nome" type="text" class="textfield" id="nome" maxlength="15" placeholder="Digite o primeiro nome" required/></td>
								</tr>
								<tr>
								  <th>Último Nome </th>
								  <td><font color="#FF0000">* </font><input name="sobrenome" type="text" class="textfield" id="funcionariosForm" maxlength="15" placeholder="Digite o sobrenome" required/></td>
								</tr>
								 <tr>
								  <th>Endereço </th>
								  <td><font color="#FF0000">* </font><textarea name="endereco" id="endereco" class="textfield" rows="4" cols="30" maxlength="100" placeholder="Digite o endereço usando o formato padrão" required></textarea></td>
								</tr>
								<tr>
								  <th>Celular/Telefone </th>
								  <td><font color="#FF0000">* </font><input name="celular" type="tel" class="textfield formCel" id="celular" maxlength="11" placeholder="Digite o nº de celular ou telefone" required/></td>
								</tr>
								<tr>
								  <td align="center" colspan="2" bgcolor="#dddddd">
									<input type="reset" value="Limpar Campos" />
									<input type="submit" name="Adicionar" value="Adicionar" />
								  </td>
								</tr>
							</table>
							</form>
						</fieldset>
					</td>
					</tr>
					</table>
				</fieldset>
				
				<fieldset><legend>Lista de funcionários</legend>
					<table border="1" width="920" align="center">
						<tr>
							<td class="paginacao" colspan="6" align="right">
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
							<th>Código</th>
							<th>Primeiro Nome</th>
							<th>Último Nome</th>
							<th>Endereço</th>
							<th>Celular/Telefone</th>
							<th width="200">Ação(ões)</th>
						</tr>

						<?php
						//Loop através de todas as linhas da tabela
						while ($row = mysql_fetch_array($resultado)){
						echo '<form id="funcionariosForm" name="funcionariosForm" method="post" action="alterar-funcionario.php" onsubmit="validarFuncionarios(this)">';
						echo "<tr>";
							echo "<td>".$row['id_funcionario']."</td>";
							echo "<td><input size=\"12\" name=\"nome\" type=\"text\" class=\"textfield\" id=\"nome\" maxlength=\"25\" placeholder=\"Nome do funcionário\" value=\"".$row['nome']."\" required/></td>";
							echo "<td><input size=\"12\" name=\"sobrenome\" type=\"text\" class=\"textfield\" id=\"sobrenome\" maxlength=\"25\" placeholder=\"Sobrenome do funcionário\" value=\"".$row['sobrenome']."\" required/></td>";
							echo "<td><input size=\"50\" name=\"endereco\" type=\"text\" class=\"textfield\" id=\"endereco\" maxlength=\"200\" placeholder=\"Endereço do funcionário\" value=\"".$row['endereco']."\" required/></td>";
							echo "<td><input size=\"12\" name=\"celular\" type=\"tel\" class=\"textfield formCel\" id=\"celular\" maxlength=\"11\" placeholder=\"Celular do funcionário\" value=\"".$row['celular']."\" required/></td>";
							echo "<td bgcolor=\"#dddddd\" width=\"145\" align=\"center\">";
								echo "<input type=\"button\" value=\"Remover\" onclick=\"parent.location='remover-funcionario.php?id=". $row['id_funcionario'] ."'\">";
								echo " ";
								echo "<input type=\"hidden\" name=\"id_funcionario\" value=\"".$row['id_funcionario']."\" />";
								echo "<input type=\"submit\" name=\"Alterar\" value=\"Alterar\" />";
							echo '</td>';					
						echo "</tr>";
						echo "</form>";
						}
						?>
						
						<tr>
							<td class="paginacao" colspan="6" align="right">
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
					</form>
				</fieldset>
			
			<hr>
			
			<table align="center">
			<tr>
				<td>
					<fieldset><legend>Alocação de Pedidos</legend>
						<form id="alocacaoPedidosForm" name="alocacaoPedidosForm" method="post" action="pedidos-alocacao.php" onsubmit="return validarAlocacaoPedidos(this)">
							<table width="445" border="0" cellpadding="2" cellspacing="0">
								<tr>
									<td colspan="3" style="text-align:center;"><font color="#FF0000">* </font>Campos Obrigatórios</td>
								</tr>
								<tr>
								  <th align="left">Código do pedido</th>
								  <td><font color="#FF0000">* </font>
									<select name="id_pedido" id="id_pedido">
										<option value="0">- sel. cód. pedido -
										<?php 
										//Loop através das linhas da tabela pedidos
										while ($row=mysql_fetch_array($pedidos)){
											echo "<option value=$row[id_pedido]>$row[id_pedido]"; 
										}
										?>
									</select>
								</td>
								<td>
									
									<a href="JavaScript: abrirPagina('<?php echo "visualizar-pedido.php?id=" ?>'.concat(document.alocacaoPedidosForm.id_pedido.options[document.alocacaoPedidosForm.id_pedido.selectedIndex].value), 800, 400)"><img title="Visualizar o pedido" src="../ico/act_view.png"/></a></td>
									
								</tr>
								<tr>
								  <th align="left">Código do Funcionário</th>
								  <td><font color="#FF0000">* </font>
									<select name="id_funcionario" id="id_funcionario">
										<option value="select">- selecione cód. funcio. -
										<?php 
										//loop através das linhas da tabela staff
										while ($row=mysql_fetch_array($funcionarios_1)){
											echo "<option value=$row[id_funcionario]>$row[id_funcionario] $row[nome] $row[sobrenome]"; 
										}
										?>
									</select>
								</td>
								<td></td>
								</tr>
								<tr bgcolor="#dddddd">
								  <td colspan="3" align="center"><input type="submit" name="Submit" value="Alocar Funcionário" /></td>
								</tr>
							</table>
						</form>
					</fieldset>
				</td>
				
				<td>
					<fieldset><legend>Alocação de Reservas</legend>
						<form id="alocacaoReservasForm" name="alocacaoReservasForm" method="post" action="reservas-alocacao.php" onsubmit="return validarAlocacaoReservas(this)">
							<table width="445" border="0" align="center" cellpadding="2" cellspacing="0">
								<tr>
									<td colspan="3" style="text-align:center;"><font color="#FF0000">* </font>Campos obrigatórios</td>
								</tr>
								<tr>
									<th align="left">Código da Reserva </th>
									<td><font color="#FF0000">* </font>
										<select name="id_reserva" id="id_reserva">
											<option value="0">- selecione cód. reserva -
											<?php 
											//Loop através das linhas da tabela reservations_details
											while ($row=mysql_fetch_array($reservas)){
												echo "<option value=$row[id_reserva]>$row[id_reserva]";
											}
											?>
										</select>
									</td>
									<td><a href="JavaScript: abrirPagina('<?php echo "visualizar-reserva.php?id=" ?>'.concat(document.alocacaoReservasForm.id_reserva.options[document.alocacaoReservasForm.id_reserva.selectedIndex].value), 800, 300)"><img title="Visualizar a reserva" src="../ico/act_view.png"/></a></td>
								</tr>
								
								<tr>
									<th align="left">Código do Funcionário </th>
									<td><font color="#FF0000">* </font>
										<select name="id_funcionario" id="id_funcionario">
											<option value="select">- selecione cód. funcio. -
											<?php 
											//Loop através das linhas da tabela funcionarios
											while ($row=mysql_fetch_array($funcionarios_2)){
												echo "<option value=$row[id_funcionario]>$row[id_funcionario] $row[nome] $row[sobrenome]"; 
											}
											?>
										</select>
									</td>
									<td></td>
								</tr>
								
								<tr bgcolor="#dddddd">
								  <td colspan="3" align="center"><input type="submit" name="Submit" value="Alocar Funcionário" /></td>
								</tr>
							</table>
						</form>
					</fieldset>
				</td>
			</tr>
			</table>
			
			<p>&nbsp;</p>
			<hr>
			
			</div>
			
			<?php
				mysql_free_result($resultado);
				mysql_close($link);
			?>		
			
			<?php require('incluir-rodape.php'); ?>
	
		</div>
	</body>
</html>