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
	
    if (isset($_GET['id']))
    {
        //Obter o valor id
        $id_pedido = $_GET['id'];
    }
    else
    //Se o id não está definido, redirecionar de volta para as comidas
    {
        die("Pedido não selecionado!");
    }
 
	//Selecionar todos os registros de quase todas as tabelas. Retornar um erro se não há registros nas tabelas
	$resultado = mysql_query("SELECT clientes.id_cliente, clientes.nome, clientes.sobrenome, enderecos.endereco, enderecos.cidade, enderecos.cep, enderecos.celular, enderecos.telefone, pedidos.*, comidas.*, carrinhos.*, quantidades.*, formas_pagto.*, funcionarios.nome as nome_funcionario, funcionarios.sobrenome as sobrenome_funcionario FROM pedidos LEFT OUTER JOIN formas_pagto ON pedidos.id_forma_pagto = formas_pagto.id_forma_pagto LEFT OUTER JOIN funcionarios ON pedidos.id_funcionario = funcionarios.id_funcionario, clientes, enderecos, quantidades, comidas, carrinhos WHERE clientes.id_cliente = pedidos.id_cliente AND enderecos.id_endereco = pedidos.id_endereco AND pedidos.id_pedido = carrinhos.id_pedido AND carrinhos.id_comida = comidas.id_comida AND carrinhos.id_quantidade = quantidades.id_quantidade AND pedidos.id_pedido = $id_pedido ORDER BY pedidos.id_pedido DESC")
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
<title>Pedido Selecionado</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
</head>
<body>
<div id="page" style="width:785px;">
	<div id="header">
		<h1>Visualização do pedido</h1>
	</div>
	
	<div id="container" style="width:770px;">
	<fieldset><legend>Lista de Pedidos em Andamento</legend>
	
		<?php
			$simbolo = mysql_fetch_assoc($moedas); //obter moeda ativa
			$taxa_entrega = mysql_fetch_assoc($taxas); //obter taxa de entrega
			# echo "<p style=\"color:red;\"><b>Taxa de entrega:</b>  ".$simbolo['moeda_simbolo']." ".number_format($taxa_entrega['taxa_valor'],2,',','.')."</p>";
		?>
	
		<table border="1" width="755" align="center" style="font-size:8.5; border-collapse:collapse;">
		
		<tr class="tituloTabela">
			<th>Cód.</th>
			<th>Nome do cliente</th>
			<th>Nome da comida</th>
			<th>Preço da comida</th>
			<th>QTD</th>
			<th>Forma de pagto</th>
			<th>Custo Total</th>
			<th>Data do pedido</th>
			<th>Horário do pedido</th>
			<th>Endereço de entrega</th>
			<th>Nº celular / telefone</th>
			<th>Situação</th>
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
					echo "<td colspan=\"14\" style=\"background:black;\">";
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
			
			//Recuperar quantidades da tabela quantidades
			$quantidades = mysql_query("SELECT * FROM quantidades")
			or die("Não há registros para mostrar... \n" . mysql_error());
			
			echo "<td>"; 
				echo $row['quantidade_valor'];
			echo "</td>";

			if($nova_linha==1){
				
				//Recuperar formas_pagto da tabela formas_pagto
				$formas_pagto = mysql_query("SELECT * FROM formas_pagto")
				or die("Não há registros para mostrar... \n" . mysql_error()); 
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
						//Loop através de linhas da tabela formas_pagto
						while ($row_forma_pagto = mysql_fetch_array($formas_pagto)){
							if($row_forma_pagto['id_forma_pagto'] == $row['id_forma_pagto']){
								echo">$row_forma_pagto[forma_pagto_descricao]"; 
							}
						}
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo $simbolo['moeda_simbolo']."".number_format($row2['soma_total'] + $taxa_entrega['taxa_valor'],2,',','.');
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo date('d/m/Y',strtotime($row['data_entrega']));
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo date('H:i:s',strtotime($row['horario_entrega']));
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo $row['endereco']." ".$row['cidade']." ".$row['cep'];
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo $row['celular']." <hr> ".$row['telefone'];
				echo "</td>";
				
				echo "<td align=\"center\" rowspan=\"".$row2['contador']."\">"; 
					echo $row['flag'] == 0 ? "Pendente" : ($row['flag'] == 1 ? "Em entrega" : "Concluído");
				echo "</td>";
			}
			echo "</tr>";
		}
		?>
		</table>
	</fieldset>
	
	<hr>
	
	</div>

	<?php 
		mysql_free_result($resultado);
		mysql_close($link);
	?>
	
</div>
</body>
</html>