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
	
	//Matriz para armazenar os erros de validação
	$errmsg_arr = array();
	
	//Flag de erro de validação
	$errflag = false;
	
	//Limpar os valores POST
	$usuario = limpar($_POST['usuario']);
	$senha   = limpar($_POST['senha']);
	
	//As validações de entrada
	if($usuario == '') {
		$errmsg_arr[] = 'Nome de utilizador ausente';
		$errflag = true;
	}
	if($senha == '') {
		$errmsg_arr[] = 'Senha ausente';
		$errflag = true;
	}
	
	//Se houver validações de entrada, redirecionar de volta para o formulário de login
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: login-form.php");
		exit();
	}
	
	//Criar a query
	$qry = "SELECT * FROM admin WHERE usuario = '$usuario' AND senha = '".md5($senha)."'";
	$resultado = mysql_query($qry);
	
	//Verificar se a consulta foi bem sucedida ou não
	if($resultado) {
		if(mysql_num_rows($resultado) == 1) {
			//Login bem-sucedido
			session_regenerate_id();
			$admin = mysql_fetch_assoc($resultado);
			$_SESSION['SESS_ADMIN_ID']   = $admin['id_admin'];
			$_SESSION['SESS_ADMIN_NAME'] = $admin['usuario'];
			session_write_close();
			header("location: index.php");
			exit();
		}else {
			//Login falhou
			header("location: login-falhou.php");
			exit();
		}
	}else {
		die("Consulta falhou");
	}
?>