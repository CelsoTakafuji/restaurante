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
	//Iniciar sessão
	session_start();
	
	if(@$_SESSION['SESS_FIRST_NAME'] && $_SESSION['SESS_LAST_NAME'] && $_SESSION['SESS_EMAIL'] != ''){
		$sessao_nome = $_SESSION['SESS_FIRST_NAME'];
		$sessao_sobrenome = $_SESSION['SESS_LAST_NAME'];
		$sessao_email = $_SESSION['SESS_EMAIL'];
	}
	
	//Verificar se a variável de sessão SESS_MEMBER_ID está presente ou não
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
		//Obter id_cliente da sessão
		$id_cliente = 0;
	}else{
		$id_cliente = $_SESSION['SESS_MEMBER_ID'];
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $nome ?>:Contatos</title>
<script type="text/javascript" src="swf/swfobject.js"></script>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	
	<div id="center">
	  <h1>Entre em contato conosco</h1>
	  
	  <div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
		<table>
			<tr>
				<td align="left">
					<?php echo $contatos; ?>
					<?php echo '<img src=images/'. $localizacao. ' width="400" height="400">'; ?>
				</td>
				<td align="right">
					<form id="mensagemForm" name="mensagemForm" method="post" action="mensagem-exec.php" onsubmit="return validarMensagem(this)">
						<table width="485" border="1" cellpadding="2" cellspacing="0" align="center">
							<tr>
								<th width="200">Nome</th>
								<td width="168"><input type="text" name="nome" id="nome" value="<?php echo @$sessao_nome ?>" class="textfield" maxlength="45" placeholder="Forneça o seu nome" required/></td>
							</tr>
							<tr>
								<th width="200">Sobrenome</th>
								<td width="168"><input type="text" name="sobrenome" id="sobrenome" value="<?php echo @$sessao_sobrenome ?>" class="textfield" maxlength="45" placeholder="Forneça o seu sobrenome" required/></td>
							</tr>
							<tr>
								<th width="200">E-mail</th>
								<td width="168"><input type="email" name="email" id="email" value="<?php echo @$sessao_email ?>" class="textfield" maxlength="45" placeholder="Forneça o seu endereço de e-mail" required/></td>
							</tr>
							<tr>
								<th width="200">Assunto</th>
								<td width="168"><input type="text" name="assunto" id="assunto" class="textfield" maxlength="65" placeholder="Digite o assunto da mensagem" required/></td>
							</tr>
							<tr>
								<th width="200">Caixa de mensagem</th>
								<td width="168"><textarea name="txtmensagem" class="textfield" rows="23" cols="45" maxlength="250" placeholder="Escreva aqui a sua mensagem para enviar para a nossa equipe de suporte. Aguarde até 48 horas para receber uma resposta. Sua mensagem e dados pessoais serão tratados como confidenciais e não serão compartilhadas com terceiros sem o seu consentimento." required></textarea></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td align="center">
									<input type="reset" name="Reset" value="Limpar Campos" />
									<input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>" />
									<input type="submit" name="enviarMsg" value="Enviar mensagem" />
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
	  </div>
	</div>

	<?php require('/incluir-rodape.php'); ?>
	
</div>
</body>
</html>
<?php
	if(isset($_GET['msgenviada'])){
		echo "<script language='JavaScript'>alert('Obrigado pela sua mensagem!')</script>";
	}
?>