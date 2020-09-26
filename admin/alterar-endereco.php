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
    
    if(isset($_POST['Alterar'])){
		//Limpar os valores POST
		$id_endereco 	= limpar($_POST['id_endereco']);
		$id_cliente 	= limpar($_POST['id_cliente']);
		$endereco 		= limpar($_POST['endereco']);
		$cep 			= limpar($_POST['cep']);
		$cidade	 		= limpar($_POST['cidade']);
		$celular 		= limpar($_POST['celular']);
		$telefone 		= limpar($_POST['telefone']);
		
		//Atualizar
		$resultado = mysql_query("UPDATE enderecos SET id_cliente = '$id_cliente', endereco = '$endereco', cep = '$cep', cidade = '$cidade', celular = '$celular', telefone = '$telefone' WHERE id_endereco = '$id_endereco'")
		or die("Algo está errado... \n". mysql_error()); 
		 
		//Verificar se a query foi executada
		if($resultado) {
			//Redirecionar para voltar para a página de opções
			header("Location: clientes.php?id=".$id_cliente);
			exit();			
		}
		else
		// Gerar um erro
		{
			die("Falha ao alterar um endereço..." . mysql_error());
		}
    }
?>