<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
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
	
	//Configurar charset do banco de dados
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');	
	
	//Limpar os valores POST
	$nome 			= limpar($_POST['nome']);
	$sobrenome 		= limpar($_POST['sobrenome']);
	$email 			= limpar($_POST['email']);
	$senha		 	= limpar($_POST['senha']);
	$csenha 		= limpar($_POST['csenha']);
    $id_pergunta 	= limpar($_POST['id_pergunta']);
    $resposta 		= limpar($_POST['resposta']);
    
    //Verificar se uma conta com um determinado e-mail existe
    $qry_select="SELECT * FROM clientes WHERE login='$email'";
    $result_select=mysql_query($qry_select);
    if(mysql_num_rows($result_select)>0){
        header("location: registro-falhou.php");
        exit();
    }
    else{
	    //Criar a query para INSERT
	    $qry = "INSERT INTO clientes (nome, sobrenome, login, senha, id_pergunta, resposta) VALUES ('$nome','$sobrenome','$email','".md5($_POST['senha'])."','$id_pergunta','".md5($_POST['resposta'])."')";
	    $resultado = @mysql_query($qry);
	    
	    //Verificar se a query foi bem sucedida ou não
	    if($resultado) {
		    header("location: registro-sucesso.php");
		    exit();
	    }else {
			die("Algo deu errado. \n Nossa equipe está trabalhando nisso. \n Tente novamente depois de alguns minutos.");
	    }
    }
?>