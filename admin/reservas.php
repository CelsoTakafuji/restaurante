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
	if (!isset($_GET['iniciarpaginamesa']) or !is_numeric($_GET['iniciarpaginamesa'])) {
		//O valor da linha de partida será 0 (zero) porque nada foi encontrado em URL
		$iniciarpaginamesa = 0;
	//Caso contrário, tomar o valor da URL
	} else {
		$iniciarpaginamesa = (int)$_GET['iniciarpaginamesa'];
	}
	$regspagina = 5;
?>
<?php
	//Verificar se a variável da linha de partida foi passada na URL ou não
	if (!isset($_GET['iniciarpaginasalao']) or !is_numeric($_GET['iniciarpaginasalao'])) {
		//O valor da linha de partida será 0 (zero) porque nada foi encontrado em URL
		$iniciarpaginasalao = 0;
	//Caso contrário, tomar o valor da URL
	} else {
		$iniciarpaginasalao = (int)$_GET['iniciarpaginasalao'];
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
	
	//Selecionar todos os registros das tabelas clientes, reservas e mesas. Retornar um erro se não há registros na tabela
	$mesas = mysql_query("SELECT clientes.id_cliente, clientes.nome, clientes.sobrenome, reservas.id_reserva, reservas.id_mesa, reservas.reserva_data, reservas.reserva_tempo, reservas.flag, mesas.id_mesa, mesas.mesa_nome, funcionarios.id_funcionario, funcionarios.nome as nome_funcionario, funcionarios.sobrenome as sobrenome_funcionario FROM reservas LEFT OUTER JOIN funcionarios ON reservas.id_funcionario = funcionarios.id_funcionario, clientes, mesas WHERE clientes.id_cliente = reservas.id_cliente AND mesas.id_mesa = reservas.id_mesa LIMIT $iniciarpaginamesa, $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error()); 

	//Selecionar todos os registros das tabelas clientes, reservas e mesas. Retornar um erro se não há registros na tabela
	$mesas_2 = mysql_query("SELECT clientes.id_cliente, clientes.nome, clientes.sobrenome, reservas.id_reserva, reservas.id_mesa, reservas.reserva_data, reservas.reserva_tempo, reservas.flag, mesas.id_mesa, mesas.mesa_nome, funcionarios.id_funcionario, funcionarios.nome as nome_funcionario, funcionarios.sobrenome as sobrenome_funcionario FROM reservas LEFT OUTER JOIN funcionarios ON reservas.id_funcionario = funcionarios.id_funcionario, clientes, mesas WHERE clientes.id_cliente = reservas.id_cliente AND mesas.id_mesa = reservas.id_mesa LIMIT ".($iniciarpaginamesa + $regspagina).", $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error()); 
	
	//Selecionar todos os registros das tabelas clientes, reservas e saloes_festa. Retornar um erro se não há registros na tabela
	$saloes = mysql_query("SELECT clientes.id_cliente, clientes.nome, clientes.sobrenome, reservas.id_reserva, reservas.id_salao_festas, reservas.reserva_data, reservas.reserva_tempo, reservas.flag, saloes_festa.id_salao_festas, saloes_festa.salao_festas_nome, funcionarios.id_funcionario, funcionarios.nome as nome_funcionario, funcionarios.sobrenome as sobrenome_funcionario FROM reservas LEFT OUTER JOIN funcionarios ON reservas.id_funcionario = funcionarios.id_funcionario, clientes, saloes_festa WHERE clientes.id_cliente = reservas.id_cliente AND saloes_festa.id_salao_festas = reservas.id_salao_festas LIMIT $iniciarpaginasalao, $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error()); 

	//Selecionar todos os registros das tabelas clientes, reservas e saloes_festa. Retornar um erro se não há registros na tabela
	$saloes_2 = mysql_query("SELECT clientes.id_cliente, clientes.nome, clientes.sobrenome, reservas.id_reserva, reservas.id_salao_festas, reservas.reserva_data, reservas.reserva_tempo, reservas.flag, saloes_festa.id_salao_festas, saloes_festa.salao_festas_nome, funcionarios.id_funcionario, funcionarios.nome as nome_funcionario, funcionarios.sobrenome as sobrenome_funcionario FROM reservas LEFT OUTER JOIN funcionarios ON reservas.id_funcionario = funcionarios.id_funcionario, clientes, saloes_festa WHERE clientes.id_cliente = reservas.id_cliente AND saloes_festa.id_salao_festas = reservas.id_salao_festas LIMIT ".($iniciarpaginasalao + $regspagina).", $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error()); 
	
	//Selecionar todos os registros das tabelas clientes. Retornar um erro se não há registros na tabela
	$clientes_mesas = mysql_query("SELECT * FROM clientes ORDER BY nome ASC")
	or die("Não há registros para mostrar... \n" . mysql_error()); 
	
	//Selecionar todos os registros das tabelas clientes. Retornar um erro se não há registros na tabela
	$clientes_saloes = mysql_query("SELECT * FROM clientes ORDER BY nome ASC")
	or die("Não há registros para mostrar... \n" . mysql_error()); 
	
	//Selecionar todos os registros das tabelas clientes. Retornar um erro se não há registros na tabela (ALTERAR)
	$clientes_saloes_1 = mysql_query("SELECT * FROM clientes ORDER BY nome ASC")
	or die("Não há registros para mostrar... \n" . mysql_error()); 	
	
	//Selecionar todos os registros das tabelas saloes_festa. Retornar um erro se não há registros na tabela
	$saloes_festa_lista = mysql_query("SELECT * FROM saloes_festa ORDER BY salao_festas_nome ASC")
	or die("Não há registros para mostrar... \n" . mysql_error()); 
	
	//Selecionar todos os registros das tabelas saloes_festa. Retornar um erro se não há registros na tabela (ALTERAR)
	$saloes_festa_lista_1 = mysql_query("SELECT * FROM saloes_festa ORDER BY salao_festas_nome ASC")
	or die("Não há registros para mostrar... \n" . mysql_error()); 
	
	//Selecionar todos os registros das tabelas mesas. Retornar um erro se não há registros na tabela
	$mesas_lista = mysql_query("SELECT * FROM mesas ORDER BY mesa_nome ASC")
	or die("Não há registros para mostrar... \n" . mysql_error()); 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reservas</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
<script language="JavaScript" src="validation/admin.js"></script>
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Gerenciar Reservas </h1>
		<?php require('incluir-menu.php'); ?>
	</div>
	
	
	
	<div id="container">
		<fieldset><legend>Realizar Reservas</legend>
			<table>
				<tr>
					<td style="border-right:black 5px solid;">
						<form name="mesasForm" id="mesasForm" method="post" action="reservas-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return validarMesas(this)">
							<table align="center" width="450" border="1" >
								<CAPTION><h2>RESERVAR UMA MESA</h2></CAPTION>
								<tr>
									<td><b>Cliente:</b></td>
									<td>
										<select name="id_cliente" id="id_cliente">
											<option value="select">- selecione o cliente -
											<?php 
												//loop dos registros da tabela clientes
												while ($row=mysql_fetch_array($clientes_mesas)){
													echo "<option value=$row[id_cliente]>$row[nome] $row[sobrenome]"; 
												}
											?>
										</select>
									</td>
								<tr>
								<tr>
									<td><b>Mesa Nome/Número:</b></td>
									<td>
										<select name="id_mesa" id="id_mesa">
											<option value="select">- selecione a mesa -
											<?php 
												//loop dos registros da tabela saloes_festa
												while ($row=mysql_fetch_array($mesas_lista)){
													echo "<option value=$row[id_mesa]>$row[mesa_nome]"; 
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td><b>Data:</b></td><td><input type="date" name="reserva_data" id="reserva_data" class="formDate" required/></td>
								</tr>
								<tr>
									<td><b>Tempo:</b></td><td><input type="time" name="reserva_tempo" id="reserva_tempo" class="formTime" required/></td>
								</tr>
								<tr bgcolor="#dddddd">
									<td colspan="3" align="center"><input type="submit" value="Reservar"></td>
								</tr>
							</table>
						</form>
					</td>
					<td>
						<form name="salaofestasForm" id="salaofestasForm" method="post" action="reservas-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return validarSalaoFestas(this)">
							<table align="center" width="450" border="1" >
								<CAPTION><h2>RESERVAR SALÃO DE FESTAS</h2></CAPTION>
								<tr>
									<td><b>Cliente:</b></td>
									<td>
										<select name="id_cliente" id="id_cliente">
											<option value="select">- selecione o cliente -
											<?php 
												//loop dos registros da tabela clientes
												while ($row=mysql_fetch_array($clientes_saloes)){
													echo "<option value=$row[id_cliente]>$row[nome] $row[sobrenome]"; 
												}
											?>
										</select>
									</td>
								<tr>
								<tr>
									<td><b>Salão de Festas Nome/Número:</b></td>
									<td>
										<select name="id_salao_festas" id="id_salao_festas">
											<option value="select">- selecione o salão de festas -
											<?php 
												//loop dos registros da tabela saloes_festa
												while ($row=mysql_fetch_array($saloes_festa_lista)){
													echo "<option value=$row[id_salao_festas]>$row[salao_festas_nome]"; 
												}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td><b>Data:</b></td><td><input type="date" name="reserva_data" id="reserva_data" class="formDate" required/></td>
								</tr>
								<tr>
									<td><b>Tempo:</b></td><td><input type="time" name="reserva_tempo" id="reserva_tempo" class="formTime" required/></td>
								</tr>
								<tr bgcolor="#dddddd">
									<td colspan="3" align="center"><input type="submit" value="Reservar"></td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</fieldset>
	
		<!--ALTERAÇÃO-->
		<fieldset><legend>Reservas de Mesas</legend>
			<table border="1" width="955" align="center" style="font-size:12">
			<tr>
				<td class="paginacao" colspan="8" align="right">
					<?php
					//Criar um link "Anterior"
					$prev = $iniciarpaginamesa - $regspagina;
					//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
					if ($prev >= 0)
					echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginamesa='.$prev.'"><-Anterior</a>';
					
					if ($prev >= 0 AND mysql_num_rows($mesas) == $regspagina)
					//Criar um separador
					echo ' | ';
					
					if (mysql_num_rows($mesas) == $regspagina && mysql_num_rows($mesas_2) > 0)
					//Criar um link "Próximo"
					echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginamesa='.($iniciarpaginamesa + $regspagina).'">Próximo-></a>';
					?>
				</td>
			</tr>
			
			<tr class="tituloTabela">
				<th>Cód.</th>
				<th>Cliente</th>
				<th width="145">Nome da Mesa</th>
				<th>Data</th>
				<th>Horário</th>
				<th>Funcionário</th>
				<th>Situação</th>
				<th>Ação(ões)</th>
			</tr>

			<?php
			//loop através de todas as linhas da tabela
			while ($row=mysql_fetch_array($mesas)){ 
				echo '<form name="mesasForm" id="mesasForm" method="post" action="alterar-reserva.php" onsubmit="return validarMesas(this)">';
				echo "<tr>";
					echo "<td align=\"center\">" . $row['id_reserva']."</td>";
					
					//Selecionar todos os registros das tabelas clientes. Retornar um erro se não há registros na tabela (ALTERAR)
					$mesas_clientes = mysql_query("SELECT * FROM clientes ORDER BY nome ASC")
					or die("Não há registros para mostrar... \n" . mysql_error()); 
					
					echo "<td>";
						echo "<select style=\"font-size:11\" name=\"id_cliente\" id=\"id_cliente\">";
							echo "<option value=\"select\">- selecione o cliente -";
								//loop dos registros da tabela clientes
								while ($row_clientes_mesas = mysql_fetch_array($mesas_clientes)){
									echo "<option value=$row_clientes_mesas[id_cliente]";
										if($row_clientes_mesas['id_cliente'] == $row['id_cliente']){
											echo " selected=\"selected\" ";
										}
									echo ">$row_clientes_mesas[nome] $row_clientes_mesas[sobrenome]"; 
								}
						echo "</select>";
					echo "</td>";
					
					//Selecionar todos os registros das tabelas mesas. Retornar um erro se não há registros na tabela (ALTERAR)
					$mesas_lista_1 = mysql_query("SELECT * FROM mesas ORDER BY mesa_nome ASC")
					or die("Não há registros para mostrar... \n" . mysql_error()); 
					
					echo "<td>";
						echo "<select style=\"font-size:11\" name=\"id_mesa\" id=\"id_mesa\">";
							echo "<option value=\"select\">- selecione a mesa -";
								//loop dos registros da tabela mesas
								while ($row_mesas = mysql_fetch_array($mesas_lista_1)){
									echo "<option value=$row_mesas[id_mesa]";
										if($row_mesas['id_mesa'] == $row['id_mesa']){
											echo " selected=\"selected\" ";
										}
									echo ">$row_mesas[mesa_nome]"; 
								}
						echo "</select>";
					echo "</td>";
					
					
					echo "<td><input size=\"7\" name=\"reserva_data\" id=\"reserva_data\" class=\"textfield formDate\" value=\"".date('d/m/Y',strtotime($row['reserva_data']))."\" required/></td>";
					echo "<td><input size=\"5\" name=\"reserva_tempo\" id=\"reserva_tempo\" class=\"textfield formTime\" value=\"".date('H:i:s',strtotime($row['reserva_tempo']))."\" required /></td>";
				
					//Selecionar todos os registros das tabelas funcionarios. Retornar um erro se não há registros na tabela (ALTERAR)
					$saloes_funcionarios = mysql_query("SELECT * FROM funcionarios ORDER BY nome ASC")
					or die("Não há registros para mostrar... \n" . mysql_error()); 
					
					echo "<td>";
						echo "<select style=\"font-size:11\" name=\"id_funcionario\" id=\"id_funcionario\">";
							echo "<option value=\"\">- sel. o funcionário -";
								//loop dos registros da tabela funcionarios
								while ($row_funcionarios = mysql_fetch_array($saloes_funcionarios)){
									echo "<option value=$row_funcionarios[id_funcionario]";
										if($row_funcionarios['id_funcionario'] == $row['id_funcionario']){
											echo " selected=\"selected\" ";
										}
									echo ">$row_funcionarios[nome] $row_funcionarios[sobrenome]"; 
								}
						echo "</select>";
					echo "</td>";
					
					echo "<td>";
						echo "<select style=\"font-size:11\" name=\"flag\" id=\"flag\">";
							echo "<option value=\"\">- sel. a situação -";
								//situações possíveis
								echo "<option value=0";
									if(0 == $row['flag']){
										echo " selected=\"selected\" ";
									}
								echo ">Aguardando análise";
								echo "<option value=1";
									if(1 == $row['flag']){
										echo " selected=\"selected\" ";
									}
								echo ">Reservada";
								echo "<option value=2";
									if(2 == $row['flag']){
										echo " selected=\"selected\" ";
									}
								echo ">Cancelada";		
						echo "</select>";
					echo "</td>";		
					
					echo "<td bgcolor=\"#dddddd\" width=\"145\" align=\"center\">";
						echo "<input type=\"button\" value=\"Remover\" onclick=\"parent.location='remover-reserva.php?id=". $row['id_reserva'] ."'\">";
						echo " ";
						echo "<input type=\"hidden\" name=\"id_reserva\" value=\"".$row['id_reserva']."\" />";
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
					$prev = $iniciarpaginamesa - $regspagina;
					//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
					if ($prev >= 0)
					echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginamesa='.$prev.'"><-Anterior</a>';
					
					if ($prev >= 0 AND mysql_num_rows($mesas) == $regspagina)
					//Criar um separador
					echo ' | ';
					
					if (mysql_num_rows($mesas) == $regspagina && mysql_num_rows($mesas_2) > 0)
					//Criar um link "Próximo"
					echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginamesa='.($iniciarpaginamesa + $regspagina).'">Próximo-></a>';
					?>
				</td>
			</tr>
			</table>
		</fieldset>
		<hr>
		
		<fieldset><legend>Reservas de Salões de Festas</legend>
			<table border="1" width="955" align="center" style="font-size:12">
			<tr>
				<td class="paginacao" colspan="8" align="right">
					<?php
					//Criar um link "Anterior"
					$prev = $iniciarpaginasalao - $regspagina;
					//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
					if ($prev >= 0)
					echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginasalao='.$prev.'"><-Anterior</a>';
					
					if ($prev >= 0 AND mysql_num_rows($saloes) == $regspagina)
					//Criar um separador
					echo ' | ';
					
					if (mysql_num_rows($saloes) == $regspagina && mysql_num_rows($saloes_2) > 0)
					//Criar um link "Próximo"
					echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginasalao='.($iniciarpaginasalao + $regspagina).'">Próximo-></a>';
					?>
				</td>
			</tr>
			
			<tr class="tituloTabela">
				<th>Cód.</th>
				<th>Cliente</th>
				<th width="145">Nome do Salão de Festas</th>
				<th>Data</th>
				<th>Horário</th>
				<th>Funcionário</th>
				<th>Situação</th>
				<th>Ação(ões)</th>
			</tr>

			<?php
			//loop através de todas as linhas da tabela
			while ($row = mysql_fetch_array($saloes)){ 
				echo '<form name="saloesForm" id="saloesForm" method="post" action="alterar-reserva.php" onsubmit="return validarSaloes(this)">';
				echo "<tr>";
					echo "<td align=\"center\">" . $row['id_reserva']."</td>";
					
					//Selecionar todos os registros das tabelas clientes. Retornar um erro se não há registros na tabela (ALTERAR)
					$saloes_clientes = mysql_query("SELECT * FROM clientes ORDER BY nome ASC")
					or die("Não há registros para mostrar... \n" . mysql_error()); 
					
					echo "<td>";
						echo "<select style=\"font-size:11\" name=\"id_cliente\" id=\"id_cliente\">";
							echo "<option value=\"select\">- selecione o cliente -";
								//loop dos registros da tabela clientes
								while ($row_clientes_saloes = mysql_fetch_array($saloes_clientes)){
									echo "<option value=$row_clientes_saloes[id_cliente]";
										if($row_clientes_saloes['id_cliente'] == $row['id_cliente']){
											echo " selected=\"selected\" ";
										}
									echo ">$row_clientes_saloes[nome] $row_clientes_saloes[sobrenome]"; 
								}
						echo "</select>";
					echo "</td>";
					
					//Selecionar todos os registros das tabelas saloes. Retornar um erro se não há registros na tabela (ALTERAR)
					$saloes_lista_1 = mysql_query("SELECT * FROM saloes_festa ORDER BY salao_festas_nome ASC")
					or die("Não há registros para mostrar... \n" . mysql_error()); 
					
					echo "<td>";
						echo "<select style=\"font-size:11\" name=\"id_salao_festas\" id=\"id_salao_festas\">";
							echo "<option value=\"select\">- sel. o salão de festas -";
								//loop dos registros da tabela saloes
								while ($row_saloes = mysql_fetch_array($saloes_lista_1)){
									echo "<option value=$row_saloes[id_salao_festas]";
										if($row_saloes['id_salao_festas'] == $row['id_salao_festas']){
											echo " selected=\"selected\" ";
										}
									echo ">$row_saloes[salao_festas_nome]"; 
								}
						echo "</select>";
					echo "</td>";
					
					echo "<td><input size=\"7\" name=\"reserva_data\" id=\"reserva_data\" class=\"textfield formDate\" value=\"".date('d/m/Y',strtotime($row['reserva_data']))."\" required/></td>";
					echo "<td><input size=\"5\" name=\"reserva_tempo\" id=\"reserva_tempo\" class=\"textfield formTime\" value=\"".date('H:i:s',strtotime($row['reserva_tempo']))."\" required /></td>";
					
					//Selecionar todos os registros das tabelas funcionarios. Retornar um erro se não há registros na tabela (ALTERAR)
					$saloes_funcionarios = mysql_query("SELECT * FROM funcionarios ORDER BY nome ASC")
					or die("Não há registros para mostrar... \n" . mysql_error()); 
					
					echo "<td>";
						echo "<select style=\"font-size:11\" name=\"id_funcionario\" id=\"id_funcionario\">";
							echo "<option value=\"\">- sel. o funcionário -";
								//loop dos registros da tabela funcionarios
								while ($row_funcionarios = mysql_fetch_array($saloes_funcionarios)){
									echo "<option value=$row_funcionarios[id_funcionario]";
										if($row_funcionarios['id_funcionario'] == $row['id_funcionario']){
											echo " selected=\"selected\" ";
										}
									echo ">$row_funcionarios[nome] $row_funcionarios[sobrenome]"; 
								}
						echo "</select>";
					echo "</td>";
					
					echo "<td>";
						echo "<select style=\"font-size:11\" name=\"flag\" id=\"flag\">";
							echo "<option value=\"\">- sel. a situação -";
								//situações possíveis
								echo "<option value=0";
									if(0 == $row['flag']){
										echo " selected=\"selected\" ";
									}
								echo ">Aguardando análise";
								echo "<option value=1";
									if(1 == $row['flag']){
										echo " selected=\"selected\" ";
									}
								echo ">Reservada";
								echo "<option value=2";
									if(2 == $row['flag']){
										echo " selected=\"selected\" ";
									}
								echo ">Cancelada";		
						echo "</select>";
					echo "</td>";					
					
					echo "<td bgcolor=\"#dddddd\" width=\"145\" align=\"center\">";
						echo "<input type=\"button\" value=\"Remover\" onclick=\"parent.location='remover-reserva.php?id=". $row['id_reserva'] ."'\">";
						echo " ";
						echo "<input type=\"hidden\" name=\"id_reserva\" value=\"".$row['id_reserva']."\" />";
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
					$prev = $iniciarpaginasalao - $regspagina;
					//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
					if ($prev >= 0)
					echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginasalao='.$prev.'"><-Anterior</a>';
					
					if ($prev >= 0 AND mysql_num_rows($saloes) == $regspagina)
					//Criar um separador
					echo ' | ';
					
					if (mysql_num_rows($saloes) == $regspagina && mysql_num_rows($saloes_2) > 0)
					//Criar um link "Próximo"
					echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginasalao='.($iniciarpaginasalao + $regspagina).'">Próximo-></a>';
					?>
				</td>
			</tr>
			</table>
		</fieldset>
		
		<hr>
	</div>
	
	<?php
		mysql_free_result($mesas);
		mysql_free_result($saloes);
		mysql_close($link);
	?>	

	<?php require('incluir-rodape.php'); ?>
	
</div>
</body>
</html>