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
?>
<?php
    if(isset($_POST['Enviar'])){
        //obter e-mail
        $email = limpar($_POST['email']);
        
        //selecionar um registro específico da tabela members. Retornar um erro se não há registros na tabela
        $result=mysql_query("SELECT * FROM clientes WHERE login='$email'")
        or die("Ocorreu um erro. \n Nossa equipe está trabalhando nisso. \n Tente novamente depois de algumas horas.");
    }
?>
<?php
    if(isset($_POST['Mudar'])){
        if(trim($_SESSION['id_cliente']) != ''){
            $id_cliente=$_SESSION['id_cliente']; //obter id_cliente da sessão
            //obter resposta e a nova senha do POST
            $resposta = limpar($_POST['resposta']);
            $nova_senha = limpar($_POST['nova_senha']);
            
			 //atualizar a senha
			 $resultado = mysql_query("UPDATE clientes SET senha='".md5($_POST['nova_senha'])."' WHERE id_cliente = '$id_cliente' AND resposta = '".md5($_POST['resposta'])."'")
			 or die("Ocorreu um erro. \n Nossa equipe está trabalhando nisso. \n Tente novamente depois de alguns minutos.");
			 
			 if(mysql_affected_rows() > 0){
				unset($_SESSION['id_cliente']);
				header("Location: resetar-sucesso.php"); //redirecionar para sucesso         
			 }else{
				unset($_SESSION['id_cliente']);
				header("Location: resetar-falhou.php"); //redirecionar para falhou
			 }
		}else{
			unset($_SESSION['id_cliente']);
			header("Location: resetar-falhou.php"); //redirecionar para falhou
		}
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $nome ?>:Resetar Senha</title>
<link href="stylesheets/user_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/user.js">
</script>
</head>
<body>
<div id="reset">
  <div style="border:#bd6f2f solid 1px;padding:4px 6px 2px 6px">
  <form name="resetForm" id="resetForm" method="post" action="resetar-senha.php" onsubmit="return validarResetSenha(this)">
     <table width="360" border="1" style="text-align:center;">
     <tr>
        <th>Conta de E-mail</th>
        <td width="168"><input name="email" type="email" class="textfield" id="email" maxlength="35" placeholder="Digite um e-mail registrado" required/></td>
        <td><input type="submit" name="Enviar" value="Checar" /></td>
     </tr>
     </table>
 </form>
  <?php
    if(isset($_POST['Enviar'])){
        $row=mysql_fetch_assoc($result);
        $_SESSION['id_cliente'] = $row['id_cliente']; //criar uma sessão contendo id_cliente
        session_write_close(); //sessão fechada
        $id_pergunta = $row['id_pergunta'];
        
        //obter texto da pergunta com base em id_pergunta na tabela perguntas
        $perguntas=mysql_query("SELECT * FROM perguntas WHERE id_pergunta = '$id_pergunta'")
        or die("Ocorreu um problema. \n Nossa equipe está trabalhando nisso. \n Tente novamente depois de algumas horas.");
        
        $pergunta_row=mysql_fetch_assoc($perguntas);
        $pergunta = $pergunta_row['pergunta'];
        if($pergunta != ""){
            echo "<b>Seu código de identificação:</b> ".$_SESSION['id_cliente']."<br>";
            echo "<b>Sua pergunta de segurança:</b> ".$pergunta;
        }
        else{
            echo "<b>A sua pergunta de segurança: </b> ESTA CONTA NÃO EXISTE! POR FAVOR VERIFIQUE O SEU E-MAIL E TENTE NOVAMENTE.";
        }
    }
  ?>
  <hr>
  <form name="resetForm" id="resetForm" method="post" action="resetar-senha.php" onsubmit="return validarResetSenha2(this)">
     <table width="360" border="1" style="text-align:center;">
     <tr>
        <td colspan="2" style="text-align:center;"><font color="#FF0000">* </font>Campos obrigatórios</td>
     </tr>
     <tr>
        <th>Sua Resposta de Segurança</th>
        <td width="168"><font color="#FF0000">* </font><input name="resposta" type="text" class="textfield" id="resposta" maxlength="15" placeholder="Forneça a resposta registrada" required/></td>
     </tr>
     <tr>
        <th>Nova Senha</th>
        <td width="168"><font color="#FF0000">* </font><input name="nova_senha" type="password" class="textfield" id="nova_senha" maxlength="25" placeholder="Forneça a nova senha" required/></td>
     </tr>
     <tr>
        <th>Confirmar Nova senha</th>
        <td width="168"><font color="#FF0000">* </font><input name="cnova_senha" type="password" class="textfield" id="cnova_senha" maxlength="25" placeholder="repita a sua nova senha" required/></td>
     </tr>
     <tr>
        <td colspan="2">
			<input type="reset" name="Reset" value="Limpar Campos" />
			<input type="submit" name="Mudar" value="Mudar senha" />
		</td>
     </tr>
     </table>
 </form>
  </div>
  </div>
</body>
</html>