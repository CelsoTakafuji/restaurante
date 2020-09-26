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
	
	//Configurar charset do banco de dados
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');	
	
    //Recuperar alimentos das tabelas comidas e categorias
    $resultado = mysql_query("SELECT * FROM comidas, categorias WHERE comidas.id_categoria = categorias.id_categoria LIMIT $iniciarpagina, $regspagina")
    or die("Não há registros para mostrar... \n" . mysql_error()); 

    //Recuperar alimentos das tabelas comidas e categorias
    $resultado_2 = mysql_query("SELECT * FROM comidas, categorias WHERE comidas.id_categoria = categorias.id_categoria LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
    or die("Não há registros para mostrar... \n" . mysql_error()); 	
	
	//Recuperar categorias da tabela categorias
    $categorias = mysql_query("SELECT * FROM categorias")
    or die("Não há registros para mostrar... \n" . mysql_error()); 

	//Recuperar uma moeda da tabela moedas
	//Definir um valor padrão para flag_1
    $flag_1 = 1;
    $moedas = mysql_query("SELECT * FROM moedas WHERE flag = '$flag_1'")
    or die("Ocorreu um problema... \n "." Nossa equipe está trabalhando nisso no momento... \n "." Por favor, volte depois de algumas horas."); 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Comidas</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Gestão das Comidas </h1>
		<?php require('incluir-menu.php'); ?>
	</div>
	
	<div id="container">
		<fieldset><legend>Novo Alimento</legend>
		<table width="930" align="center">
			<form name="comidasForm" id="comidasForm" action="comidas-exec.php" method="post" enctype="multipart/form-data" onsubmit="return validarComidas(this)">
			<tr>
				<th>Nome</th>
				<th>Descrição</th>
				<th>Preço</th>
				<th>Categoria</th>
				<th>Foto</th>
				
			</tr>
			<tr>
				<td><input type="text" name="comida_nome" id="comida_nome" class="textfield" maxlength="15" placeholder="Nome da comida" required/></td>
				<td><textarea name="comida_descricao" id="comida_descricao" class="textfield" rows="2" cols="15" maxlength="45" placeholder="Descrição da comida" required></textarea></td>
				<td><input type="number" name="comida_preco" id="comida_preco" class="textfield" maxlength="15" placeholder="Preço da comida" required/></td>
				<td width="168">
					<select name="id_categoria" id="id_categoria">
						<option value="select">- selecione a categoria -
						<?php 
							//Loop através de linhas da tabela categorias
							while ($row = mysql_fetch_array($categorias)){
								echo "<option value=$row[id_categoria]>$row[categoria_nome]"; 
							}
						?>
					</select>
				</td>
				<td><input type="file" name="comida_foto" id="comida_foto" required/></td>
			</tr>
			<tr bgcolor="#dddddd">
				<td colspan="5" align="center"><label>Ação(ões) <input type="submit" name="Submit" value="Adicionar" /></label></td>
			</tr>
			</form>
		</table>
		</fieldset>
		<hr>
		<fieldset><legend>Alimentos disponíveis</legend>
		<table width="950" align="center" border="1">
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
				<th>Foto do Alimento</th>
				<th>Nome do Alimento</th>
				<th>Descrição do Alimento</th>
				<th>Preço do Alimento</th>
				<th>Categoria do Alimento</th>
				<th>Ação(ões)</th>
			</tr>

			<?php
				//Obter moeda ativa
				$simbolo = mysql_fetch_assoc($moedas); 
				//Loop através de todas as linhas da tabela
				while ($row = mysql_fetch_array($resultado)){
					echo "<form name=\"comidasForm\" id=\"comidasForm\" action=\"alterar-comida.php\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"return validarComidas(this)\">";
					echo "<tr>";
						echo '<td>';
							echo "<img style=\"border-style:solid; border-color:red;\" src=../images/";
								if($row['comida_foto']==""){
									echo "default.png";
								}else{
									echo $row['comida_foto'];
								}
							echo " width=\"80\" height=\"70\">";
							echo '<input style="font-size:10" type="file" name="file_comida_foto" id="file_comida_foto"/>';
							echo '<input type="hidden" name="comida_foto" id="comida_foto" value="'.$row['comida_foto'].'"/>';
						echo '</td>';
						echo "<td><input style=\"font-size:10\" size=\"28\" type=\"text\" name=\"comida_nome\" id=\"comida_nome\" class=\"textfield\" maxlength=\"15\" placeholder=\"Nome da comida\"  value='".$row['comida_nome']."' required/></td>";
						echo "<td><textarea name=\"comida_descricao\" id=\"comida_descricao\" class=\"textfield\" rows=\"2\" cols=\"12\" maxlength=\"45\" placeholder=\"Descrição da comida\" required>".$row['comida_descricao']."</textarea></td>";
						echo "<td style=\"font-size:10\">".$simbolo['moeda_simbolo']." <input size=\"6\" name=\"comida_preco\" type=\"text\" class=\"textfield\" id=\"comida_preco\" maxlength=\"10\" placeholder=\"Preço da comida\" value=\"".number_format($row['comida_preco'],2,',','.')."\" required/></td>";
						
						//Recuperar categorias da tabela categorias
						$categorias_1 = mysql_query("SELECT * FROM categorias")
						or die("Não há registros para mostrar... \n" . mysql_error()); 
						
						echo "<td>";
							 echo "<select name=\"id_categoria\" id=\"id_categoria\" style=\"font-size:10\">";
								echo "<option value=\"select\">- selecione a categoria -";
									//Loop através de linhas da tabela categorias
									while ($row_categoria = mysql_fetch_array($categorias_1)){
										echo "<option value=$row_categoria[id_categoria]";
										if($row_categoria['id_categoria'] == $row['id_categoria']){
											echo " selected=\"selected\" ";
										}
										echo">$row_categoria[categoria_nome]"; 
									}
							echo "</select>";
						echo "</td>";
						echo "<td bgcolor=\"#dddddd\" width=\"145\" align=\"center\">";
							echo "<input type=\"button\" value=\"Remover\" onclick=\"parent.location='remover-comida.php?id=". $row['id_comida'] ."'\">";
							echo " ";
							echo "<input type=\"hidden\" name=\"id_comida\" value=\"".$row['id_comida']."\" />";
							echo "<input type=\"submit\" name=\"Alterar\" value=\"Alterar\" />";
						echo "</td>";
					echo "</tr>";
					echo "</form>";
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