<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	require_once('admin/conteudo-site.php');
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
	
	//Recuperar promoções da tabela promocoes
	$resultado = mysql_query("SELECT * FROM promocoes LIMIT $iniciarpagina, $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error());
	
	//Recuperar promoções da tabela promocoes
	$resultado_2 = mysql_query("SELECT * FROM promocoes LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error());
?>
<?php
	//Recuperar uma moeda da tabela moedas 
	//Definir um valor padrão para flag_1
    $flag_1 = 1;
    $moedas=mysql_query("SELECT * FROM moedas WHERE flag = '$flag_1'")
    or die("Ocorreu um problema ... \n "." Nossa equipe está trabalhando nisso no momento ... \n "." Por favor, volte depois de algumas horas."); 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $nome ?>:Ofertas Especiais</title>
<script type="text/javascript" src="swf/swfobject.js"></script>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>

	<div id="center">

		<h1>OFERTAS ESPECIAIS</h1>
		<hr>
		<?php echo $descricao_promocao; ?>
		<h3>Nota: Para realizar o seu pedido, por favor, vá para a Zona de Alimentação e escolha Promoções na lista de categorias.</h3>
		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<table width="900" border="1" align="center" style="text-align:center;">
			<CAPTION><h3>OFERTAS ESPECIAIS</h3></CAPTION>
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
					<th>Foto Promoção</th>
					<th>Nome Promoção</th>
					<th>Descrição Promoção</th>
					<th>Data Início</th>
					<th>Data Fim</th>
					<th>Preço Promocional</th>
			</tr>
				<?php
					$symbol=mysql_fetch_assoc($moedas); //obter moeda ativa
					while ($row=mysql_fetch_assoc($resultado)){
						echo "<tr>";
						echo '<td><a href=images/'. $row['promocao_foto']. ' alt="click to view full image" target="_blank"><img src=images/'. $row['promocao_foto']. ' width="80" height="70"></a></td>';
						echo "<td>" . $row['promocao_nome']."</td>";
						echo "<td width='250' align='left'>" . $row['promocao_descricao']."</td>";
						echo "<td>" . date('d/m/Y',strtotime($row['promocao_data_inicio']))."</td>";
						echo "<td>" . date('d/m/Y',strtotime($row['promocao_data_fim']))."</td>";
						echo "<td>" . $symbol['moeda_simbolo']. "" . $row['promocao_preco']."</td>";
						echo "</td>";
						echo "</tr>";
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
