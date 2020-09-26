<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	require_once('auth.php');
	require_once('styles.php');
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
	
	if (isset($_POST['Atualizar'])){
		//Limpar valores POST 
		$id_modelo 				= limpar(1);
		
		if(!empty($_FILES['file_site_logo']['tmp_name'])){
			//Configurar um diretório onde a localização será salva
			$target = "../images/";
			$target = $target . basename( $_FILES['file_site_logo']['name']);			
			
			$site_logo = limpar($_FILES['file_site_logo']['name']);
			
			//Mover a foto para o servidor
			$mover_logo = move_uploaded_file($_FILES['file_site_logo']['tmp_name'], $target);
			 
			if($mover_logo){
				//Está tudo bem
				echo "A localização ". basename( $_FILES['file_site_logo']['name']). "foi enviada com sucesso."; 
			} else {  
				//Lançar um erro se não está tudo bem
				echo "Desculpe, houve um problema ao enviar o seu logotipo do restaurante... O erro é: "  . $_FILES["file_site_logo"]["error"]; 
			}
		}else{
			$site_logo = limpar($_POST['site_logo']);
		}
		
		if(!empty($_FILES['file_site_background']['tmp_name'])){
			//Configurar um diretório onde a localização será salva
			$target = "../images/";
			$target = $target . basename( $_FILES['file_site_background']['name']);			
			
			$site_background = limpar($_FILES['file_site_background']['name']);
			
			//Mover a foto para o servidor
			$mover_logo = move_uploaded_file($_FILES['file_site_background']['tmp_name'], $target);
			 
			if($mover_logo){
				//Está tudo bem
				echo "A localização ". basename( $_FILES['file_site_background']['name']). "foi enviada com sucesso."; 
			} else {  
				//Lançar um erro se não está tudo bem
				echo "Desculpe, houve um problema ao enviar o seu logotipo do restaurante... O erro é: "  . $_FILES["file_site_background"]["error"]; 
			}
		}else{
			$site_background = limpar($_POST['site_background']);
		}

		if(!empty($_FILES['file_site_header']['tmp_name'])){
			//Configurar um diretório onde a localização será salva
			$target = "../images/";
			$target = $target . basename( $_FILES['file_site_header']['name']);			
			
			$site_header = limpar($_FILES['file_site_header']['name']);
			
			//Mover a foto para o servidor
			$mover_logo = move_uploaded_file($_FILES['file_site_header']['tmp_name'], $target);
			 
			if($mover_logo){
				//Está tudo bem
				echo "A localização ". basename( $_FILES['file_site_header']['name']). "foi enviada com sucesso."; 
			} else {  
				//Lançar um erro se não está tudo bem
				echo "Desculpe, houve um problema ao enviar o seu logotipo do restaurante... O erro é: "  . $_FILES["file_site_header"]["error"]; 
			}
		}else{
			$site_header = limpar($_POST['site_header']);
		}
		
		if(!empty($_FILES['file_site_center']['tmp_name'])){
			//Configurar um diretório onde a localização será salva
			$target = "../images/";
			$target = $target . basename( $_FILES['file_site_center']['name']);			
			
			$site_center = limpar($_FILES['file_site_center']['name']);
			
			//Mover a foto para o servidor
			$mover_logo = move_uploaded_file($_FILES['file_site_center']['tmp_name'], $target);
			 
			if($mover_logo){
				//Está tudo bem
				echo "A localização ". basename( $_FILES['file_site_center']['name']). "foi enviada com sucesso."; 
			} else {  
				//Lançar um erro se não está tudo bem
				echo "Desculpe, houve um problema ao enviar o seu logotipo do restaurante... O erro é: "  . $_FILES["file_site_center"]["error"]; 
			}
		}else{
			$site_center = limpar($_POST['site_center']);
		}
		
		if(!empty($_FILES['file_site_footer']['tmp_name'])){
			//Configurar um diretório onde a localização será salva
			$target = "../images/";
			$target = $target . basename( $_FILES['file_site_footer']['name']);			
			
			$site_footer = limpar($_FILES['file_site_footer']['name']);
			
			//Mover a foto para o servidor
			$mover_logo = move_uploaded_file($_FILES['file_site_footer']['tmp_name'], $target);
			 
			if($mover_logo){
				//Está tudo bem
				echo "A localização ". basename( $_FILES['file_site_footer']['name']). "foi enviada com sucesso."; 
			} else {  
				//Lançar um erro se não está tudo bem
				echo "Desculpe, houve um problema ao enviar o seu logotipo do restaurante... O erro é: "  . $_FILES["file_site_footer"]["error"]; 
			}
		}else{
			$site_footer = limpar($_POST['site_footer']);
		}

		$site_background_color  = limpar($_POST['site_background_color']);
		$site_center_color 		= limpar($_POST['site_center_color']);
		$site_footer_color 		= limpar($_POST['site_footer_color']);

		if($site_logo=="default.png")
			$site_logo="";
		if($site_background=="default.png")
			$site_background="";
		if($site_header=="default.png")
			$site_header="";
		if($site_center=="default.png")
			$site_center="";
		if($site_footer=="default.png")
			$site_footer="";		
		
		//Query de update
		$resultado = mysql_query("UPDATE modelo SET site_logo='$site_logo',site_background='$site_background',site_header='$site_header',
		site_center='$site_center',site_footer='$site_footer',site_background_color='$site_background_color',site_center_color='$site_center_color',
		site_footer_color='$site_footer_color' WHERE id_modelo = '$id_modelo'"); 

		if ($resultado){
			//Redirecionar de volta para a página de modelo
			header("Location: modelo.php");
			exit();
		}
		else{
			die("Mudanças ao alterar falhou... o erro MySql é: " . mysql_error());
		}
	}else{
		$id_modelo 				= 1;
		
		$resultado = mysql_query("SELECT * FROM modelo WHERE id_modelo = '$id_modelo'")
		or die("Não há registros para mostrar... \n" . mysql_error()); ; 
		
		$row = mysql_fetch_assoc($resultado);

		$site_logo 				= $row['site_logo'];
		$site_background 		= $row['site_background'];
		$site_header 			= $row['site_header'];
		$site_center 			= $row['site_center'];
		$site_footer 			= $row['site_footer'];
		$site_background_color  = $row['site_background_color'];
		$site_center_color 		= $row['site_center_color'];
		$site_footer_color 		= $row['site_footer_color'];
	}
	
	if($site_logo=="")
		$site_logo="default.png";
	if($site_background=="")
		$site_background="default.png";
	if($site_header=="")
		$site_header="default.png";
	if($site_center=="")
		$site_center="default.png";
	if($site_footer=="")
		$site_footer="default.png";	
	
	/*
	if($site_logo=="" && $site_background=="" && $site_header=="" && $site_center=="" && $site_footer==""){
		$site_logo=$site_background=$site_header=$site_center=$site_footer="default.png";
	}
	else{
		
	}
	*/
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modelo</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Gerenciamento de modelos </h1>
		<?php require('incluir-menu.php'); ?>
	</div>
	
	<div id="container">
		<form name="modeloForm" id="modeloForm" action="modelo.php" method="post" enctype="multipart/form-data" onsubmit="return validarModelo(this)">
			<fieldset><legend align="center">Gerenciar Aparência do Site</legend>
				<fieldset><legend>Logo do Site</legend>
					<table width="810" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<th width="33%"></th>
							<th width="33%">Logo</th>
							<th width="34%"></th>
						</tr>
						<tr>
							<td><?php echo '<img style="border-style:solid; border-color:red;" src=../images/'. $site_logo. ' width="100" height="90">'; ?></td>
							<td>
								<input type="file" name="file_site_logo" id="file_site_logo"/>
								<input type="hidden" name="site_logo" id="site_logo" value="<?php echo $site_logo; ?>"/>
							</td>
							
							<td></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Fundo do site</legend>
					<table width="810" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<th width="33%"></th>
							<th width="33%">Fundo</th>
							<th width="34%"></th>
						</tr>
						<tr>
							<td><?php echo '<img style="border-style:solid; border-color:red;" src=../images/'. $site_background. ' width="100" height="90">'; ?></td>
							<td>
								<input type="file" name="file_site_background" id="file_site_background"/>
								<input type="hidden" name="site_background" id="site_background" value="<?php echo $site_background; ?>"/>
							</td>
							<td>Definir cor de fundo: <input type="color" name="site_background_color" id="site_background_color" value="<?php echo $site_background_color; ?>"/></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Cabeçalho do Site</legend>
					<table width="810" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<th width="33%"></th>
							<th width="33%">Cabeçalho</th>
							<th width="34%"></th>
						</tr>
						<tr>
							<td><?php echo '<img style="border-style:solid; border-color:red;" src=../images/'. $site_header. ' width="100" height="90">'; ?></td>
							<td>
								<input type="file" name="file_site_header" id="file_site_header"/> 
								<p style="font-weight:normal; font-size:10px;">[<b style="color:red">Resolução ideal:</b> 771 (Largura) x 276 (Altura)]</p>
								<input type="hidden" name="site_header" id="site_header" value="<?php echo $site_header; ?>"/>
							</td>
							<td></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Centro do Site</legend>
					<table width="810" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<th width="33%"></th>
							<th width="33%">Centro</th>
							<th width="34%"></th>
						</tr>
						<tr>
							<td><?php echo '<img style="border-style:solid; border-color:red;" src=../images/'. $site_center. ' width="100" height="90">'; ?></td>
							<td>
								<input type="file" name="file_site_center" id="file_site_center"/>
								<input type="hidden" name="site_center" id="site_center" value="<?php echo $site_center; ?>"/>
							</td>
							<td>Definir cor de fundo: <input type="color" name="site_center_color" id="site_center_color" value="<?php echo $site_center_color; ?>"/></td>
						</tr>
					</table>
				</fieldset>
				<fieldset><legend>Rodapé do Site</legend>
					<table width="810" border="0" cellpadding="2" cellspacing="0" align="center" style="text-align:center;">
						<tr>
							<th width="33%"></th>
							<th width="33%">Rodapé</th>
							<th width="34%"></th>
						</tr>
						<tr>
							<td><?php echo '<img style="border-style:solid; border-color:red;" src=../images/'. $site_footer. ' width="100" height="90">'; ?></td>
							<td>
								<input type="file" name="file_site_footer" id="file_site_footer"/>
								<input type="hidden" name="site_footer" id="site_footer" value="<?php echo $site_footer; ?>"/>
							</td>
							<td>Definir cor de fundo: <input type="color" name="site_footer_color" id="site_footer_color" value="<?php echo $site_footer_color; ?>"/></td>
						</tr>
					</table>
				</fieldset>
				<table width="320" border="0" align="center" cellpadding="2" cellspacing="0">
					<tr>
						<td colspan="2" align="center">Ações</td>
					</tr>
					<tr>
						<td><input type="reset" value="Limpar Campos"/></td>
						<td><input type="submit" name="Atualizar" value="Atualizar Mudanças" /></td>
					</tr>
				</table>
			</fieldset>
		</form>	
	</div>

	<?php require('incluir-rodape.php'); ?>
	
</div>
</body>
</html>