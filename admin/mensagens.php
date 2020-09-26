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
	if (!isset($_GET['']) or !is_numeric($_GET['iniciarpaginaenviada'])) {
		//O valor da linha de partida será 0 (zero) porque nada foi encontrado em URL
		$iniciarpaginaenviada = 0;
	//Caso contrário, tomar o valor da URL
	} else {
		$iniciarpaginaenviada = (int)$_GET['iniciarpaginaenviada'];
	}
	$regspagina = 5;
?>
<?php
	//Verificar se a variável da linha de partida foi passada na URL ou não
	if (!isset($_GET['iniciarpaginarecebida']) or !is_numeric($_GET['iniciarpaginarecebida'])) {
		//O valor da linha de partida para 0 (zero) porque nada foi encontrado em URL
		$iniciarpaginarecebida = 0;
	//caso contrário, tomar o valor da URL
	} else {
		$iniciarpaginarecebida = (int)$_GET['iniciarpaginarecebida'];
	}
?>
<?php
	//Verificar se a variável da linha de partida foi passada na URL ou não
	if (!isset($_GET['iniciarpaginarecebidacli']) or !is_numeric($_GET['iniciarpaginarecebidacli'])) {
		//O valor da linha de partida para 0 (zero) porque nada foi encontrado em URL
		$iniciarpaginarecebidacli = 0;
	//caso contrário, tomar o valor da URL
	} else {
		$iniciarpaginarecebidacli = (int)$_GET['iniciarpaginarecebidacli'];
	}
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
	
	//Selecionar todos os registros da tabela de mensagens. Devolver um erro se houver algum problema
	$flag_enviadas = 0; //retornar apenas as mensagens enviadas
	$flag_recebidas = 1; //retornar apenas as mensagens recebidas
	
	//Mensagens enviadas
	$enviadas = mysql_query("SELECT * FROM mensagens WHERE mensagem_flag = '$flag_enviadas' LIMIT $iniciarpaginaenviada, $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error()); 

	//Mensagens enviadas
	$enviadas_2 = mysql_query("SELECT * FROM mensagens WHERE mensagem_flag = '$flag_enviadas' LIMIT ".($iniciarpaginaenviada + $regspagina).", $regspagina") 
	or die("Não há registros para mostrar... \n" . mysql_error()); 
	
	//Mensagens de não clientes
	$recebidas = mysql_query("SELECT * FROM mensagens WHERE mensagem_flag = '$flag_recebidas' AND id_cliente = 0 LIMIT $iniciarpaginarecebida, $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error()); 
	
	//Mensagens de não clientes
	$recebidas_2 = mysql_query("SELECT * FROM mensagens WHERE mensagem_flag = '$flag_recebidas' AND id_cliente = 0 LIMIT ".($iniciarpaginarecebida + $regspagina).", $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error());
	
	//Mensagens de clientes
	$recebidas_cli = mysql_query("SELECT * FROM mensagens WHERE mensagem_flag = '$flag_recebidas' AND id_cliente > 0 LIMIT $iniciarpaginarecebida, $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error());
	
	//Mensagens de clientes
	$recebidas_cli_2 = mysql_query("SELECT * FROM mensagens WHERE mensagem_flag = '$flag_recebidas' AND id_cliente > 0 LIMIT ".($iniciarpaginarecebidacli + $regspagina).", $regspagina")
	or die("Não há registros para mostrar... \n" . mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mensagens</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">

	<div id="header">
	<h1>Gestão de mensagens </h1>
	<?php require('incluir-menu.php'); ?>
	</div>

	<div id="container">

	<?php
	if(isset($_GET['id'])){
		//Mensagem por id
		$mensagem = mysql_query("SELECT * FROM mensagens WHERE id_mensagem = ".$_GET['id']."")
		or die("Não há registros para mostrar... \n" . mysql_error());
		
		$row_msg = mysql_fetch_array($mensagem);
	?>
		<fieldset><legend>Enviar mensagens para <?php echo $row_msg['mensagem_de']; ?></legend>
		<form id="mensagemForm" name="mensagemForm" method="post" action="mensagens-exec.php" onsubmit="return validarMensagem(this)">
		  <table width="540" border="0" cellpadding="2" cellspacing="0" align="center">
			<tr>
				<th width="200">Para</th>
				<td width="168"><input readonly="readonly" type="text" name="mensagem_para" id="mensagem_para" class="textfield" maxlength="45" placeholder="Destinatário da mensagem" value="<?php echo $row_msg['mensagem_de']; ?>" required/></td>
			</tr>
		    <tr>
				<th width="200">Assunto</th>
				<td width="168"><input type="text" name="mensagem_assunto" id="mensagem_assunto" class="textfield" maxlength="45" placeholder="Assunto da mensagem" value="<?php echo "Res: ".$row_msg['mensagem_assunto']; ?>" required/></td>
			</tr>
			<tr>
				<th width="200">Caixa de Mensagem</th>
				<td width="168"><textarea name="mensagem_texto" class="textfield" rows="5" cols="60" maxlength="250" placeholder="Escreva sua mensagem aqui para enviar para todos os nossos clientes" required><?php echo "Mensagem: ".$row_msg['mensagem_texto']."\n\n Resposta: "; ?></textarea></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="center">
					<input type="reset" name="Reset" value="Limpar Campos" />
					<input type="submit" name="Submit" value="Enviar Mensagem" />
					<input type="hidden" name="id_cliente" value="<?php echo $row_msg['id_cliente']; ?>" />
				</td>
			</tr>
		  </table>
		</form>
		</fieldset>
		<hr>
	<?php
	}
	?>
	
	<fieldset><legend>Enviar mensagens para todos</legend>
	<form id="mensagemForm" name="mensagemForm" method="post" action="mensagens-exec.php" onsubmit="return validarMensagem(this)">
	  <table width="540" border="0" cellpadding="2" cellspacing="0" align="center">
		<tr>
			<th width="200">Assunto</th>
			<td width="168"><input type="text" name="mensagem_assunto" id="mensagem_assunto" class="textfield" maxlength="45" placeholder="Assunto da mensagem" required/></td>
		</tr>
		<tr>
			<th width="200">Caixa de Mensagem</th>
			<td width="168"><textarea name="mensagem_texto" class="textfield" rows="5" cols="60" maxlength="250" placeholder="Escreva sua mensagem aqui para enviar para todos os nossos clientes" required></textarea></td>
		</tr>
		<tr>
			<td bgcolor="#dddddd" colspan="2" align="center">
				<input type="reset" name="Reset" value="Limpar Campos" />
				<input type="submit" name="Submit" value="Enviar Mensagem" />
			</td>
		</tr>
	  </table>
	</form>
	</fieldset>
	
	<hr>
	
	<fieldset><legend>As mensagens enviadas</legend>
	<table border="1" width="950" align="center" style="font-size:14px;">
		<tr>
			<td class="paginacao" colspan="7" align="right">
				<?php
				//Criar um link "Anterior"
				$prev = $iniciarpaginaenviada - $regspagina;
				//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginaenviada='.$prev.'"><-Anterior</a>';
				
				if ($prev >= 0 AND mysql_num_rows($enviadas) == $regspagina)
				//Criar um separador
				echo ' | ';
				
				if (mysql_num_rows($enviadas) == $regspagina && mysql_num_rows($enviadas_2) > 0)
				//Criar um link "Próximo"
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginaenviada='.($iniciarpaginaenviada + $regspagina).'">Próximo-></a>';
				?>
			</td>
		</tr>
	
		<tr class="tituloTabela">
			<th width="60">Código</th>
			<th width="100">Data enviada</th>
			<th width="75">Horário de envio</th>
			<th width="100">Para</th>
			<th width="90">Assunto</th>
			<th>Mensagem</th>
			<th width="75">Ação(ões)</th>
		</tr>

		<?php
			//loop através de todas as linhas da tabela
			while ($row = mysql_fetch_array($enviadas)){
				//Clientes
				$destinatario = "Todos";
				if($row['id_cliente'] > 0){
					$clientes = mysql_query("SELECT * FROM clientes WHERE id_cliente = ".$row['id_cliente']."")
					or die("Não há registros para mostrar... \n" . mysql_error());
					
					$rowcliente = mysql_fetch_assoc($clientes);
					$destinatario = $rowcliente['nome']." ".$rowcliente['sobrenome'];
				}
				
				echo "<tr>";
					echo "<td>" . $row['id_mensagem']."</td>";
					echo "<td>" . date('d/m/Y',strtotime($row['mensagem_data']))."</td>";
					echo "<td>" . date('H:i:s',strtotime($row['mensagem_tempo']))."</td>";
					echo "<td>" . $destinatario."</td>";
					echo "<td>" . $row['mensagem_assunto']."</td>";
					echo "<td align='left'>" . $row['mensagem_texto']."</td>";
					echo '<td bgcolor="#dddddd" align="center"><a href="remover-mensagem.php?id=' . $row['id_mensagem'] . '">Remover</a></td>';
				echo "</tr>";
			}
		?>
		
		<tr>
			<td class="paginacao" colspan="7" align="right">
				<?php
				//Criar um link "Anterior"
				$prev = $iniciarpaginaenviada - $regspagina;
				//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginaenviada='.$prev.'"><-Anterior</a>';
				
				if ($prev >= 0 AND mysql_num_rows($enviadas) == $regspagina)
				//Criar um separador
				echo ' | ';
				
				if (mysql_num_rows($enviadas) == $regspagina && mysql_num_rows($enviadas_2) > 0)
				//Criar um link "Próximo"
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginaenviada='.($iniciarpaginaenviada + $regspagina).'">Próximo-></a>';
				?>
			</td>
		</tr>
	</table>
	</fieldset>
	
	<hr>
	
	<fieldset><legend>As mensagens recebidas (NÃO CLIENTE)</legend>
	<table border="1" width="950" align="center" style="font-size:14px;">
		<tr>
			<td class="paginacao" colspan="8" align="right">
				<?php
				//Criar um link "Anterior"
				$prev = $iniciarpaginarecebida - $regspagina;
				//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginarecebida='.$prev.'"><-Anterior</a>';
				
				if ($prev >= 0 AND mysql_num_rows($recebidas) == $regspagina)
				//Criar um separador
				echo ' | ';
				
				if (mysql_num_rows($recebidas) == $regspagina && mysql_num_rows($recebidas_2) > 0)
				//Criar um link "Próximo"
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginarecebida='.($iniciarpaginarecebida + $regspagina).'">Próximo-></a>';
				?>
			</td>
		</tr>
		
		<tr class="tituloTabela">
			<th width="60">Código</th>
			<th width="100">Data Recebida</th>
			<th width="75">Horário Recebido</th>
			<th width="100">De</th>
			<th width="160">E-mail</th>
			<th width="70">Assunto</th>
			<th >Mensagem</th>
			<th width="75">Ação(ões)</th>
		</tr>

		<?php
			//loop através de todas as linhas da tabela
			while ($row=mysql_fetch_array($recebidas)){
				echo "<tr>";
				echo "<td>" . $row['id_mensagem']."</td>";
				echo "<td>" . date('d/m/Y',strtotime($row['mensagem_data']))."</td>";
				echo "<td>" . date('H:i:s',strtotime($row['mensagem_tempo']))."</td>";
				echo "<td style=\"font-size:12px;\">" . $row['mensagem_de']."</td>";
				echo "<td style=\"font-size:12px;\">" . $row['mensagem_email']."</td>";
				echo "<td style=\"font-size:12px;\">" . $row['mensagem_assunto']."</td>";
				echo "<td style=\"font-size:12px;\" align='left'>" . $row['mensagem_texto']."</td>";
				echo '<td bgcolor="#dddddd" align="center"><a href="remover-mensagem.php?id=' . $row['id_mensagem'] . '">Remover</a></td>';
			echo "</tr>";
		}
		?>
		
		<tr>
			<td class="paginacao" colspan="8" align="right">
				<?php
				//Criar um link "Anterior"
				$prev = $iniciarpaginarecebida - $regspagina;
				//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginarecebida='.$prev.'"><-Anterior</a>';
				
				if ($prev >= 0 AND mysql_num_rows($recebidas) == $regspagina)
				//Criar um separador
				echo ' | ';
				
				if (mysql_num_rows($recebidas) == $regspagina && mysql_num_rows($recebidas_2) > 0)
				//Criar um link "Próximo"
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginarecebida='.($iniciarpaginarecebida + $regspagina).'">Próximo-></a>';
				?>
			</td>
		</tr>
	</table>
	</fieldset>
	
	<hr>
	
<fieldset><legend>As mensagens recebidas (CLIENTE)</legend>
	<table border="1" width="950" align="center" style="font-size:14px;">
		<tr>
			<td class="paginacao" colspan="8" align="right">
				<?php
				//Criar um link "Anterior"
				$prev = $iniciarpaginarecebidacli - $regspagina;
				//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginarecebidacli='.$prev.'"><-Anterior</a>';
				
				if ($prev >= 0 AND mysql_num_rows($recebidas_cli) == $regspagina)
				//Criar um separador
				echo ' | ';
				
				if (mysql_num_rows($recebidas_cli) == $regspagina && mysql_num_rows($recebidas_cli_2) > 0)
				//Criar um link "Próximo"
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginarecebidacli='.($iniciarpaginarecebidacli + $regspagina).'">Próximo-></a>';
				?>
			</td>
		</tr>
		
		<tr class="tituloTabela">
			<th width="60">Código</th>
			<th width="100">Data Recebida</th>
			<th width="75">Horário Recebido</th>
			<th width="100">De</th>
			<th width="160">E-mail</th>
			<th width="70">Assunto</th>
			<th >Mensagem</th>
			<th width="75">Ação(ões)</th>
		</tr>

		<?php
			//loop através de todas as linhas da tabela
			while ($row=mysql_fetch_array($recebidas_cli)){
				echo "<tr>";
				echo "<td>" . $row['id_mensagem']."</td>";
				echo "<td>" . date('d/m/Y',strtotime($row['mensagem_data']))."</td>";
				echo "<td>" . date('H:i:s',strtotime($row['mensagem_tempo']))."</td>";
				echo "<td style=\"font-size:12px;\">" . $row['mensagem_de']."</td>";
				echo "<td style=\"font-size:12px;\">" . $row['mensagem_email']."</td>";
				echo "<td style=\"font-size:12px;\">" . $row['mensagem_assunto']."</td>";
				echo "<td style=\"font-size:12px;\" align='left'>" . $row['mensagem_texto']."</td>";
				echo '<td bgcolor="#dddddd" align="center">';
						echo'<a href="remover-mensagem.php?id=' . $row['id_mensagem'] . '">Remover</a>';
							
						//Mensagens de cliente respondida
						$recebidas_cli_resp = mysql_query("SELECT * FROM mensagens WHERE mensagem_flag = '$flag_enviadas' AND id_cliente = ".$row['id_cliente']." AND mensagem_assunto = CONCAT('Res: ', '".$row['mensagem_assunto']."') AND TIMESTAMP(CONCAT(mensagem_data,' ',mensagem_tempo)) > '".date('Y-m-d H:i:s',strtotime($row['mensagem_data']." ".$row['mensagem_tempo']))."'")
						or die("Não há registros para mostrar... \n" . mysql_error());

						//Se a mensagem já foi respondida não exibir o link para "Responder"
						if(mysql_num_rows($recebidas_cli_resp) == 0){
							echo '<hr>';
							echo'<a href="mensagens.php?id=' . $row['id_mensagem'] . '">Responder</a>';
						}
				echo '</td>';
			echo "</tr>";
		}
		?>
		
		<tr>
			<td class="paginacao" colspan="8" align="right">
				<?php
				//Criar um link "Anterior"
				$prev = $iniciarpaginarecebidacli - $regspagina;
				//Imprimir apenas um link "Anterior" se um "Próximo" foi clicado
				if ($prev >= 0)
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginarecebidacli='.$prev.'"><-Anterior</a>';
				
				if ($prev >= 0 AND mysql_num_rows($recebidas_cli) == $regspagina)
				//Criar um separador
				echo ' | ';
				
				if (mysql_num_rows($recebidas_cli) == $regspagina && mysql_num_rows($recebidas_cli_2) > 0)
				//Criar um link "Próximo"
				echo '<a href="'.$_SERVER['PHP_SELF'].'?iniciarpaginarecebidacli='.($iniciarpaginarecebidacli + $regspagina).'">Próximo-></a>';
				?>
			</td>
		</tr>
	</table>
	</fieldset>	
	
	<hr>
	</div>

	<?php 
		mysql_free_result($enviadas);
		mysql_free_result($recebidas);
		mysql_close($link);
	?>
	
	<?php require('incluir-rodape.php'); ?>
	
</div>
</body>
</html>