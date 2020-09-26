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
    $moedas = mysql_query("SELECT * FROM moedas WHERE flag = '$flag_1'")
    or die("Ocorreu um problema... \n "." Nossa equipe está trabalhando nisso no momento... \n "." Por favor, volte depois de algumas horas."); 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Promoções</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Gerenciar Promoções </h1>
		<?php require('incluir-menu.php'); ?>
	</div>
	
	<div id="container">
		<fieldset><legend>Novas Promoções</legend>
			<form name="promocoesForm" id="promocoesForm" action="promocoes-exec.php" method="post" enctype="multipart/form-data" onsubmit="return validarPromocoes(this)">
			<table width="930">
			<tr>
				<th>Nome</th>
				<th>Descrição</th>
				<th>Preço</th>
				<th>Data Início</th>
				<th>Data Final</th>
			</tr>
			<tr align="center">
				<td><input type="text" name="promocao_nome" id="promocao_nome" class="textfield" maxlength="15" placeholder="Nome da promoção" required/></td>
				<td><textarea name="promocao_descricao" id="promocao_descricao" class="textfield" rows="2" cols="15" maxlength="45" placeholder="Descrição da promoção" required></textarea></td>
				<td><input name="promocao_preco" type="text" class="textfield formValor" id="promocao_preco" maxlength="10" placeholder="Preço da promoção" required/></td>
				<td><input type="date" name="promocao_data_inicio" id="promocao_data_inicio" class="textfield formDate" required/></td>
				<td><input type="date" name="promocao_data_fim" id="promocao_data_fim" class="textfield formDate" required /></td>
			</tr>
			<tr align="center">
				<th>Foto</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			<tr align="center">
				<td colspan="2"><input type="file" name="file_promocao_foto" id="file_promocao_foto" required/></td>
				<td></td>
				<td></td>
				<td/></td>
			</tr>
			
			<tr bgcolor="#dddddd">
				<td colspan="5" align="center"><label>Ação(ões) <input type="submit" name="Adicionar" value="Adicionar" /></label></td>
			</tr>
			</table>
			</form>
		</fieldset>
		<hr>
		<fieldset><legend>Promoções criadas</legend>
			<table width="950" align="center" border="1">
			<tr>
				<td class="paginacao" colspan="7" align="right">
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
				<th>Foto da promoção</th>
				<th>Nome da promoção</th>
				<th>Descrição da promoção</th>
				<th>Preço da promoção</th>
				<th>Data Início</th>
				<th>Data Final</th>
				<th>Ação(ões)</th>
			</tr>

			<?php
			$simbolo = mysql_fetch_assoc($moedas); //obter moeda ativa
			
			//loop através de todas as linhas da tabela
			while ($row = mysql_fetch_array($resultado)){
			echo '<form name="promocoesForm" id="promocoesForm" action="alterar-promocao.php" method="post" enctype="multipart/form-data"  onsubmit="return validarPromocoes(this)">';
			echo "<tr>";
				echo '<td>';
					echo "<img style=\"border-style:solid; border-color:red;\" src=../images/";
						if($row['promocao_foto']==""){
							echo "default.png";
						}else{
							echo $row['promocao_foto'];
						}
					echo " width=\"80\" height=\"70\">";
					
					echo '<input style="font-size:10" type="file" name="file_promocao_foto" id="file_promocao_foto"/>';
					echo '<input type="hidden" name="promocao_foto" id="promocao_foto" value="'.$row['promocao_foto'].'"/>';
				echo '</td>';
				echo "<td><input size=\"17\" name=\"promocao_nome\" type=\"text\" class=\"textfield\" id=\"promocao_nome\" maxlength=\"25\" placeholder=\"Nome da promoção\" value=\"".$row['promocao_nome']."\" required/></td>";
				echo "<td><textarea name=\"promocao_descricao\" id=\"promocao_descricao\" class=\"textfield\" rows=\"2\" cols=\"13\" maxlength=\"45\" placeholder=\"Descrição da promoção\" required>".$row['promocao_descricao']."</textarea>";							
				echo "<td>".$simbolo['moeda_simbolo']." <input size=\"5\" name=\"promocao_preco\" type=\"text\" class=\"textfield formValor\" id=\"promocao_preco\" maxlength=\"10\" placeholder=\"Preço da promoção\" value=\"".number_format($row['promocao_preco'],2,',','.')."\" required/></td>";
				echo "<td><input size=\"7\" name=\"promocao_data_inicio\" id=\"promocao_data_inicio\" class=\"textfield formDate\" value=\"".date('d/m/Y',strtotime($row['promocao_data_inicio']))."\" required/></td>";
				echo "<td><input size=\"7\" name=\"promocao_data_fim\" id=\"promocao_data_fim\" class=\"textfield formDate\" value=\"".date('d/m/Y',strtotime($row['promocao_data_fim']))."\" required /></td>";
				echo "<td bgcolor=\"#dddddd\" width=\"145\" align=\"center\">";
					echo "<input type=\"button\" value=\"Remover\" onclick=\"parent.location='remover-promocao.php?id=". $row['id_promocao'] ."'\">";
					echo " ";
					echo "<input type=\"hidden\" name=\"id_promocao\" value=\"".$row['id_promocao']."\" />";
					echo "<input type=\"submit\" name=\"Alterar\" value=\"Alterar\" />";
				echo "</td>";
			echo "</tr>";
			echo "</form>";
			}

			?>
			<tr>
				<td class="paginacao" colspan="7" align="right">
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