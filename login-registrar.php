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
        die("Não foi possível selecionar banco de dados");
    }
    
	//recuperar perguntas da tabela perguntas
	$perguntas=mysql_query("SELECT * FROM perguntas")
	or die("Algo está errado... \n" . mysql_error());
?>
<?php
	//Configurar um cookie na memória
    if (isset($_POST['Logar'])){
        //Configurar um cookie na memória
        if($_POST['remember']) {
            $year = time() + 31536000;
            setcookie('remember_me', $_POST['login'], $year);
        }else if(!$_POST['remember']) {
            if(isset($_COOKIE['remember_me'])) {
                $past = time() - 100;
                setcookie(remember_me, gone, $past);
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $nome ?>:Login</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
</script>
</head>
<body>
<div id="page">
	<?php require('/incluir-cabecalho.php'); ?>
	
	<div id="center">
		<h1>Login/Registro</h1>
		<table align="center" border="1" width="100%">
			<tr align="center">
				<td style="text-align:center;">
					<form id="loginForm" name="loginForm" method="post" action="login-exec.php" onsubmit="return loginValidate(this)">
						<table width="290" border="1" align="center" cellpadding="2" cellspacing="0">
							<CAPTION><h2>ACESSE SUA CONTA</h2></CAPTION>
							<tr>
								<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Campos obrigatórios</td>
							</tr>
							<tr>
								<td width="40%"><b>E-mail</b></td>
								<td width="60%"><font color="#FF0000">* </font><input name="email" type="email" class="textfield" id="email" maxlength="35" placeholder="Forneça o seu e-mail" required/></td>
							</tr>
							<tr>
								<td><b>Senha</b></td>
								<td><font color="#FF0000">* </font><input name="senha" type="password" class="textfield" id="senha" maxlength="25" placeholder="Forneça a sua senha" required/></td>
							</tr>
							<tr>
								<td><input style="width:40%" name="remember" type="checkbox" class="" id="remember" value="1" onselect="cookie()" 
									<?php 
										if(isset($_COOKIE['remember_me'])) {
											echo 'checked="checked"';
										} else {
											echo '';
										}
									?> />Lembrar-me
								</td>
								<td><a href="JavaScript: resetPassword()">Esqueceu a senha?</a></td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<input style="width:125" type="reset" value="Limpar Campos"/>
									<input style="width:125" type="submit" name="Logar" value="Logar" />
								</td>
							</tr>
						</table>
					</form>
				</td>
				<hr>
				<td style="text-align:center;">
					<form id="registroForm" name="registroForm" method="post" action="registro-exec.php" onsubmit="return validarRegistro(this)">
						<table width="460" border="1" align="center" cellpadding="2" cellspacing="0">
							<CAPTION><h2>REGISTRAR UMA CONTA</h2></CAPTION>
							<tr>
								<td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Campos obrigatórios</td>
							</tr>
								<th>Nome </th>
								<td><font color="#FF0000">* </font><input name="nome" type="text" class="textfield" id="nome" maxlength="20" placeholder="Forneça o seu primeiro nome" required/></td>
							</tr>
							<tr>
								<th>Sobrenome </th>
								<td><font color="#FF0000">* </font><input name="sobrenome" type="text" class="textfield" id="sobrenome" maxlength="20" placeholder="Forneça o seu último nome" required/></td>
							</tr>
							<tr>
								<th width="124">E-mail</th>
								<td width="168"><font color="#FF0000">* </font><input name="email" type="email" class="textfield" id="email" maxlength="25" placeholder="Forneça o seu e-mail" required/></td>
							</tr>
							<tr>
								<th>Senha</th>
								<td><font color="#FF0000">* </font><input name="senha" type="password" class="textfield" id="senha" maxlength="25" placeholder="Forneça a sua senha" required/></td>
							</tr>
							<tr>
								<th>Confirmar Senha </th>
								<td><font color="#FF0000">* </font><input name="csenha" type="password" class="textfield" id="csenha" maxlength="25" placeholder="Repita a senha fornecida" required/></td>
							</tr>
							<tr>
								<th>Pergunta de Segurança </th>
								<td><font color="#FF0000">* </font>
									<select name="id_pergunta" id="id_pergunta">
										<option value="select">- Selecione a pergunta -
										<?php 
										//loop através de linhas da tabela perguntas
										while ($row=mysql_fetch_array($perguntas)){ 
											echo "<option value=$row[id_pergunta]>$row[pergunta]"; 
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<th>Resposta de segurança</th>
								<td><font color="#FF0000">* </font><input name="resposta" type="text" class="textfield" id="resposta" maxlength="15" placeholder="Insira a sua resposta" required/></td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<input type="reset" value="Limpar Campos"/>
									<input type="submit" name="Registrar" value="Registrar" />
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
		<hr>
	</div>
	
	<?php require('/incluir-rodape.php'); ?>
</div>
</body>
</html>
