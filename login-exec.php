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
        die("Não foi possível selecionar banco de dados");
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
	$login = limpar($_POST['email']);
	$senha = limpar($_POST['senha']);
	
	//Criar a query
	$qry="SELECT * FROM clientes WHERE login = '$login' AND senha = '".md5($_POST['senha'])."'";
	$resultado=mysql_query($qry);
	
	//Verifique se a consulta foi bem sucedida ou não
	if($resultado) {
		if(mysql_num_rows($resultado) == 1) {
			//Login bem-sucedido
			session_regenerate_id();
			$cliente = mysql_fetch_assoc($resultado);
			$_SESSION['SESS_MEMBER_ID']  = $cliente['id_cliente'];
			$_SESSION['SESS_FIRST_NAME'] = $cliente['nome'];
			$_SESSION['SESS_LAST_NAME']  = $cliente['sobrenome'];
			$_SESSION['SESS_EMAIL'] 	 = $cliente['login'];
			session_write_close();
			header("location: minha-conta.php");
			exit();
		}else {
			//Falha na autenticação
			header("location: login-falhou.php");
			exit();
		}
	}else {
		die("Consulta falhou");
	}
?>