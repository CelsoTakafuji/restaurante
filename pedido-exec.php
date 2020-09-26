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
	
	require_once('auth.php');
	
	//Incluir detalhes da conexão com o banco de dados
	require_once('connection/config.php');
	
	//Conectar ao servidor MySQL
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
    if(!$link){
        die('Falha ao conectar ao servidor: ' . mysql_error());
    }
	
    //Selecionar o banco de dados
    $db = mysql_select_db(DB_DATABASE);
    if(!$db) {
        die("Não foi possível selecionar o banco de dados!");
    }
 
	//Obter id_cliente da sessão
    $id_cliente = $_SESSION['SESS_MEMBER_ID'];
	
	if(isset($_POST['enviarFormaPagto'])){
		$id_forma_pagto = htmlspecialchars(mysql_real_escape_string($_POST['id_forma_pagto']));
	}else{
		die("Falha ao adicionar informações de forma de pagamento! Por favor tente novamente após alguns minutos.");
	}
    
    if(isset($_GET['id'])){
		//Obter id_pedido
		$id_pedido = $_GET['id'];
		
		//Definir valor padrão para a flag_1
		$flag_1 = 1;
		
		//Criar a query de UPDATE (alterar flag da tabela pedidos)
		$qry_update = "UPDATE pedidos SET id_forma_pagto = '$id_forma_pagto', flag = '$flag_1' WHERE id_pedido = '$id_pedido' and id_cliente = '$id_cliente'";
		mysql_query($qry_update);
		
		if(mysql_affected_rows() > 0) {
			header("location: minha-conta.php"); 
			exit();
		}else {
			die("Um problema ocorreu com o sistema: " . mysql_error());
		}
    } else {
		die("O pedido não foi passado na URL! Por favor tente novamente após alguns minutos.");
	}
?>