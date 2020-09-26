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
	
	//Configurar charset do banco de dados
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');	
	
	//Função para formatar data timestamp
	function formDate($data){
		$timestamp = explode(" ",$data);
		$getData = $timestamp[0];
		$getTime = $timestamp[1];
		
		$setData = explode('/',$getData);
		$dia = $setData[0];
		$mes = $setData[1];
		$ano = $setData[2];
		
		$res = checkdate($mes,$dia,$ano);
		if ($res != 1){
		   die ('A data foi passada em um formato inválido!');
		}
		
		if(!$getTime):
			$getTime = date('H:i:s');
		endif;

		$resultado = $ano.'-'.$mes.'-'.$dia.' '.$getTime;
		
		return $resultado;
	}
    
    //Configurar um diretório onde as imagens serão salvas
    $target = "../images/"; 
    $target = $target . basename( $_FILES['file_promocao_foto']['name']); 
    
    //Limpar valores POST 
    $promocao_nome		 	= limpar($_POST['promocao_nome']);
    $promocao_descricao 	= limpar($_POST['promocao_descricao']);
    $promocao_preco 		= limpar($_POST['promocao_preco']);
    $promocao_data_inicio 	= formDate(limpar($_POST['promocao_data_inicio']));
    $promocao_data_fim 		= formDate(limpar($_POST['promocao_data_fim']));
    $promocao_foto 			= limpar($_FILES['file_promocao_foto']['name']);

    //Criar a query INSERT
    $qry = "INSERT INTO promocoes (promocao_nome, promocao_descricao, promocao_preco, promocao_data_inicio, promocao_data_fim, promocao_foto) VALUES('$promocao_nome','$promocao_descricao',REPLACE('$promocao_preco',',','.'),'$promocao_data_inicio','$promocao_data_fim','$promocao_foto')";
    $resultado = @mysql_query($qry);
    
    //Verificar se a query foi bem sucedida ou não
    if($resultado) {
         //Mover a foto para o servidor
         $mover = move_uploaded_file($_FILES['file_promocao_foto']['tmp_name'], $target);
         
         if($mover) 
         {      
            //Está tudo bem
            echo "A foto ". basename( $_FILES['file_promocao_foto']['name']). "foi carregada, e sua informação foi adicionada ao diretório"; 
         } else {  
            //Lançar um erro se não está tudo bem
            echo "Desculpe, houve um problema ao enviar sua foto. "  . $_FILES["file_promocao_foto"]["error"]; 
         }
        header("location: promocoes.php");
        exit();
    }else {
        die("Query falhou... " . mysql_error());
    } 
 ?>