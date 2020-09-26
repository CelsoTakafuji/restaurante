<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	require_once('js/jscSis.php');
    require_once('auth.php');
	require_once('admin/conteudo-site.php');
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
	
	//obter id_cliente da sessão
	$id_cliente = $_SESSION['SESS_MEMBER_ID'];
?>
<?php	
    //Obter endereço do cliente
	$enderecos=mysql_query("SELECT * FROM enderecos WHERE enderecos.id_cliente = '$id_cliente'")
    or die("Algo está errado... \n" . mysql_error()); 
	
	//Obter a quantidade de endereços do cliente
	$num_enderecos = mysql_num_rows($enderecos);
	
	if($num_enderecos > 0){
		$possui_endereco = 1;
		$row = mysql_fetch_array($enderecos);
	}else{
		$possui_endereco = 0;
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $nome ?>:Meu Perfil</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
</script>
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	
	<div id="center">
		<h1>Meu Perfil</h1>
		<div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
			<?php require('/incluir-menu.php'); ?>
			<p>&nbsp;</p>
			<?php echo $descricao_meu_perfil ?>
			<hr>
			<table width="870" border="1" >
				<tr>
					<form id="alteracaoSenhaForm" name="alteracaoSenhaForm" method="post" action="meu-perfil-alterar-exec.php?id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return validarAlteracaoSenha(this)">
					<td>
						<table width="350" align="center" border="1" cellpadding="2" cellspacing="0">
						<CAPTION><h2>MUDE SUA SENHA</h2></CAPTION>
							<tr>
								<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Campos obrigatórios</td>
							</tr>
							<tr>
								<th width="124">Senha Antiga</th>
								<td width="168"><font color="#FF0000">* </font><input name="senhaantiga" type="password" class="textfield" id="senhaantiga" maxlength="25" placeholder="Digite sua senha antiga" required/></td>
							</tr>
							<tr>
								<th>Senha Nova</th>
								<td><font color="#FF0000">* </font><input name="senhanova" type="password" class="textfield" id="senhanova" maxlength="25" placeholder="Digite sua senha nova" required/></td>
							</tr>
							<tr>
								<th>Confirme a Senha Nova </th>
								<td><font color="#FF0000">* </font><input name="senhanovaconf" type="password" class="textfield" id="senhanovaconf" maxlength="25" placeholder="Repita a sua senha nova" required/></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td align="center"><input type="submit" name="alterarSenha" value="Mudar Senha" /></td>
							</tr>
						</table>
					</td>
					</form>
					<td>
						<form id="enderecoForm" name="enderecoForm" method="post" action="<?php if($possui_endereco){ echo "endereco-alterar.php?id="; }else{ echo "endereco-exec.php?id="; } echo $_SESSION['SESS_MEMBER_ID'];?>" onsubmit="return validarEndereco(this)">
						<table width="520" border="1" align="center" cellpadding="2" cellspacing="0">
						<CAPTION><h2><?php if($possui_endereco){ echo "ALTERAR"; }else{ echo "ADICIONAR"; } ?> ENDEREÇO DE ENTREGA/COBRANÇA</h2></CAPTION>
							<tr>
								<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Campos obrigatórios</td>
							</tr>
							<tr>
								<th>Endereço </th>
								<td><font color="#FF0000">* </font>
									<textarea name="endereco" id="endereco" class="textfield" rows="4" cols="30" maxlength="100" placeholder="Digite o endereço usando o formato padrão" required><?php if($possui_endereco){ echo $row['endereco']; } ?></textarea>
								</td>
							</tr>
							<tr>
								<th>CEP </th>
								<td><font color="#FF0000">* <input name="cep" type="text" class="formCep" id="cel" maxlength="15" placeholder="Digite o código postal (CEP)" value="<?php if($possui_endereco){ echo $row['cep']; } ?>" required/></td>
							</tr>
							<tr>
								<th>Cidade </th>
								<td><font color="#FF0000">* </font><input name="cidade" type="text" class="textfield" id="cidade" maxlength="15" placeholder="Digite a sua cidade" value="<?php if($possui_endereco){ echo $row['cidade']; } ?>" required/></td>
							</tr>
							<tr>
								<th width="124">Nº Celular</th>
								<td width="168"><font color="#FF0000">* </font><input name="celular" type="tel" class="formCel" id="celular" maxlength="15" placeholder="Digite o nº do celular" value="<?php if($possui_endereco){ echo $row['celular']; } ?>" required/></td>
							</tr>
							<tr>
								<th>Nº Telefone Fixo</th>
								<td>&nbsp;&nbsp;&nbsp;<input name="telefone" type="tel" class="formFone" id="telefone" maxlength="15" placeholder="Digite o nº do telefone fixo" value="<?php if($possui_endereco){ echo $row['telefone']; } ?>"/></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td align="center"><input type="submit" name="Submit" value="<?php if($possui_endereco){ echo "Alterar"; }else{ echo "Adicionar"; } ?>" /></td>
							</tr>
						</table>
						</form>
					</td>

			</tr>
			</table>
		<p>&nbsp;</p>
		</div>
	</div>

	<?php require('/incluir-rodape.php'); ?>
	
</div>
</body>
</html>