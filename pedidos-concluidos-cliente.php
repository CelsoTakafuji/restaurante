﻿<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
    require_once('auth.php');
	require_once('admin/conteudo-site.php');
?>
<?php
	//Verificar se a variável da linha de partida foi passado na URL ou não
	if (!isset($_GET['iniciarpagina']) or !is_numeric($_GET['iniciarpagina'])) {
		//o valor da linha de partida será 0 (zero) porque nada foi encontrado em URL
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
	
	//Obter id_cliente da sessão
	$id_cliente=$_SESSION['SESS_MEMBER_ID'];

	//Selecionar todos os registros de tabelas para compor os pedidos. Retornar um erro se não houver registros na tabela
	$resultado=mysql_query("SELECT pedidos_concluidos.*, itens_pedidos.* FROM pedidos_concluidos, itens_pedidos WHERE pedidos_concluidos.id_cliente = '$id_cliente' AND pedidos_concluidos.id_pedido_concluido = itens_pedidos.id_pedido_concluido ORDER BY pedidos_concluidos.id_pedido_concluido DESC LIMIT $iniciarpagina, $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error()); 

	//Selecionar todos os registros de tabelas para compor os pedidos. Retornar um erro se não houver registros na tabela
	$resultado_2=mysql_query("SELECT pedidos_concluidos.*, itens_pedidos.* FROM pedidos_concluidos, itens_pedidos WHERE pedidos_concluidos.id_cliente = '$id_cliente' AND pedidos_concluidos.id_pedido_concluido = itens_pedidos.id_pedido_concluido ORDER BY pedidos_concluidos.id_pedido_concluido DESC LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error());

	//Recuperar uma moeda da tabela moedas
	//Definir um valor padrão para flag_1
    $flag_1 = 1;
    $moedas = mysql_query("SELECT * FROM moedas WHERE flag = '$flag_1'")
    or die("Ocorreu um problema... \n" . "Nossa equipe está trabalhando nisso neste momento... \n" . "Por favor, volte depois de algumas horas."); 
	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $nome ?>:Minha Conta</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
</script>
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	
	<div id="center">
		<!--<h1>Bem vindo <?php echo $_SESSION['SESS_FIRST_NAME'];?></h1>-->
		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<?php require('/incluir-menu.php'); ?>
			<p>&nbsp;</p>
			
			<?php echo $descricao_pedidos_concluidos; ?>
			
			<hr>

			<table border="0" width="900" align="center" style="text-align:center;">
				<CAPTION><h2>Histórico de pedidos concluídos</h2></CAPTION>
			</table>
			
			<?php
				$simbolo = mysql_fetch_assoc($moedas); //obter moeda ativa
			?>
			
			<br/>
			
			<table border="1" width="900" align="center" style="text-align:center;">
					<tr>
						<td class="paginacao" colspan="10" align="right">
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
						<th>Código do Pedido</th>
						<th>Foto da comida</th>
						<th>Nome da comida</th>
						<th>Categoria da comida</th>
						<th>Preço</th>
						<th>Quantidade</th>
						<th>Data de entrega</th>
						<th>Forma de Pagamento</th>
						<th>Taxa de Entrega</th>
						<th>Custo Total</th>
						<!--<th>Ação(ões)</th>-->
					</tr>

				<?php
					
					//Loop através de todas as linhas da tabela
					while ($row=mysql_fetch_array($resultado)){
						$contador++;
						if($id_pedido_anterior != $row['id_pedido_concluido'] ){
							$nova_linha = 1;
							//Obter somatório de itens por pedidos concluídos
							$itensPedidos = mysql_query("SELECT count(1) as contador FROM itens_pedidos WHERE itens_pedidos.id_pedido_concluido = '$row[id_pedido_concluido]'")
							or die("Algo está errado... \n" . mysql_error()); 	
							
							$row2=mysql_fetch_array($itensPedidos);
						}else{
							$nova_linha = 0;
						}
						
						$id_pedido_anterior = $row['id_pedido_concluido'];
						
						echo "<tr>";
						
						if($nova_linha==1){
								echo "<td colspan=\"10\" style=\"background:black;\">";
								echo "</td>";
							echo '</tr>';
							echo '<tr>';
							
							echo "<td rowspan=\"".$row2['contador']."\">"; 
								echo $row['id_pedido_concluido'];
							echo "</td>";
						}
						
						echo '<td><a href=images/'. $row['comida_foto']. ' alt="clique para ver a imagem completa" target="_blank"><img src=images/'. $row['comida_foto']. ' width="80" height="70"></a></td>';
						echo "<td>".$row['comida_nome']."</td>";
						echo "<td>".$row['categoria_nome']."</td>";
						echo "<td>".$simbolo['moeda_simbolo']. "" . $row['comida_preco']."</td>";
						echo "<td>".$row['quantidade_valor']."</td>";
						
						if($nova_linha==1){
							echo "<td rowspan=\"".$row2['contador']."\">"; 
								echo date('d/m/Y H:i:s',strtotime($row['data_horario_entrega']));
							echo "</td>";

							echo "<td rowspan=\"".$row2['contador']."\">"; 
								echo $row['forma_pagto_descricao'];
							echo "</td>";
							
							echo "<td rowspan=\"".$row2['contador']."\">"; 
								echo $simbolo['moeda_simbolo']."".number_format($row['taxa_entrega'],2,',','.');
							echo "</td>";	

							echo "<td rowspan=\"".$row2['contador']."\">"; 
								echo $simbolo['moeda_simbolo']."".number_format($row['custo_total'],2,',','.');
							echo "</td>";
							
						}
						
						echo "</tr>";
					}
				?>

			</table>
			<table border="1" width="900" align="center" style="text-align:center;">
					<tr>
						<td colspan="10" style="background:black;">
						</td>
					</tr>
					<tr>
						<td class="paginacao" colspan="10" align="right">
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
	</div>
	
	<?php 
		mysql_free_result($resultado);
		mysql_close($link);
	?>
	
	<?php require('/incluir-rodape.php'); ?>
	
</div>
</body>
</html>
