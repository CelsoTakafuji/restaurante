<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
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
	
	//Limpar os valores POST	
	$senhaantiga 	= limpar($_POST['senhaantiga']);
	$senhanova 		= limpar($_POST['senhanova']);
	$senhanovaconf 	= limpar($_POST['senhanovaconf']);
	
     //Verificar se a variável 'id' foi definida em URL
     if (isset($_GET['id']))
     {
         //Obter o valor da id
         $id_cliente = $_GET['id'];
         
         //Obter o usuário
         $result = mysql_query("UPDATE clientes SET senha = '".md5($_POST['senhanova'])."' WHERE id_cliente = '$id_cliente' AND senha = '".md5($_POST['senhaantiga'])."'")
		           or die("Alteração de senha falhou! Por favor tente novamente após alguns minutos"); 
		 
         if(mysql_affected_rows() > 0){
            //Atualizar e redirecionar para voltar a página de perfil
            header("Location: resetar-sucesso.php");
         }
         else{
            header("Location: resetar-falhou.php"); // falha ao redefinir senha
         }
     }else
     // se o id não está definido, gerar um erro
     {
        die("Alteração de senha falhou! Por favor tente novamente após alguns minutos!");
     } 
?>