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
	//Verificar se a variável da linha de partida foi passado na URL ou não
	if (!isset($_GET['iniciarpagina']) or !is_numeric($_GET['iniciarpagina'])) {
		//Inserir o valor da linha de partida para 0 porque nada foi encontrado em URL
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
	
	//Recuperar categorias da tabela categories
	$resultado = mysql_query("SELECT * FROM categorias LIMIT $iniciarpagina, $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error());
	
	//Recuperar categorias da tabela categories
	$resultado_2 = mysql_query("SELECT * FROM categorias LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Categorias</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Gestão de categorias</h1>
		<?php require('incluir-menu.php'); ?>
	</div>
	
	<div id="container">
		<fieldset><legend>Nova Categoria</legend>
		<table width="320" align="center">
			<form name="categoriasForm" id="categoriasForm" action="categorias-exec.php" method="post" onsubmit="return validarCategorias(this)">
				<tr>
					<th>Nome</th>
					<th>Ação(ões)</th>
				</tr>
				<tr>
					<td><input type="text" name="categoria_nome" class="textfield" maxlength="15" placeholder="Nome da categoria" required/></td>
					<input type="hidden" name="pagina" value="categoria" />
					<td align="center"><input type="submit" name="Submit" value="Adicionar" /></td>
				</tr>
			</form>
		</table>
		</fieldset>
		<hr>
		<fieldset><legend>Categorias disponíveis</legend>
		<table width="530" align="center" border="1">
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
				<th>Nome da Categoria</th>
				<th>Ação(ões)</th>
			</tr>

			<?php
				//Loop através de todas as linhas da tabela
				while ($row = mysql_fetch_array($resultado)){
					echo "<form name=\"categoriasForm\" id=\"categoriasForm\" action=\"alterar-categoria.php\" method=\"post\" onsubmit=\"return validarCategorias(this)\">";
					echo "<tr>";
						echo "<td><input type=\"text\" name=\"categoria_nome\" class=\"textfield\" maxlength=\"15\" placeholder=\"Nome da categoria\" value=\"". $row['categoria_nome'] ."\" required/></td>";
						echo "<td bgcolor=\"#dddddd\" width=\"145\" align=\"center\">";
							echo "<input type=\"button\" value=\"Remover\" onclick=\"parent.location='remover-categoria.php?id=". $row['id_categoria'] ."'\">";
							echo " ";
							echo "<input type=\"hidden\" name=\"id_categoria\" value=\"".$row['id_categoria']."\" />";
							echo "<input type=\"hidden\" name=\"pagina\" value=\"categorias\" />";
							echo "<input type=\"submit\" name=\"Alterar\" value=\"Alterar\" />";
						echo "</td>";
					echo "</tr>";
					echo "</form>";
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