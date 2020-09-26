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
 
	//Selecionar todos os registros de quase todas as tabelas. Retornar um erro se não há registros nas tabelas
	$resultado = mysql_query("SELECT clientes.id_cliente, clientes.nome, clientes.sobrenome, enderecos.endereco, enderecos.cidade, enderecos.cep, enderecos.celular, enderecos.telefone, pedidos.*, comidas.*, carrinhos.*, quantidades.*, formas_pagto.*, funcionarios.nome as nome_funcionario, funcionarios.sobrenome as sobrenome_funcionario FROM pedidos LEFT OUTER JOIN formas_pagto ON pedidos.id_forma_pagto = formas_pagto.id_forma_pagto LEFT OUTER JOIN funcionarios ON pedidos.id_funcionario = funcionarios.id_funcionario, clientes, enderecos, quantidades, comidas, carrinhos WHERE clientes.id_cliente = pedidos.id_cliente AND enderecos.id_endereco = pedidos.id_endereco AND pedidos.id_pedido = carrinhos.id_pedido AND carrinhos.id_comida = comidas.id_comida AND carrinhos.id_quantidade = quantidades.id_quantidade ORDER BY pedidos.id_pedido DESC LIMIT $iniciarpagina, $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error()); 

	//Selecionar todos os registros de quase todas as tabelas. Retornar um erro se não há registros nas tabelas
	$resultado_2 = mysql_query("SELECT clientes.id_cliente, clientes.nome, clientes.sobrenome, enderecos.endereco, enderecos.cidade, enderecos.cep, enderecos.celular, enderecos.telefone, pedidos.*, comidas.*, carrinhos.*, quantidades.*, formas_pagto.*, funcionarios.nome as nome_funcionario, funcionarios.sobrenome as sobrenome_funcionario FROM pedidos LEFT OUTER JOIN formas_pagto ON pedidos.id_forma_pagto = formas_pagto.id_forma_pagto LEFT OUTER JOIN funcionarios ON pedidos.id_funcionario = funcionarios.id_funcionario, clientes, enderecos, quantidades, comidas, carrinhos WHERE clientes.id_cliente = pedidos.id_cliente AND enderecos.id_endereco = pedidos.id_endereco AND pedidos.id_pedido = carrinhos.id_pedido AND carrinhos.id_comida = comidas.id_comida AND carrinhos.id_quantidade = quantidades.id_quantidade ORDER BY pedidos.id_pedido DESC LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
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
<link rel="icon" type="image/png" href="../ico/chave.png" />
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Gerenciar Pedidos em Andamento</h1>
		<?php require('incluir-menu.php'); ?>
	</div>
	
	<div id="container" style="margin-left:-55px; width:1090px;">
	<fieldset><legend>Lista de Pedidos em Andamento</legend>
	
		<?php
			$simbolo = mysql_fetch_assoc($moedas); //obter moeda ativa
			$taxa_entrega = mysql_fetch_assoc($taxas); //obter taxa de entrega
			# echo "<p style=\"color:red;\"><b>Taxa de entrega:</b>  ".$simbolo['moeda_simbolo']." ".number_format($taxa_entrega['taxa_valor'],2,',','.')."</p>";
		?>
		
		<p style="color:red;"><b>Atenção:</b>
		   <ul style="color:red;">
			   <li>Ao alterar a quantidade para 0 (zero) a comida será removida do pedido. Caso no pedido não haja comida o pedido será excluído.
			   </li>
			   <li>Só é possível alterar "um pedido" ou "uma quantidade do pedido" por vez.
			   </li>
			   <li>Não é possível alterar o nome da comida e o preço da comida, pois isso afetaria outros pedidos.
			   </li>
			   <li>Também não é possível alterar o nome, o endereço e os telefones do cliente. Caso seja necessário deverá ser feito na tela: "<a href="clientes.php">Clientes</a>".
			   </li>
			   <li>Taxa de Entrega: Para cada pedido será cobrada a taxa no valor de <?php echo $simbolo['moeda_simbolo']." ".number_format($taxa_entrega['taxa_valor'],2,',','.'); ?>.
			   </li>
			   <li>Custo Total: Para cada comida do pedido soma-se (preço da comida * quantidade). Por fim soma-se a taxa de entrega (<?php echo $simbolo['moeda_simbolo']." ".number_format($taxa_entrega['taxa_valor'],2,',','.'); ?>).
			   </li>
			   <li>Finalizar Pedido: Ao finalizar um pedido, ele poderá ser visualizado na tela "<a href="pedidos-concluidos.php">Pedidos (F)</a>".
			   </li>
		   </ul>
		</p>
	
		<table border="1" width="1070" align="center" style="font-size:8.5; border-collapse:collapse;">
		<tr>
			<td class="paginacao" colspan="14" align="right">
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
			<th>Nome do cliente</th>
			<th>Nome da comida</th>
			<th width="54">Preço da comida</th>
			<th width="68">QTD</th>
			<th>Forma de pagto</th>
			<th>Custo Total</th>
			<th>Data do pedido</th>
			<th>Horário do pedido</th>
			<th>Endereço de entrega</th>
			<th>Nº celular / telefone</th>
			<th>Funcionário</th>
			<th>Situação</th>
			<th>Ação(ões)</th>
		</tr>

		<?php
		//loop através de todas as linhas de tabelas
		while ($row = mysql_fetch_assoc($resultado)){
			echo '<form name="pedidosForm" id="pedidosForm" action="alterar-pedido.php" method="post" enctype="multipart/form-data"  onsubmit="return this">';
			
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
			echo "<input type=\"hidden\" name=\"id_pedido\" value=\"".$row['id_pedido']."\" />";
			echo "<input type=\"hidden\" name=\"id_comida\" value=\"".$row['id_comida']."\" />";
			#echo "<td>" . $row['comida_nome']."</td>";
			echo "<td><textarea style=\"background-color:#fff6f3; border: 1px solid;\" readonly=\"readonly\" name=\"comida_nome\" class=\"textfield\" rows=\"2\" cols=\"7\" maxlength=\"25\" placeholder=\"Nome da comida\" required>".$row['comida_nome']."</textarea></td>";
			#echo "<td>" . $simbolo['moeda_simbolo']."".number_format($row['comida_preco'],2,',','.')."</td>";
			echo "<td>".$simbolo['moeda_simbolo']."<input style=\"font-size:8.5; background-color:#fff6f3; border: 1px solid;\" size=\"4\" readonly=\"readonly\" type=\"text\" name=\"comida_preco\" value=\"".number_format($row['comida_preco'],2,',','.')."\" /></td>";
			
			//Recuperar quantidades da tabela quantidades
			$quantidades = mysql_query("SELECT * FROM quantidades")
			or die("Não há registros para mostrar... \n" . mysql_error());
			
			echo "<td>"; 
					# echo $row['quantidade_valor'];
					
					echo "<select style=\"vertical-align:top; font-size:8.5;\" name=\"id_quantidade\" id=\"id_quantidade\">";
						echo "<option value=\"\">- qtd -";
							//Loop através de linhas da tabela quantidades
							while ($row_qtd = mysql_fetch_array($quantidades)){
								echo "<option value=$row_qtd[id_quantidade]";
								if($row_qtd['id_quantidade'] == $row['id_quantidade']){
									echo " selected=\"selected\" ";
								}
								echo">$row_qtd[quantidade_valor]"; 
							}
					echo "</select>";

					echo "&nbsp;";
					echo "<input type=\"submit\" name=\"AlterarItem\" value=\"\" style=\"width:17; height:17; background:url(../ico/act_alt.png) no-repeat; border:1px solid; cursor:pointer;\" title=\"alterar quantidade\" />";
			echo "</td>";

			if($nova_linha==1){
				
				//Recuperar formas_pagto da tabela formas_pagto
				$formas_pagto = mysql_query("SELECT * FROM formas_pagto")
				or die("Não há registros para mostrar... \n" . mysql_error()); 
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					 echo "<select name=\"id_forma_pagto\" id=\"id_forma_pagto\" style=\"font-size:8.5\">";
						echo "<option value=\"\">- sel. a forma pagto -";
							//Loop através de linhas da tabela formas_pagto
							while ($row_forma_pagto = mysql_fetch_array($formas_pagto)){
								echo "<option value=$row_forma_pagto[id_forma_pagto]";
								if($row_forma_pagto['id_forma_pagto'] == $row['id_forma_pagto']){
									echo " selected=\"selected\" ";
								}
								echo">$row_forma_pagto[forma_pagto_descricao]"; 
							}
					echo "</select>";
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo $simbolo['moeda_simbolo']."".number_format($row2['soma_total'] + $taxa_entrega['taxa_valor'],2,',','.');
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo "<input style=\"font-size:8.5; background-color:#ffffff;\" size=\"7\" name=\"data_entrega\" id=\"data_entrega\" class=\"textfield formDate\" value=\"".date('d/m/Y',strtotime($row['data_entrega']))."\" required/>";
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">";
					echo "<input style=\"font-size:8.5; background-color:#ffffff;\" style=\"font-size:8.5;\" size=\"5\" name=\"horario_entrega\" id=\"horario_entrega\" class=\"textfield formTime\" value=\"".date('H:i:s',strtotime($row['horario_entrega']))."\" required/>";
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo $row['endereco']." ".$row['cidade']." ".$row['cep'];
				echo "</td>";
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					echo $row['celular']." <hr> ".$row['telefone'];
				echo "</td>";
				
				//Recuperar funcionarios da tabela funcionarios
				$funcionarios = mysql_query("SELECT * FROM funcionarios")
				or die("Não há registros para mostrar... \n" . mysql_error()); 
				
				echo "<td rowspan=\"".$row2['contador']."\">"; 
					 echo "<select name=\"id_funcionario\" id=\"id_funcionario\" style=\"font-size:8.5\">";
						echo "<option value=\"\">- sel. o funcionario -";
							//Loop através de linhas da tabela funcionarios
							while ($row_funcionario = mysql_fetch_array($funcionarios)){
								echo "<option value=$row_funcionario[id_funcionario]";
								if($row_funcionario['id_funcionario'] == $row['id_funcionario']){
									echo " selected=\"selected\" ";
								}
								echo">$row_funcionario[nome] $row_funcionario[sobrenome]"; 
							}
					echo "</select>";
				echo "</td>";
				
				echo "<td align=\"center\" rowspan=\"".$row2['contador']."\">"; 
					echo $row['flag'] == 0 ? "Pendente" : ($row['flag'] == 1 ? "Em entrega" : "Concluído");
				echo "</td>";
				
				echo "<td bgcolor=\"#dddddd\" align=\"center\" rowspan=\"".$row2['contador']."\">";
					echo "<input type=\"button\" value=\"Remover\" onclick=\"parent.location='remover-pedido.php?id=". $row['id_pedido'] ."'\">";
					echo "<hr style=\"border:2px solid; margin-top:10; margin-bottom:10;\">";
					#echo "<input type=\"hidden\" name=\"id_pedido\" value=\"".$row['id_pedido']."\" />";
					echo "<input type=\"submit\" name=\"Alterar\" value=\"Alterar\" />";
					if($row['flag'] == 1){
						echo "<hr style=\"border:2px solid; margin-top:10; margin-bottom:10;\">";
						echo "<input type=\"button\" value=\"Finalizar Pedido\" onclick=\"parent.location='finalizar-pedido.php?id=". $row['id_pedido'] ."'\">";
					}
				echo "</td>";
			}
			echo "</tr>";
			echo "</form>";
		}
		?>
		</table>
		
		<table border="1" width="1070" align="center" style="font-size:8.5; border-collapse:collapse;">
			<tr>
				<td colspan="14" style="background:black;">
				</td>
			</tr>
			
			<tr>
				<td class="paginacao" colspan="14" align="right">
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