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
		$flag_altera_senha = 0;
		$flag_altera_resposta = 0;
		
		if(isset($_POST['senha']) && $_POST['senha'] != ""){
			$senha = limpar($_POST['senha']);
			$flag_altera_senha = 1;
		}
		
		if(isset($_POST['resposta']) && $_POST['resposta'] != ""){
			$resposta = limpar($_POST['resposta']);
			$flag_altera_resposta = 1;
		}
	
		$id_cliente 	= limpar($_POST['id_cliente']);
		$nome 			= limpar($_POST['nome']);
		$sobrenome 		= limpar($_POST['sobrenome']);
		$login	 		= limpar($_POST['login']);
		$id_pergunta 	= limpar($_POST['id_pergunta']);
		
		//Atualizar
		$query = "UPDATE clientes SET nome = '$nome', sobrenome = '$sobrenome', login = '$login', id_pergunta = '$id_pergunta'";
		if($flag_altera_senha){
			$query = $query.", senha = '".md5($senha)."'";
		}
		if($flag_altera_resposta){
			$query = $query.", resposta = '".md5($resposta)."'";
		}		
		$query = $query." WHERE id_cliente = '$id_cliente'";
		
		$resultado = mysql_query($query)
		or die("Algo está errado... \n". mysql_error()); 
		 
		//Verificar se a query foi executada
		if($resultado) {
			//Redirecionar para voltar para a página de opções
			header("Location: clientes.php");
			exit();
		}
		else
		// Gerar um erro
		{
			die("Falha ao alterar um cliente..." . mysql_error());
		}
    }
?>