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
?>
<?php
    //Recuperar todos os registros da tabela modelo
    $modelo = mysql_query("SELECT * FROM modelo");
	if ($modelo){
		//Buscar modelo em uma matriz
		$modelo_ativo = mysql_fetch_array($modelo);
		//Inicializando diretamente variáveis com valores do modelo com base nos campos
		$logo 				= $modelo_ativo['site_logo'];
		$background 		= $modelo_ativo['site_background'];
		$header 			= $modelo_ativo['site_header'];
		$center 			= $modelo_ativo['site_center'];
		$footer 			= $modelo_ativo['site_footer'];
		$background_color 	= $modelo_ativo['site_background_color'];
		$center_color 		= $modelo_ativo['site_center_color'];
		$footer_color 		= $modelo_ativo['site_footer_color'];
	}else{
		die("Algo deu errado ao carregar modelo... O erro MySql é: " . mysql_error());
	}
?>