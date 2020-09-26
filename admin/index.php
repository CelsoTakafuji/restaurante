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
    
    //Definir o valor padrão para a flag
    $flag_1 = 1;
	$flag_2 = 2;
    
    //Definir variáveis globais
    $qry="";
    $excellent_qry="";
    $good_qry="";
    $average_qry="";
    $bad_qry="";
    $worse_qry="";
    
	//Contar o número de registros nas tabelas clientes, pedidos e reservas 
	$clientes=mysql_query("SELECT * FROM clientes")
	or die("Não há registros para contar... \n" . mysql_error()); 

	$pedidos=mysql_query("SELECT * FROM pedidos")
	or die("Não há registros para contar... \n" . mysql_error());

	$pedidos_alocados=mysql_query("SELECT * FROM pedidos WHERE id_funcionario > 0") //WHERE flag='$flag_1'
	or die("Não há registros para contar... \n" . mysql_error());	
	
	$pedidos_processados=mysql_query("SELECT * FROM pedidos_concluidos ") //WHERE flag='$flag_1'
	or die("Não há registros para contar... \n" . mysql_error());

	$mesas_reservedas=mysql_query("SELECT * FROM reservas WHERE flag_mesa='$flag_1' AND flag!='$flag_2'")
	or die("Não há registros para contar... \n" . mysql_error());

	$saloes_festas_reservados=mysql_query("SELECT * FROM reservas WHERE flag_salao_festas='$flag_1' AND flag!='$flag_2'")
	or die("Não há registros para contar... \n" . mysql_error());

	$mesas_alocadas=mysql_query("SELECT * FROM reservas WHERE flag='$flag_1' AND flag_mesa='$flag_1'")
	or die("Não há registros para contar... \n" . mysql_error());

	$saloes_festa_alocados=mysql_query("SELECT * FROM reservas WHERE flag='$flag_1' AND flag_salao_festas='$flag_1'")
	or die("Não há registros para contar... \n" . mysql_error());

	//Obter detalhes dos alimentos através da tabela comidas
	$comidas=mysql_query("SELECT * FROM comidas")
	or die("Algo está errado... \n" . mysql_error());
