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
		die("Não foi possível selecionar o banco de dados");
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
	$endereco 	= limpar($_POST['endereco']);
	$cep 		= limpar($_POST['cep']);
	$cidade 	= limpar($_POST['cidade']);
	$celular 	= limpar($_POST['celular']);
	$telefone 	= limpar($_POST['telefone']);

	//Verificar se a variável 'id' foi definida na URL
	if (isset($_GET['id']))
	{
		//Obter o valor id
		$id_cliente = $_GET['id'];

		//Criar a query para o INSERT
		$qry = "INSERT INTO enderecos (id_cliente, endereco, cep, cidade, celular, telefone) VALUES('$id_cliente','$endereco','$cep','$cidade','$celular','$telefone')";
		mysql_query($qry) or die("Você já possuí endereço cadastrado! Erro no banco: ". mysql_error()); ;
	
		//Redirecionar para a página de faturamento com sucesso
		header("Location: endereco-sucesso.php");
	}else {
		die("Falha ao adicionar informações de endereço! Por favor tente novamente após alguns minutos.");
	}
?>