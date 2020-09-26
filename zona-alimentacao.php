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
		//O valor da linha de partida será 0 (zero) porque nada foi encontrado em URL
		$iniciarpagina = 0;
	} else {
		//Caso contrário, tomar o valor da URL
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

	//Selecionar todos os registros da tabela comidas e categorias. Retornar um erro se não há registros na tabela
	$resultado=mysql_query("SELECT * FROM comidas, categorias WHERE comidas.id_categoria=categorias.id_categoria LIMIT $iniciarpagina, $regspagina")
	or die("Ocorreu um problema... \n" . "Nossa equipe está trabalhando nisso neste momento... \n" . "Por favor, volte depois de algumas horas."); 

	//Selecionar todos os registros da tabela comidas e categorias. Retornar um erro se não há registros na tabela
	$resultado_2=mysql_query("SELECT * FROM comidas, categorias WHERE comidas.id_categoria=categorias.id_categoria LIMIT ".($iniciarpagina + $regspagina).", $regspagina")
	or die("Ocorreu um problema... \n" . "Nossa equipe está trabalhando nisso neste momento... \n" . "Por favor, volte depois de algumas horas."); 

?>
<?php
    //Recuperar categorias da tabela categorias
    $categorias=mysql_query("SELECT * FROM categorias ORDER BY categoria_nome")
    or die("Ocorreu um problema... \n" . "Nossa equipe está trabalhando nisso neste momento... \n" . "Por favor, volte depois de algumas horas."); 
?>
<?php
	//Definir um valor padrão para flag_1
    $flag_1 = 1;
	
	//Recuperar uma moeda da tabela moedas
    $currencies=mysql_query("SELECT * FROM moedas WHERE flag='$flag_1'")
    or die("Ocorreu um problema... \n" . "Nossa equipe está trabalhando nisso neste momento... \n" . "Por favor, volte depois de algumas horas."); 
?>
<?php
    if(isset($_POST['MostrarAlimentos'])){
        //Função para limpar os valores recebidos do formulário. Impede SQL Injection
        function limpar($str) {
            $str = @trim($str);
            if(get_magic_quotes_gpc()) {
                $str = stripslashes($str);
            }
            return mysql_real_escape_string($str);
        }
        //Obter id da categoria
        $id = limpar($_POST['categoria']);
        
        //Selecionar todos os registros da tabela comidas e categorias com base no id da categoria. Retornar um erro se não há registros na tabela
        $resultado=mysql_query("SELECT * FROM comidas, categorias WHERE comidas.id_categoria = '$id' AND comidas.id_categoria = categorias.id_categoria LIMIT $iniciarpagina, $regspagina")
        or die("Ocorreu um problema... \n" . "Nossa equipe está trabalhando nisso neste momento... \n" . "Por favor, volte depois de algumas horas."); 
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $nome ?>:Comidas</title>
<script type="text/javascript" src="swf/swfobject.js"></script>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="validation/user.js">
</script>
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>

	<div id="center">
		<h1>ESCOLHA SUA COMIDA</h1>
		
		<hr>
		
		<h3>Nota: Limitar a zona de alimentos, selecionando uma das categorias abaixo:</h3>
	
		<form name="categoryForm" id="categoryForm" method="post" action="zona-alimentacao.php" onsubmit="return categoriesValidate(this)">
			<table width="360" border="1" align="center">
				<tr>
					<td>Categoria</td>
					<td width="168">
						<select name="categoria" id="categoria">
							<option value="select">- selecione a categoria -
							<?php 
							//Loop através de linhas da tabela categorias
							while ($row=mysql_fetch_array($categorias)){
								echo "<option value=$row[id_categoria]>$row[categoria_nome]"; 
							}
							?>
						</select>
					</td>
					<td><input type="submit" name="MostrarAlimentos" value="Mostrar Alimentos" /></td>
				</tr>
			</table>
		</form>
	 
		<br/>

		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<table width="900" border="1" height="auto" align="center" style="text-align:center;">
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
					<th>Foto da comida</th>
					<th>Nome da comida</th>
					<th>Descrição da comida</th>
					<th>Categoria da comida</th>
					<th>Preço</th>
					<th>Ação(ões)</th>
				</tr>
				<?php
					$count = mysql_num_rows($resultado);
					if(isset($_POST['MostrarAlimentos']) && $count < 1){
						echo "<html><script language='JavaScript'>alert('No momento não há alimentos desta categoria selecionada. Por favor, volte mais tarde.')</script></html>";
					}
					else{
						//Loop através de todas as linhas da tabela
						$symbolo=mysql_fetch_assoc($moedas); //recebe moeda ativa
						while ($row=mysql_fetch_assoc($resultado)){
							echo "<tr>";
							echo '<td><a href=images/'. $row['comida_foto']. ' alt="clique para ver a imagem completa" target="_blank"><img src=images/'. $row['comida_foto']. ' width="80" height="70"></a></td>';
							echo "<td>".$row['comida_nome']."</td>";
							echo "<td>".$row['comida_descricao']."</td>";
							echo "<td>".$row['categoria_nome']."</td>";
							echo "<td>".$symbolo['moeda_simbolo']. "" . $row['comida_preco']."</td>";
							echo '<td><a href="carrinho-exec.php?id=' . $row['id_comida'] . '">Adicionar ao carrinho</a></td>';
							echo "</td>";
							echo "</tr>";
						}      
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