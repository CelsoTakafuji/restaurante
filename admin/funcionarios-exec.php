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
	
	//Limpar valores POST 
	$nome 		= limpar($_POST['nome']);
	$sobrenome 	= limpar($_POST['sobrenome']);
	$endereco 	= limpar($_POST['endereco']);
	$celular 	= limpar($_POST['celular']);
	
	//Criar a query INSERT
	$qry = "INSERT INTO funcionarios (nome, sobrenome, endereco, celular) VALUES ('$nome','$sobrenome','$endereco','$celular')";
	$resultado = @mysql_query($qry);
	
	//Verificar se a query foi bem sucedida ou não
	if($resultado) {
		echo "<html><script language='JavaScript'>alert('Informações dos funcionários adicionadas com sucesso.')</script></html>";
		header('Location: funcionarios-alocacao.php');
		exit();
	}else {
		die("Falha ao adicionar informações da equipe... " . mysql_error());
	}
?>