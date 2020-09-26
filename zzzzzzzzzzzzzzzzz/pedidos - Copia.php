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
 
	//Selecionar todos os registros de quase todas as tabelas. Retornou um erro se não há registros nas tabelas
	$resultado = mysql_query("SELECT clientes.id_cliente, clientes.nome, clientes.sobrenome, enderecos.endereco, enderecos.cidade, enderecos.cep, enderecos.celular, pedidos.*, comidas.*, carrinhos.*, quantidades.*, formas_pagto.*, funcionarios.nome as nome_funcionario, funcionarios.sobrenome as sobrenome_funcionario FROM pedidos LEFT OUTER JOIN formas_pagto ON pedidos.id_forma_pagto = formas_pagto.id_forma_pagto LEFT OUTER JOIN funcionarios ON pedidos.id_funcionario = funcionarios.id_funcionario, clientes, enderecos, quantidades, comidas, carrinhos WHERE clientes.id_cliente = pedidos.id_cliente AND enderecos.id_endereco = pedidos.id_endereco AND pedidos.id_pedido = carrinhos.id_pedido AND carrinhos.id_comida = comidas.id_comida AND carrinhos.id_quantidade = quantidades.id_quantidade ORDER BY pedidos.id_pedido DESC LIMIT $iniciarpagina, $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error()); 
	
	//Recuperar moeda da tabela moedas 
	//Definir um valor padrão para flag_1
    $flag_1 = 1;
    $moedas = mysql_query("SELECT * FROM moedas WHERE flag = '$flag_1'")
    or die("Ocorreu um problema... \n" . "Nossa equipe está trabalhando nisso neste momento... \n" . "Por favor, volte depois de algumas horas.");

	//Recuperar taxa de entrega
	//Definir um valor padrão para flag_entrega
    $flag_entrega = 'Entrega';
    $taxas = mysql_query("SELECT * FROM taxas WHERE taxa_descricao = '$flag_entrega'")
    or die("Ocorreu um problema... \n" . "Nossa equipe está trabalhando nisso neste momento... \n" . "Por favor, volte depois de algumas horas.");	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pedidos em Andamento</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Gerenciar Pedidos em Andamento</h1>
		<?php require('incluir-menu.php'); ?>
	</div>
	
	<div id="container">
	<fieldset><legend>Lista de Pedidos em Andamento</legend>
	
		<?php
			$simbolo = mysql_fetch_assoc($moedas); //obter moeda ativa
			$taxa_entrega = mysql_fetch_assoc($taxas); //obter taxa de entrega
			echo "<p style=\"color:red;\"><b>Taxa de entrega:</b>  ".$simbolo['moeda_simbolo']." ".number_format($taxa_entrega['taxa_valor'],2,',','.')."</p>";
		?>
	
		<table border="1" width="945" align="center" style="font-size:10px">
		<tr>
			<td colspan="13" align="right">
				<?php
				//Criar um link "Anterior"
				$prev = $iniciarpagina - $regspagina;
				//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpagina='.$prev.'"><-Anterior</a>';
				
				if ($prev >= 0 AND mysql_num_rows($resultado) == $regspagina)
				//Criar um separador
				echo ' | ';
				
				if (mysql_num_rows($resultado) == $regspagina)
				//Criar um link "Próximo"
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpagina='.($iniciarpagina + $regspagina).'">Próximo-></a>';
				?>
			</td>
		</tr>
		
		<tr>
		<th>Cód. Pedido</th>
		<th>Nome do cliente</th>
		<th>Nome da comida</th>
		<th>Preço da comida</th>
		<th>QTD</th>
		<th>Forma de pagamento</th>
		<th>Custo Total</th>
		<th>Data de entrega</th>
		<th>Endereço de entrega</th>
		<th>Nº celular</th>
		<th>Funcionário</th>
		<th>Situação</th>
		<th>Ação(ões)</th>
		</tr>

		<?php
		//loop através de todas as linhas de tabelas
		while ($row = mysql_fetch_assoc($resultado)){
			
			if($id_pedido_anterior != $row['id_pedido']){
				$nova_linha = 1;
				//obter somatório de comidas por pedidos
				$comidasPedidos = mysql_query("SELECT count(1) as contador, pedidos.id_cliente, pedidos.id_pedido, SUM(comidas.comida_preco) as soma_preco, SUM(quantidades.quantidade_valor), ROUND((SUM(comidas.comida_preco * quantidades.quantidade_valor)),2) as soma_total FROM pedidos, carrinhos, comidas, quantidades WHERE carrinhos.id_pedido = pedidos.id_pedido AND carrinhos.id_comida = comidas.id_comida AND carrinhos.id_quantidade = quantidades.id_quantidade AND pedidos.id_cliente = '$row[id_cliente]' AND pedidos.id_pedido = '$row[id_pedido]' group by pedidos.id_cliente, pedidos.id_pedido")
				or die("Algo está errado... \n" . mysql_error()); 	
				$row2=mysql_fetch_array($comidasPedidos);
			}else{
				$nova_linha = 0;
			}
			
			$id_pedido_anterior = $row['id_pedido'];
			
			echo "<tr>";
			
			if($nova_linha==1){
					echo "<td colspan=\"13\" style=\"background:black;\">";
					echo "</td>";
				echo '</tr>';
				echo '<tr>';
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo $row['id_pedido'];
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo $row['nome']."\t".$row['sobrenome'];
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
					echo $simbolo['moeda_simbolo']."".number_format($row2['soma_total'] + $taxa_entrega['taxa_valor'],2,',','.');
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo date('d/m/Y',strtotime($row['data_entrega']))." ".date('H:i:s',strtotime($row['horario_entrega']));
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo $row['endereco']." ".$row['cidade']." ".$row['cep'];
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo $row['celular'];
				echo "</td>";

				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo $row['nome_funcionario']."\t".$row['sobrenome_funcionario'];
				echo "</td>";
				
				echo "<td align=\"center\" rowspan=\"".$row2['contador']."\">"; 
					echo $row['flag'] == 0 ? "Pendente" : ($row['flag'] == 1 ? "Em entrega" : "Concluído");
				echo "</td>";
				
				echo "<td align=\"center\" rowspan=\"".$row2['contador']."\">"; 
					echo "<p> <a href=\"remover-pedido.php?id=" . $row['id_pedido'] . "\">Remover</a> </p>";
					if($row['flag'] == 1){
						echo "<hr/> <p> <a href=\"finalizar-pedido.php?id=" . $row['id_pedido'] . "\">Finalizar Pedido</a></p>";
					}
				echo "</td>";
			}
			
			echo "</tr>";
		}
		?>
		</table>
		
		<table border="1" width="945" align="center" style="font-size:11px">
			<tr>
				<td colspan="13" style="background:black;">
				</td>
			</tr>
			
			<tr>
				<td colspan="13" align="right">
					<?php
					//Criar um link "Anterior"
					$prev = $iniciarpagina - $regspagina;
					//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
					if ($prev >= 0)
					echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpagina='.$prev.'"><-Anterior</a>';
					
					if ($prev >= 0 AND mysql_num_rows($resultado) == $regspagina)
					//Criar um separador
					echo ' | ';
					
					if (mysql_num_rows($resultado) == $regspagina)
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