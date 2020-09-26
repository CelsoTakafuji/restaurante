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
	
	//Função para limpar os valores recebidos do formulário. Impede SQL Injection
	function limpar($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	if (isset($_POST['Alterar'])){
		//Limpar os valores POST
		$id_conteudo 				= limpar(1);
		$nome 						= limpar($_POST['nome']);
		$titulo 					= limpar($_POST['titulo']);
		$subtitulo 					= limpar($_POST['subtitulo']);
		$sobre_nos_descricao 		= limpar($_POST['sobre_nos_descricao']);
		$sobre_nos_missao 			= limpar($_POST['sobre_nos_missao']);
		$sobre_nos_visao 			= limpar($_POST['sobre_nos_visao']);
		$contatos 					= limpar($_POST['contatos']);
		if(!empty($_FILES['file_localizacao']['tmp_name'])){
			//Configurar um diretório onde a localização será salva
			$target = "../images/";
			$target = $target . basename( $_FILES['file_localizacao']['name']);			
			
			$localizacao = limpar($_FILES['file_localizacao']['name']);
			
			//Mover a foto para o servidor
			$mover = move_uploaded_file($_FILES['file_localizacao']['tmp_name'], $target);
			 
			if($mover){
				//Está tudo bem
				echo "A localização". basename( $_FILES['file_localizacao']['name']). " foi enviada com sucesso."; 
			} else {  
				//Gerar um erro se não está tudo bem
				echo "Desculpe, houve um problema upload na localizção do seu restaurante... o erro real é"  . $_FILES["file_localizacao"]["error"]; 
			}
		}else{
			$localizacao = limpar($_POST['localizacao']);
		}
		$descricao_promocao 			= limpar($_POST['descricao_promocao']);
		$descricao_minha_conta 			= limpar($_POST['descricao_minha_conta']);
		$descricao_pedidos_concluidos 	= limpar($_POST['descricao_pedidos_concluidos']);
		$descricao_meu_perfil 			= limpar($_POST['descricao_meu_perfil']);
		$descricao_caixa_entrada 		= limpar($_POST['descricao_caixa_entrada']);
		$descricao_mesas 				= limpar($_POST['descricao_mesas']);
		$descricao_saloes_festa 		= limpar($_POST['descricao_saloes_festa']);
		$descricao_avaliacao			= limpar($_POST['descricao_avaliacao']);
		$outros_enderecos				= limpar($_POST['outros_enderecos']);
		$outros_deslogado 				= limpar($_POST['outros_deslogado']);
		$outros_acesso_negado 			= limpar($_POST['outros_acesso_negado']);

		//Criar query update 
		$resultado = mysql_query("UPDATE conteudo SET nome='$nome',titulo='$titulo',subtitulo='$subtitulo',
		sobre_nos_descricao='$sobre_nos_descricao',sobre_nos_missao='$sobre_nos_missao',sobre_nos_visao='$sobre_nos_visao',contatos='$contatos',
		localizacao='$localizacao',descricao_promocao='$descricao_promocao',descricao_minha_conta='$descricao_minha_conta',
		descricao_pedidos_concluidos='$descricao_pedidos_concluidos',descricao_meu_perfil='$descricao_meu_perfil',descricao_caixa_entrada='$descricao_caixa_entrada',descricao_mesas='$descricao_mesas',
		descricao_saloes_festa='$descricao_saloes_festa',descricao_avaliacao='$descricao_avaliacao',outros_enderecos='$outros_enderecos',
		outros_deslogado='$outros_deslogado',outros_acesso_negado='$outros_acesso_negado' WHERE id_conteudo = '$id_conteudo'"); 

		if ($resultado){
			//Redirecionar de volta à página de conteúdo
			header("Location: conteudo.php");
			exit();
		}
		else{
			die("Mudanças da atualização falhou... o erro MySql é " . mysql_error());
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Conteúdo</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Gestão de Conteúdo </h1>
		<?php require('incluir-menu.php'); ?>
	</div>

	<div id="container">
		<form name="conteudoForm" id="conteudoForm" action="conteudo.php" method="post" enctype="multipart/form-data" onsubmit="return validarConteudo(this)">
			<fieldset><legend align="center">Gerenciar seu próprio conteúdo</legend>
				<fieldset><legend>Nome do Restaurante</legend>
					<table width="410" border="0" cellpadding="2" cellspacing="0" align="center">
						<tr>
							<td>Mostrar Nome</td>
							<td><textarea name="nome" class="textfield" rows="1" cols="30" maxlength="25" placeholder="Nome de seu restaurante" required><?php echo $nome; ?></textarea></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Página Inicial</legend>
					<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<th>Título</th>
							<th>Subtítulo</th>
						</tr>
						<tr>
							<td><textarea name="titulo" class="textfield" rows="3" cols="50" maxlength="100" placeholder="Este é o título do seu restaurante na página inicial" required><?php echo $titulo; ?></textarea></td>
							<td><textarea name="subtitulo" class="textfield" rows="3" cols="50" maxlength="1000" placeholder="Este é o subtítulo do seu restaurante na página inicial" required><?php echo $subtitulo; ?></textarea></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Sobre</legend>
					<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<th>Descrição</th>
							<th>Missão</th>
							<th>Visão</th>
						</tr>
						<tr>
							<td><textarea name="sobre_nos_descricao" class="textfield" rows="3" cols="30" maxlength="2500" placeholder="Descrição do seu restaurante" required><?php echo $sobre_nos_descricao; ?></textarea></td>
							<td><textarea name="sobre_nos_missao" class="textfield" rows="3" cols="30" maxlength="2500" placeholder="Declaração de missão para o seu restaurante" required><?php echo $sobre_nos_missao; ?></textarea></td>
							<td><textarea name="sobre_nos_visao" class="textfield" rows="3" cols="30" maxlength="2500" placeholder="Declaração de visão para o seu restaurante" required><?php echo $sobre_nos_visao; ?></textarea></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Contato</legend>
					<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<th>Contatos</th>
							<th></th>
							<th>Localização</th>
						</tr>
						<tr>
							<td><textarea name="contatos" class="textfield" rows="5" cols="50" maxlength="250" placeholder="Fornecer todas as informações de contatos aqui" required><?php echo $contatos; ?></textarea></td>
							<td>
								<?php 
									echo "<img style=\"border-style:solid; border-color:red;\" src=../images/";
										if($localizacao==""){
											echo "default.png";
										}else{
											echo $localizacao;
										}
									echo " width=\"100\" height=\"90\">"; 
								?>
							</td>
							<td>
								<input type="file" name="file_localizacao" id="file_localizacao" />
								<input type="hidden" name="localizacao" id="localizacao" value="<?php echo $localizacao; ?>"/>
							</td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Promoções</legend>
					<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<td>Descrição</td>
							<td><textarea name="descricao_promocao" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="Uma descrição na página de promoções" required><?php echo $descricao_promocao; ?></textarea></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Minha conta</legend>
					<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<td>Descrição</td>
							<td><textarea name="descricao_minha_conta" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="Uma descrição na página inicial em Minha Conta" required><?php echo $descricao_minha_conta; ?></textarea></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Pedidos Concluídos</legend>
					<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<td>Descrição</td>
							<td><textarea name="descricao_pedidos_concluidos" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="Uma descrição na página inicial de Pedidos Concluídos" required><?php echo $descricao_pedidos_concluidos; ?></textarea></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Meu perfil</legend>
					<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<td>Descrição</td>
							<td><textarea name="descricao_meu_perfil" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="Uma descrição na página meu perfil em Minha Conta" required><?php echo $descricao_meu_perfil; ?></textarea></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Caixa de Entrada</legend>
					<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<td>Descrição</td>
							<td><textarea name="descricao_caixa_entrada" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="Uma descrição na página de caixa de entrada em Minha Conta" required><?php echo $descricao_caixa_entrada; ?></textarea></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Mesas</legend>
					<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<td>Descrição</td>
							<td><textarea name="descricao_mesas" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="Uma descrição na página de mesas em Minha Conta" required><?php echo $descricao_mesas; ?></textarea></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Salão de Festas</legend>
					<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<td>Descrição</td>
							<td><textarea name="descricao_saloes_festa" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="Uma descrição na página Salão de Festas em Minha Conta" required><?php echo $descricao_saloes_festa; ?></textarea></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Avaliação</legend>
					<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<td>Descrição</td>
							<td><textarea name="descricao_avaliacao" class="textfield" rows="5" cols="60" maxlength="1000" placeholder="Uma descrição sobre a página Avaliação em Minha Conta" required><?php echo $descricao_avaliacao; ?></textarea></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Outros</legend>
					<table width="910" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<th>Endereço de cobrança</th>
							<th>Deslogar</th>
							<th>Acesso Negado</th>
						</tr>
						<tr>
							<td><textarea name="outros_enderecos" class="textfield" rows="3" cols="30" maxlength="2500" placeholder="Descrição na página de endereço de cobrança" required><?php echo $outros_enderecos; ?></textarea></td>
							<td><textarea name="outros_deslogado" class="textfield" rows="3" cols="30" maxlength="2500" placeholder="Descrição na página de deslogar" required><?php echo $outros_deslogado; ?></textarea></td>
							<td><textarea name="outros_acesso_negado" class="textfield" rows="3" cols="30" maxlength="2500" placeholder="Descrição na página de Acesso Negado" required><?php echo $outros_acesso_negado; ?></textarea></td>
						</tr>
					</table>
				</fieldset>
				<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
					<tr>
						<td colspan="2" align="center">Ações</td>
					</tr>
					<tr>
						<td><input type="reset" value="Limpar Campos"/></td>
						<td><input type="submit" name="Alterar" value="Alterar Mudanças" /></td>
					</tr>
				</table>
			</fieldset>
		</form>	
	</div>

	<?php require('incluir-rodape.php'); ?>
	
</div>
</body>
</html>