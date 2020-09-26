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
?>
<?php
	//Verificar se a variável da linha de partida foi passado na URL ou não
	if (!isset($_GET['iniciarpagina']) or !is_numeric($_GET['iniciarpagina'])) {
		//O valor da linha de partida será 0 (zero) porque nada foi encontrado em URL
		$iniciarpagina = 0;
	//Caso contrário, será considerado o valor da URL
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
        die("Não foi possível selecionar banco de dados");
    }
	
	//obter member_id da sessão
	$id_cliente = $_SESSION['SESS_MEMBER_ID'];
?>
<?php
	//Recuperar todas as linhas da tabela mensagens com base na flag = 0 e limite para págiinação
    $resultado = mysql_query("SELECT * FROM mensagens WHERE mensagem_flag = '$flag_0' and id_cliente IN (0, $id_cliente) LIMIT $iniciarpagina, $regspagina")
    or die("Algo está errado... \n" . mysql_error());
	
	//Recuperar todas as linhas da tabela mensagens com base na flag = 0 e limite para págiinação
    $resultado_2 = mysql_query("SELECT * FROM mensagens WHERE mensagem_flag = '$flag_0' and id_cliente IN (0, $id_cliente) LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
    or die("Algo está errado... \n" . mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $nome ?>:Caixa de Entrada</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
</script>
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	
	<div id="center">
		<h1>MENSAGENS</h1>
		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<?php require('/incluir-menu.php'); ?>
			<p>&nbsp;</p>
			<?php echo $descricao_caixa_entrada; ?>
			<hr>
			<table width="900" border="1" align="center" style="text-align:center;">
			<CAPTION><h2>CAIXA DE ENTRADA</h2></CAPTION>
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
					<th>De</th>
					<th>Data de recebimento</th>
					<th>Tempo recebido</th>
					<th>Assunto</th>
					<th>Mensagem</th>
				</tr>

				<?php
					//loop através de todas as linhas da tabela
					while ($row=mysql_fetch_array($resultado)){
					echo "<tr>";
					echo "<td>" . $row['mensagem_de']."</td>";
					echo "<td>" . $row['mensagem_data']."</td>";
					echo "<td>" . $row['mensagem_tempo']."</td>";
					echo "<td>" . $row['mensagem_assunto']."</td>";
					echo "<td width='350' align='left'>" . $row['mensagem_texto']."</td>";
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
	</div>

	<?php
		mysql_free_result($resultado);
		mysql_close($link);
	?>
	
	<?php require('/incluir-rodape.php'); ?>
	
</div>
</body>
</html>