?>
<?php
    if(isset($_POST['Submit'])){
		//Função para limpar os valores recebidos do formulário. Impede SQL Injection
        function limpar($str) {
            $str = @trim($str);
            if(get_magic_quotes_gpc()) {
                $str = stripslashes($str);
            }
            return mysql_real_escape_string($str);
        }
        //Obter id da categoria
        $id_comida = limpar($_POST['id_comida']);
        
        //Obter id de classificações
        $classificacoes=mysql_query("SELECT * FROM classificacoes")
        or die("Algo está errado... \n" . mysql_error());
		
        //Selecionar todos os registros das tabelas comidas e avaliacoes de acordo com o id. Retornar um erro se não há registros na tabela
        $qry=mysql_query("SELECT * FROM comidas, avaliacoes WHERE avaliacoes.id_comida='$id_comida' AND comidas.id_comida='$id_comida'")
        or die("Algo está errado... \n" . mysql_error());
		
        $no_rate_qry=mysql_query("SELECT * FROM comidas WHERE id_comida='$id_comida'")
        or die("Algo está errado... \n" . mysql_error());
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Página Inicial de Administração</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Painel de Controle do Administrador</h1>
		<?php require('incluir-menu.php'); ?>
	</div>
	
	<div id="container">
		<fieldset><legend>Status atual</legend>
		<table width="930" align="center" style="text-align:center; font-size:12px;">
			<tr>
				<th>Clientes registrados</th>
				<th>Pedidos</th>
				<th>Pedidos alocados</th>
				<th>Pedidos não alocados</th>
				<th>Pedidos processados (Histórico)</th> 
				<th>Mesas reservadas</th>
				<th>Mesas alocadas</th>
				<th>Mesas pendentes</th>
				<th>Salões de Festas reservados</th>
				<th>Salões de Festas alocados</th>
				<th>Salões de Festas pendentes</th>    
			</tr>

			<?php
				$result1=mysql_num_rows($clientes);
				$result2=mysql_num_rows($pedidos);
				$result3=mysql_num_rows($pedidos_alocados);
				$result4=$result2-$result3; //obter pedido(s) pendente(s)
				$result5=mysql_num_rows($pedidos_processados);
				$result6=mysql_num_rows($mesas_reservedas);
				$result7=mysql_num_rows($mesas_alocadas);
				$result8=$result6-$result7; //obter mesa(s) pendente(s)
				$result9=mysql_num_rows($saloes_festas_reservados);
				$result10=mysql_num_rows($saloes_festa_alocados);
				$result11=$result9-$result10; //obter salão(ões) de festa pendente(s)
				echo "<tr align=>";
					echo "<td>" . $result1."</td>";
					echo "<td>" . $result2."</td>";
					echo "<td>" . $result3."</td>";
					echo "<td>" . $result4."</td>";
					echo "<td>" . $result5."</td>";
					echo "<td>" . $result6."</td>";
					echo "<td>" . $result7."</td>";
					echo "<td>" . $result8."</td>";
					echo "<td>" . $result9."</td>";
					echo "<td>" . $result10."</td>";
					echo "<td>" . $result11."</td>";
				echo "</tr>";
			?>
			</table>
			</fieldset>
			
			<hr>
			
			<fieldset><legend>Avaliações dos clientes (100%)</legend>
			<form name="comidaAvaliacaoForm" id="comidaAvaliacaoForm" method="post" action="index.php" onsubmit="return validarAvaliacaoComida(this)">
				<table width="360" align="center">
					 <tr>
						<td>Comida</td>
						<td width="168">
						<select name="id_comida" id="id_comida">
							<option value="select">- selecione a comida -
							<?php 
								//loop através de linhas da tabela comidas
								while ($row=mysql_fetch_array($comidas)){
									echo "<option value=$row[id_comida]>$row[comida_nome]"; 
								}
							?>
							<option value="selectAll">MOSTRAR TODAS!
						</select>
						</td>
						<td><input type="submit" name="Submit" value="Mostrar Pontuações" /></td>
					 </tr>
				</table>
			</form>
			
		
			
			<table width="900" align="center">
			<?php
				if(isset($_POST['Submit']) && $id_comida != 'selectAll'){
					//taxas percentuais
					$total_valor=mysql_num_rows($qry);
					
					if($total_valor != 0){
						$row=mysql_fetch_array($qry);
						$comida_nome=$row['comida_nome'];
						
						echo "<tr>";
							echo "<th></th>";
							//loop através de linhas da tabela classificacoes
							while ($rowClassificacao = mysql_fetch_array($classificacoes)){
								echo "<th>$rowClassificacao[classificacao_nome]</th>";
								$i++;
								$queryclassificacoes = mysql_query("SELECT * FROM comidas, avaliacoes WHERE avaliacoes.id_comida='$id_comida' AND comidas.id_comida='$id_comida' AND avaliacoes.id_classificacao='$rowClassificacao[id_classificacao]'")
								or die("Algo está errado... \n" . mysql_error());
								
								$valorExibicao = mysql_num_rows($queryclassificacoes);
								$arrayClassificacao[$i] = $valorExibicao."(". round($valorExibicao/$total_valor*100, 2)."%)";
							}
						echo "</tr>";
						
						echo "<tr>";
							echo "<th align=\"left\">" .$comida_nome."</th>";
							foreach($arrayClassificacao as $rat){
								echo "<td align=\"center\">" .$rat."</td>";
							}
						echo "</tr>";
					}else{
						if(mysql_num_rows($no_rate_qry) != 0){
							$contTotalClassificacoes = 0;
							$row=mysql_fetch_array($no_rate_qry);
							
							$comida_nome=$row['comida_nome'];
							
							$classificacoesZero=mysql_query("SELECT * FROM classificacoes")
							or die("Algo está errado... \n" . mysql_error());
					
							echo "<tr>";
								echo "<th></th>";
								//loop através de linhas da tabela ratings
								while ($rowClassificacao = mysql_fetch_array($classificacoesZero)){
									$contTotalClassificacoes++;
									echo "<th>$rowClassificacao[classificacao_nome]</th>";
								}
							echo "</tr>";
							
							echo "<tr>";
								echo "<th align=\"left\">$comida_nome</th>";
								for($contClassificacoes = 0; $contClassificacoes < $contTotalClassificacoes; $contClassificacoes++){
									echo "<tdalign=\"center\">0(0%)</td>";
								}
							echo "</tr>";
						}
					}
				}else if (!isset($_POST['Submit']) || $id_comida == 'selectAll'){
					$comidasAll=mysql_query("SELECT * FROM comidas")
					or die("Algo está errado... \n" . mysql_error());
					
					while ($rowComida = mysql_fetch_array($comidasAll)){
						$i = 0;
						$cont++;
						
						$qryAll=mysql_query("SELECT * FROM comidas, avaliacoes WHERE avaliacoes.id_comida='$rowComida[id_comida]' AND comidas.id_comida='$rowComida[id_comida]'")
						or die("Algo está errado... \n" . mysql_error());
						
						$no_rate_qryAll=mysql_query("SELECT * FROM comidas WHERE id_comida='$rowComida[id_comida]'")
						or die("Algo está errado... \n" . mysql_error());        //Obter id de classificações
						
						//taxas percentuais
						$total_valor=mysql_num_rows($qryAll);
						
						if($total_valor != 0){
							$row=mysql_fetch_array($qryAll);
							$comida_nome=$row['comida_nome'];
							
							echo "<tr>";
								echo "<th></th>";
								
								$classificacoesAll=mysql_query("SELECT * FROM classificacoes")
								or die("Algo está errado... \n" . mysql_error());
								
								//loop através de linhas da tabela classificacoes
								while ($rowClassificacao = mysql_fetch_array($classificacoesAll)){
									$i++;
									
									if($cont == 1){
										echo "<th>$rowClassificacao[classificacao_nome]</th>";
									}

									$queryclassificacoesAll = mysql_query("SELECT * FROM comidas, avaliacoes WHERE avaliacoes.id_comida='$rowComida[id_comida]' AND comidas.id_comida='$rowComida[id_comida]' AND avaliacoes.id_classificacao='$rowClassificacao[id_classificacao]'")
									or die("Algo está errado... \n" . mysql_error());

									$valorExibicao = mysql_num_rows($queryclassificacoesAll);
									$arrayClassificacaoAll[$i] = $valorExibicao."(". round($valorExibicao/$total_valor*100, 2)."%)";
								}
								
							echo "</tr>";
							
							echo "<tr>";
								echo "<th align=\"left\">" .$comida_nome."</th>";
								foreach($arrayClassificacaoAll as $ratAll){
									echo "<td align=\"center\">" .$ratAll."</td>";
								}
							echo "</tr>";
						}else{
							$contTotalclassificacoes = 0;
							$row=mysql_fetch_array($no_rate_qryAll);
							$comida_nome=$row['comida_nome'];
							$classificacoesZero=mysql_query("SELECT * FROM classificacoes")
							or die("Algo está errado... \n" . mysql_error());
					
							echo "<tr>";
								echo "<th></th>";
								//loop através de linhas da tabela classificacoes
								while ($rowClassificacao = mysql_fetch_array($classificacoesZero)){
									$contTotalclassificacoes++;
									if($cont == 1){
										echo "<th>$rowClassificacao[classificacao_nome]</th>";
									}
								}
							echo "</tr>";
							
							echo "<tr>";
								echo "<th align=\"left\">$comida_nome</th>";
								for($contclassificacoes = 0; $contclassificacoes < $contTotalclassificacoes; $contclassificacoes++){
									echo "<td align=\"center\">0(0%)</td>";
								}
							echo "</tr>";
						}
					}
				}

			?>
			</table>
			</fieldset>
			<hr>
	</div>
	
	<?php require('incluir-rodape.php'); ?>
	
</div>
</body>
</html>
