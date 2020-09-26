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
	
	//obter memberId da sessão
	$id_cliente = $_SESSION['SESS_MEMBER_ID']; 

	//selecionar todos os registros da tabela comidas. Retornar um erro se não há registros na tabela
	$comidas=mysql_query("SELECT * FROM comidas")
	or die("Ocorreu um erro. \n Nossa equipe está trabalhando nisso. \n Tente novamente depois de algumas horas.");

	//selecionar todos os registros da tabela classificacoes. Retornar um erro se não há registros na tabela
	$classificacoes=mysql_query("SELECT * FROM classificacoes")
	or die("Ocorreu um erro. \n Nossa equipe está trabalhando nisso. \n Tente novamente depois de algumas horas.");
	
	//Recuperar avaliações da tabela avaliacoes limitando para páginação
	$resultado = mysql_query("SELECT * FROM avaliacoes, classificacoes, comidas WHERE avaliacoes.id_comida = comidas.id_comida AND avaliacoes.id_classificacao = classificacoes.id_classificacao AND avaliacoes.id_cliente = '$id_cliente' ORDER BY avaliacoes.id_comida DESC LIMIT $iniciarpagina, $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error());
	
	$resultado_2 = mysql_query("SELECT * FROM avaliacoes, classificacoes, comidas WHERE avaliacoes.id_comida = comidas.id_comida AND avaliacoes.id_classificacao = classificacoes.id_classificacao AND avaliacoes.id_cliente = '$id_cliente' ORDER BY avaliacoes.id_comida DESC LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error()); 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $nome ?>:Classificação</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
</script>
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	
	<div id="center">
		<h1>NOS AVALIE</h1>
		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<?php require('/incluir-menu.php'); ?>
			<p>&nbsp;</p>
			<?php echo $descricao_avaliacao; ?>
			<hr>
			<form name="avaliacaoForm" id="avaliacaoForm" method="post" action="avalie-nos-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return validarAvaliacao(this)">
				<table align="center" border="1" width="500">
					<CAPTION><h2>AVALIE NOSSOS PRATOS</h2></CAPTION>
						<tr>
							<th>Comida</th>
							<td>
								<select name="id_comida" id="id_comida">
									<option value="select">- selecione a comida -
									<?php 
									//loop através das linhas da tabela comidas
									while ($row=mysql_fetch_array($comidas)){
										echo "<option value=$row[id_comida]>$row[comida_nome]"; 
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th>Escala</th>
							<td>
								<select name="id_classificacao" id="id_classificacao">
									<option value="select">- selecione a escala -
									<?php 
									//loop através das linhas da tabela classificacoes
									while ($row=mysql_fetch_array($classificacoes)){
										echo "<option value=$row[id_classificacao]>$row[classificacao_nome]"; 
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input type="submit" name="enviarAvaliacao" value="Classificar" /></td>
						</tr>
				</table>
			</form>
			<br/>
		</div>
		
		<br/><br/>
		
		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<table width="800" border="1" align="center" style="text-align:center;">
			<CAPTION><h3>AVALIAÇÕES FEITAS POR VOCÊ</h3></CAPTION>
			<tr>
				<td class="paginacao" colspan="2" align="right">
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
				<th>Nome da comida</th>
				<th>Classificação</th>
			</tr>
				<?php
					while ($row=mysql_fetch_assoc($resultado)){
						echo "<tr>";
						echo "<td>" . $row['comida_nome']."</td>";
						echo "<td>" . $row['classificacao_nome']."</td>";
						echo "</tr>";
					}
				?>
			<tr>
				<td class="paginacao" colspan="2" align="right">
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
			<br/>
		</div>
		<br/>
		
	</div>

	<?php
		mysql_free_result($resultado);
		mysql_close($link);
	?>

	<?php require('/incluir-rodape.php'); ?>
	
</div>
</body>
</html>