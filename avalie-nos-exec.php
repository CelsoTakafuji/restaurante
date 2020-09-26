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
		
	//Verificar se foi requisitado um enviarAvaliacao
	if(isset($_POST['enviarAvaliacao']))
	{
	    $id_cliente = $_SESSION['SESS_MEMBER_ID']; //obter id_cliente da sessão
        $id_comida = limpar($_POST['id_comida']); //obter id_comida e limpar valor do post
        $id_classificacao = limpar($_POST['id_classificacao']); //obter id_classificacao e limpar valor do post
        
        //Verificar se existe duplicação na tabela de sondagens detalhes
        $check = mysql_query("SELECT * FROM avaliacoes WHERE id_cliente = '$id_cliente' AND id_comida = '$id_comida'") 
		or die("Ocorreu um erro. \n Nossa equipe está trabalhando nisso. \n Tente novamente depois de alguns minutos.");
        
        if(mysql_num_rows($check)>0){
            header("location: avalie-nos-falhou.php");
        }else{
	        //Criar a query INSERT
	        $qry = "INSERT INTO avaliacoes (id_cliente,id_comida,id_classificacao) VALUES('$id_cliente','$id_comida','$id_classificacao')";
	        mysql_query($qry);
	        
            if(mysql_affected_rows() > 0){
	            header("location: avalie-nos-sucesso.php");
            }
            else{
                die("Avaliação falhou! Por favor, tente novamente após alguns minutos.");
            }
        }

	}else {
		die("Avaliação falhou! Por favor, tente novamente após alguns minutos.");
	}
?>