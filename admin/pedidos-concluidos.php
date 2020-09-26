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

	//Função para formatar data timestamp
	function formDate($data){
		$timestamp = explode(" ",$data);
		$getData = $timestamp[0];
		$getTime = $timestamp[1];
		
		$setData = explode('/',$getData);
		$dia = $setData[0];
		$mes = $setData[1];
		$ano = $setData[2];
		
		$res = checkdate($mes,$dia,$ano);
		if ($res != 1){
		   die ('A data foi passada em um formato inválido!');
		}
		
		if(!$getTime):
			$getTime = date('H:i:s');
		endif;

		$resultado = $ano.'-'.$mes.'-'.$dia.' '.$getTime;
		
		return $resultado;
	}
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
 
	//Selecionar registros de pedidos concluídos. Retornar um erro se não há registros nas tabelas
 	if (isset($_POST['PesquisarCliente'])){
		$resultado = mysql_query("SELECT pedidos_concluidos.*, itens_pedidos.* FROM pedidos_concluidos, itens_pedidos WHERE nome_completo_cliente LIKE '%$_POST[nomeCliente]%' AND pedidos_concluidos.id_pedido_concluido = itens_pedidos.id_pedido_concluido ORDER BY pedidos_concluidos.id_pedido_concluido DESC LIMIT $iniciarpagina, $regspagina")
		or die("Não há registros para mostrar... \n" . mysql_error());
		
		$resultado_2 = mysql_query("SELECT pedidos_concluidos.*, itens_pedidos.* FROM pedidos_concluidos, itens_pedidos WHERE nome_completo_cliente LIKE '%$_POST[nomeCliente]%' AND pedidos_concluidos.id_pedido_concluido = itens_pedidos.id_pedido_concluido ORDER BY pedidos_concluidos.id_pedido_concluido DESC LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
		or die("Não há registros para mostrar... \n" . mysql_error());
	}else if(isset($_POST['PesquisarDatas'])){
		$resultado = mysql_query("SELECT pedidos_concluidos.*, itens_pedidos.* FROM pedidos_concluidos, itens_pedidos WHERE data_horario_entrega BETWEEN '".formDate($_POST[data_horario_entrega1])."' AND '".formDate($_POST[data_horario_entrega2])."' AND pedidos_concluidos.id_pedido_concluido = itens_pedidos.id_pedido_concluido ORDER BY pedidos_concluidos.id_pedido_concluido DESC LIMIT $iniciarpagina, $regspagina")
		or die("Não há registros para mostrar... \n" . mysql_error());
		
		$resultado_2 = mysql_query("SELECT pedidos_concluidos.*, itens_pedidos.* FROM pedidos_concluidos, itens_pedidos WHERE data_horario_entrega BETWEEN '".formDate($_POST[data_horario_entrega1])."' AND '".formDate($_POST[data_horario_entrega2])."' AND pedidos_concluidos.id_pedido_concluido = itens_pedidos.id_pedido_concluido ORDER BY pedidos_concluidos.id_pedido_concluido DESC LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
		or die("Não há registros para mostrar... \n" . mysql_error()); 
	}else{
		$resultado = mysql_query("SELECT pedidos_concluidos.*, itens_pedidos.* FROM pedidos_concluidos, itens_pedidos WHERE pedidos_concluidos.id_pedido_concluido = itens_pedidos.id_pedido_concluido ORDER BY pedidos_concluidos.id_pedido_concluido DESC LIMIT $iniciarpagina, $regspagina")
		or die("Não há registros para mostrar... \n" . mysql_error());
		
		$resultado_2 = mysql_query("SELECT pedidos_concluidos.*, itens_pedidos.* FROM pedidos_concluidos, itens_pedidos WHERE pedidos_concluidos.id_pedido_concluido = itens_pedidos.id_pedido_concluido ORDER BY pedidos_concluidos.id_pedido_concluido DESC LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
		or die("Não há registros para mostrar... \n" . mysql_error()); 
	}
	
	//Recuperar moeda da tabela moedas 
	//Definir um valor padrão para flag_1
    $flag_1 = 1;
    $moedas = mysql_query("SELECT * FROM moedas WHERE flag = '$flag_1'")
    or die("Ocorreu um problema... \n" . "Nossa equipe está trabalhando nisso neste momento... \n" . "Por favor, volte depois de algumas horas.");

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pedidos Concluídos</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Gerenciar Pedidos Concluídos</h1>
		<?php require('incluir-menu.php'); ?>
	</div>
	
	<div id="container">
		<fieldset><legend>Pesquisar Pedidos Concluídos por Cliente</legend>
		<table width="680" align="center">
			<form name="pesqPedidosConcluidosForm" id="pesqPedidosConcluidosForm" action="pedidos-concluidos.php" method="post" onsubmit="return this">
				<tr>
					<th>Nome</th>
					<th>Ação(ões)</th>
				</tr>
				<tr>
					<td align="center"><input size="40" type="text" name="nomeCliente" class="textfield" maxlength="25" placeholder="Parte do Nome e/ou Sobrenome do cliente"/></td>
					<td align="center" width="275">
						<input type="submit" name="Limpar" value="Limpar Filtro da Pesquisa" />
						<input type="submit" name="PesquisarCliente" value="Pesquisar" />
					</td>
				</tr>
			</form>
		</table>
		</fieldset>
		
		<hr>
	
		<fieldset><legend>Pesquisar Pedidos Concluídos por Data e Horário</legend>
		<table width="680" align="center">
			<form name="pesqPedidosConcluidosForm" id="pesqPedidosConcluidosForm" action="pedidos-concluidos.php" method="post" onsubmit="return this">
				<tr>
					<th>Data de Entrega Inicial</th>
					<th>Data de Entrega Final</th>
					<th>Ação(ões)</th>
				</tr>
				<tr>
					<td align="center"><input size="29" type="date" name="data_horario_entrega1" id="data_horario_entrega1" class="textfield formDateTime" placeholder="Data e Horário p/ início da pesquisa"/></td>
					<td align="center"><input size="29" type="date" name="data_horario_entrega2" id="data_horario_entrega2" class="textfield formDateTime" placeholder="Data e Horário p/ fim da pesquisa"/></td>
					<td align="center" width="275">
						<input type="submit" name="Limpar" value="Limpar Filtro da Pesquisa" />
						<input type="submit" name="PesquisarDatas" value="Pesquisar" />
					</td>
				</tr>
			</form>
		</table>
		</fieldset>	
	
		<hr>
	
		<fieldset><legend>Lista de Pedidos Concluídos</legend>
		
			<?php
				$simbolo = mysql_fetch_assoc($moedas); //obter moeda ativa
			?>
		
			<table border="1" width="945" align="center" style="font-size:10px">
			<tr>
				<td class="paginacao" colspan="13" align="right">
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
				<th>Cód. Pedido</th>
				<th>Nome do cliente</th>
				<th>Nome da comida</th>
				<th>Preço da comida</th>
				<th>QTD</th>
				<th>Forma de pagamento</th>
				<th>Taxa de entrega</th>
				<th>Custo Total</th>
				<th>Data de entrega</th>
				<th>Endereço de entrega</th>
				<th>Nº celular / telefone</th>
				<th>Funcionário</th>
				<th>Ação(ões)</th>
			</tr>

			<?php
			//loop através de todas as linhas de tabelas
			while ($row = mysql_fetch_assoc($resultado)){
				
				if($id_pedido_anterior != $row['id_pedido_concluido']){
					$nova_linha = 1;
					//obter somatório de itens dos pedidos concluídos
					$itensPedidos = mysql_query("SELECT count(1) as contador FROM itens_pedidos WHERE itens_pedidos.id_pedido_concluido = '$row[id_pedido_concluido]'")
					or die("Algo está errado... \n" . mysql_error()); 	
					$row2=mysql_fetch_array($itensPedidos);
				}else{
					$nova_linha = 0;
				}
				
				$id_pedido_anterior = $row['id_pedido_concluido'];
				
				echo "<tr>";
				
				if($nova_linha==1){
						echo "<td colspan=\"13\" style=\"background:black;\">";
						echo "</td>";
					echo '</tr>';
					echo '<tr>';
					
					echo "<td rowspan=\"".$row2['contador']."\">"; 
						echo $row['id_pedido_concluido'];
					echo "</td>";
					
					echo "<td rowspan=\"".$row2['contador']."\">"; 
						echo $row['nome_completo_cliente'];
					echo "</td>";
				}

				echo "<td>" . $row['comida_nome']."</td>";
				echo "<td>" . $simbolo['moeda_simbolo']."".number_format($row['comida_preco'],2,',','.')."</td>";
				echo "<td>" . $row['quantidade_valor']."</td>";
				
				if($nova_linha==1){
					echo "<td rowspan=\"".$row2['contador']."\">"; 
						echo $row['forma_pagto_descricao'];
					echo "</td>";
					
					echo "<td rowspan=\"".$row2['contador']."\">"; 
						echo $simbolo['moeda_simbolo']."".number_format($row['taxa_entrega'],2,',','.');
					echo "</td>";				
					
					echo "<td rowspan=\"".$row2['contador']."\">"; 
						echo $simbolo['moeda_simbolo']."".number_format($row['custo_total'],2,',','.');
					echo "</td>";
					
					echo "<td rowspan=\"".$row2['contador']."\">"; 
						echo date('d/m/Y H:i:s',strtotime($row['data_horario_entrega']));
					echo "</td>";
					
					echo "<td rowspan=\"".$row2['contador']."\">"; 
						echo $row['endereco_completo'];
					echo "</td>";
					
					echo "<td rowspan=\"".$row2['contador']."\">"; 
						echo $row['celular']."<hr>".$row['telefone'];
					echo "</td>";

					echo "<td rowspan=\"".$row2['contador']."\">"; 
						echo $row['nome_completo_funcionario'];
					echo "</td>";
					
					echo "<td bgcolor=\"#dddddd\" align=\"center\" rowspan=\"".$row2['contador']."\">"; 
						echo "<p> <a href=\"remover-pedido-concluido.php?id=" . $row['id_pedido_concluido'] . "\">Remover</a> </p>";
					echo "</td>";
				}
				
				echo "</tr>";
			}
			?>
			</table>
			
			<table border="1" width="945" align="center" style="font-size:11px">
				<tr>
					<td class="paginacao" colspan="13" style="background:black;">
					</td>
				</tr>
				
				<tr>
					<td class="paginacao" colspan="13" align="right">
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

	<?php 
		mysql_free_result($resultado);
		mysql_close($link);
	?>
	
	<?php require('incluir-rodape.php'); ?>
	
</div>
</body>
</html>