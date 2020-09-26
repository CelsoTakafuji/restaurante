<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
    require_once('auth.php');
	require_once('js/jscSis.php');
	require_once('admin/conteudo-site.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $nome ?>:Faturamento Alternativo</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
</script>
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	
	<div id="center">
	<h1>Endereço de cobrança</h1>
	<hr>
	<?php echo $outros_enderecos; ?>
		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<form id="enderecoForm" name="enderecoForm" method="post" action="endereco-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return validarEndereco(this)">
				<table width="520" border="1" align="center" cellpadding="2" cellspacing="0">
					<CAPTION><h3>ADICIONAR ENTREGA/ENDEREÇO DE COBRANÇA</h3></CAPTION>
					<tr>
						<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Campos obrigatórios</td>
					</tr>
					<tr>
					  <th>Endereço </th>
					  <td><font color="#FF0000">* </font><textarea name="endereco" id="endereco" class="textfield" rows="4" cols="30" maxlength="100" placeholder="Digite o endereço usando o formato padrão" required></textarea></td>
					</tr>
					<tr>
					  <th>CEP </th>
					  <td><font color="#FF0000">* <input style="width:180px" name="cep" type="text" class="formCep" id="cep" maxlength="15" placeholder="Forneça o código postal (CEP)" required/></td>
					</tr>
					<tr>
					  <th>Cidade</th>
					  <td><font color="#FF0000">* </font><input style="width:180px" name="cidade" type="text" class="textfield" id="cidade" maxlength="15" placeholder="Digite a sua cidade" required/></td>
					</tr>
					<tr>
					  <th width="124">Nº do celular</th>
					  <td width="168"><font color="#FF0000">* </font><input style="width:180px" name="celular" type="tel" class="formCel" id="celular" maxlength="15" placeholder="Digite o número de seu celular" required/></td>
					</tr>
					<tr>
					  <th>Nº do telefone fixo</th>
					  <td>&nbsp;&nbsp;&nbsp;<input style="width:180px" name="telefone" type="tel" class="formFone" id="telefone" maxlength="15" placeholder="Digite o nº de telefone fixo"/></td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					  <td><input type="submit" name="Submit" value="Adicionar endereço" /></td>
					</tr>
				</table>
			</form>
			<br/>
		</div>
	</div>
	
	<?php require('/incluir-rodape.php'); ?>
	
</div>
</body>
</html>
