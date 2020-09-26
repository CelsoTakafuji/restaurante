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
	
	//Configurar charset do banco de dados
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
	
	//Limpar valores POST 
	$senha 			= limpar($_POST['senha']);
	$senhanova 		= limpar($_POST['senhanova']);
	$senhanovaconf 	= limpar($_POST['senhanovaconf']);
	
     //Verificar se a variável 'id' foi passada na URL
     if (isset($_GET['id']))
     {
        //Obter o valor da id
        $id = $_GET['id'];
         
        //Atualizar
        $result = mysql_query("UPDATE admin SET senha = '".md5($senhanova)."' WHERE id_admin = '$id' AND senha = '".md5($senha)."'")
        or die("O administrador não existe... \n". mysql_error()); 		 
		
        //Redirecionar de volta para a página de perfil
        header("Location: admins.php?sucesso=1");
     }
     else
     //Se o id não foi definido, lançar um erro
     {
        die("Falha ao alterar a senha... O id não foi passado na URL.");
     }
 
?>