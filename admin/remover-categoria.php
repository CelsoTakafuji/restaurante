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
    
    //Função para limpar os valores recebidos do formulário. Impede SQL Injection
    function limpar($str) {
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysql_real_escape_string($str);
    }
    
    //Verificar se Remover está contido no POST
    if (isset($_POST['Remover'])){
        //Obter o valor do ID de categoria e limpar os valores POST
        $id_categoria = limpar($_POST['id_categoria']);
         
        //Excluir a entrada
        $resultado = mysql_query("DELETE FROM categorias WHERE id_categoria = '$id_categoria'")
        or die("Houve um problema ao excluir a categoria... \n" . mysql_error()); 
         
        //Redirecionar de volta para opções
        header("Location: opcoes.php");
		exit();
    }
 
     //Verificar se a variável 'id' foi definida em URL
     if(isset($_GET['id']))
     {
         //Obter o valor id
         $id = $_GET['id'];
         
         //Excluir a entrada
         $resultado = mysql_query("DELETE FROM categorias WHERE id_categoria = '$id'")
         or die("Houve um problema ao excluir a categoria... \n" . mysql_error()); 
         
         //Redirecionar de volta para as categorias
         header("Location: categorias.php");
		 exit();
     }
     else
     //Se o id não está definido, redirecionar de volta para as categorias
     {
        header("Location: categorias.php");
		exit();
     }
 
?>