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
	
    //Configurar um diretório onde as imagens serão salvas
    $target = "../images/"; 
    $target = $target . basename( $_FILES['comida_foto']['name']); 
    
    //Limpar os valores POST
    $comida_nome 		= limpar($_POST['comida_nome']);
    $comida_descricao 	= limpar($_POST['comida_descricao']);
    $comida_preco 		= limpar($_POST['comida_preco']);
    $id_categoria 		= limpar($_POST['id_categoria']);
    $comida_foto 		= limpar($_FILES['comida_foto']['name']);

    //Criar a query INSERT
    $qry = "INSERT INTO comidas (comida_nome, comida_descricao, comida_preco, comida_foto, id_categoria) VALUES('$comida_nome','$comida_descricao','$comida_preco','$comida_foto','$id_categoria')";
    $resultado = @mysql_query($qry);
    
    //Verifique se a query foi bem sucedida ou não
    if($resultado) {
        //Mover a foto para o servidor
        $mover = move_uploaded_file($_FILES['comida_foto']['tmp_name'], $target);
         
        if($mover) 
        {      
            //Está tudo bem
            echo "A foto ". basename( $_FILES['comida_foto']['name']). "foi carregada, e sua informação foi adicionada ao diretório"; 
        } else {  
            //Gerar um erro se não está tudo bem
            echo "Desculpe, houve um problema ao enviar sua foto: ". $_FILES["comida_foto"]["error"]; 
        }
        header("Location: comidas.php");
        exit();
    }else {
        die("Query falhou " . mysql_error());
    } 
 ?>