﻿<?
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
 
    //Verificar se a variável 'id' foi definida em URL
    if (isset($_GET['id']))
    {
		//Obter o valor id
		$id_funcionario = $_GET['id'];
		 
		//Excluir a entrada
		$resultado = mysql_query("DELETE FROM funcionarios WHERE id_funcionario = '$id_funcionario'")
		or die("Houve um problema ao excluir funcionário... \n"); 
		 
        //Redirecionar de volta para a página de alocações de funcionários
		header("Location: funcionarios-alocacao.php");
    }
    else
    //Se o id não está definido, redirecionar de volta para a página de alocações de funcionários
    {
		header("Location: funcionarios-alocacao.php");
    }
 
?>