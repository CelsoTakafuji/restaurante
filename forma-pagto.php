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
	
	//Recuperar formas de pagamento da tabela formas_pagto
	$formas_pagto=mysql_query("SELECT * FROM formas_pagto")
	or die("Algo está errado... \n" . mysql_error());
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $nome ?>:Forma de Pagamento</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
</script>
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	<?php 
		//Verificar se a variável 'id' foi definida na URL
		if (isset($_GET['id'])){
			//Obter o valor id
			$id = $_GET['id'];
		} else {
			die("O pedido não foi passado na URL! Por favor tente novamente após alguns minutos.");
		}
	?>
	<div id="center">
	<h1>Forma de Pagamento</h1>
	<hr>
		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<form id="pagtoForm" name="pagtoForm" method="post" action="pedido-exec.php?id=<?php echo $id;?>" onsubmit="return validarPagto(this)">
				<table width="520" border="1" align="center" cellpadding="2" cellspacing="0">
					<CAPTION><h3>ESCOLHA A FORMA DE PAGAMENTO</h3></CAPTION>
					<tr>
						<th>Selecione a forma de Pagamento </th>
					    <td>
							<select name="id_forma_pagto" id="id_forma_pagto">
								<option value="select">- selecione a forma de pagto -
								<?php 
								//loop através de linhas da tabela formas_pagto
								while ($row=mysql_fetch_array($formas_pagto)){
									echo "<option value=$row[id_forma_pagto]>$row[forma_pagto_descricao]";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					  <td><input type="submit" name="enviarFormaPagto" value="Continuar pedido" /></td>
					</tr>
				</table>
			</form>
			
			<br/>
			<p align ="center" style="color:red; font-size:14px;">
				<b>OBS.:</b> Nem todas as opções estão operativas. 
				<img src="images/meios-pagto.jpg" alt="Meios de pagamento" border="1px" align="center" />
			</p>
			<br/>
			<br/>
			
		</div>
	</div>
	<?php require('/include-footer.php'); ?>
</div>
</body>
</html>
