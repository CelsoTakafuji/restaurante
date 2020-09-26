<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
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
 
	//verificar se a variável 'id' foi definida na URL
	if (isset($_GET['id'])) {
		//obter o valor da id
		$id = $_GET['id'];
		 
		//excluir a entrada
		$result = mysql_query("DELETE FROM orders_details WHERE order_id='$id'")
		or die("A ordem não existe... \n"); 
		 
		//redirecionar volta ao member-index
		header("Location: member-index.php");
	 }else{
		//se o id não está definido, redirecionar voltar ao member-index
		header("Location: member-index.php");
	 }
?>