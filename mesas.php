<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
    require_once('auth.php');
	require_once('admin/conteudo-site.php');
	require_once('js/jscSis.php');
?>
<?php
	//Verificar se a variável da linha de partida foi passado na URL ou não
	if (!isset($_GET['iniciarpagina']) or !is_numeric($_GET['iniciarpagina'])) {
		//Dar o valor da linha de partida para 0 porque nada foi encontrado em URL
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
	
	//Obter id_cliente da sessão
	$id_cliente = $_SESSION['SESS_MEMBER_ID'];

    //Recuperar mesas da tabela mesas
    $mesas=mysql_query("SELECT * FROM mesas")
    or die("Algo está errado... \n" . mysql_error());
	
	//Recuperar reservas de mesas da tabela reservas limitando para paginação
	$flag_1 = 1;
	$resultado = mysql_query("SELECT * FROM reservas, mesas WHERE reservas.id_mesa = mesas.id_mesa AND id_cliente = '$id_cliente' AND flag_mesa = '$flag_1' ORDER BY reserva_data DESC LIMIT $iniciarpagina, $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error());

	$resultado_2 = mysql_query("SELECT * FROM reservas, mesas WHERE reservas.id_mesa = mesas.id_mesa AND id_cliente = '$id_cliente' AND flag_mesa = '$flag_1' ORDER BY reserva_data DESC LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error());
	
	//Recuperar moeda da tabela moedas 
	//Definir um valor padrão para flag_1
    $flag_1 = 1;
    $moedas = mysql_query("SELECT * FROM moedas WHERE flag = '$flag_1'")
    or die("Ocorreu um problema... \n" . "Nossa equipe está trabalhando nisso neste momento... \n" . "Por favor, volte depois de algumas horas.");	
	
	// Recuperar taxa de Reserva de Mesa
	// definir um valor padrão para flag_entrega
    $flag_reserva = 'Reserva de Mesa';
    $taxas = mysql_query("SELECT * FROM taxas WHERE taxa_descricao = '$flag_reserva'")
    or die("Ocorreu um problema... \n" . "Nossa equipe está trabalhando nisso neste momento... \n" . "Por favor, volte depois de algumas horas.");	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $nome ?>:Mesas</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
</script>
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	
	<div id="center">
		<h1>RESERVAR MESA(S)</h1>
		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<?php require('/incluir-menu.php'); ?>
			
			<p>&nbsp;</p>
			
			<?php echo $descricao_mesas; ?>
			
			<?php
				$simbolo = mysql_fetch_assoc($moedas); //obter moeda ativa
				$taxa_reserva = mysql_fetch_assoc($taxas); //obter taxa de entrega
				if(mysql_num_rows($taxas) > 0 && $taxa_reserva['taxa_valor'] > 0){
					echo "<div align=\"center\" style=\"color:red;\"><b>Atenção</b> a taxa para reserva por mesa é:  ".$simbolo['moeda_simbolo']." ".number_format($taxa_reserva['taxa_valor'],2,',','.')."</div>";
				}
			?>
			
			<hr>
			
			<form name="mesaForm" id="mesaForm" method="post" action="reservas-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return validarMesa(this)">
				<table align="center" border="1" width="500">
					<CAPTION><h2>RESERVAR UMA MESA</h2></CAPTION>
					<tr>
						<td><b>Mesa Nome/Número:</b></td>
						<td>
							<select name="id_mesa" id="id_mesa">
								<option value="select">- selecione uma mesa -
								<?php 
									//loop através de linhas da tabela mesas
									while ($row=mysql_fetch_array($mesas)){
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
						<td><b>Horário:</b></td><td><input type="time" name="reserva_tempo" id="reserva_tempo" class="formTime" required/>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type="submit" value="Solicitar Reserva"></td>
					</tr>
				</table>
			</form>
			
				<br/><br/>
				
				<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
					<table width="800" border="1" align="center" style="text-align:center;">
					<CAPTION><h3>MESAS RESERVADAS POR VOCÊ</h3></CAPTION>
					<tr>
						<td class="paginacao" colspan="5" align="right">
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
							<th>Cód. da Reserva</th>
							<th>Nome Mesa</th>
							<th>Data Início</th>
							<th>Data Fim</th>
							<th>Situação</th>
					</tr>
						<?php
							while ($row = mysql_fetch_assoc($resultado)){
								echo "<tr>";
									echo "<td>" . $row['id_reserva']."</td>";
									echo "<td>" . $row['mesa_nome']."</td>";
									echo "<td>" . date('d/m/Y',strtotime($row['reserva_data']))."</td>";
									echo "<td>" . date('H:i:s',strtotime($row['reserva_tempo']))."</td>";
									echo "<td>";
										if($row['flag'] == 0){
											echo "Aguardando análise";
										}else if($row['flag'] == 1){
											echo "Reservada";
										}else{
											echo "Cancelada";
										}
									echo "</td>";
								echo "</tr>";
							}
						?>
					<tr>
						<td class="paginacao" colspan="5" align="right">
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
		    </div>
			<br/>
		</div>
	</div>

	<?php 	
		mysql_free_result($resultado);
		mysql_close($link);
	?>
	
	<?php require('/incluir-rodape.php'); ?>
</div>
</body>
</html>