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
	
	// Recuperar um fuso horário a partir da tabela fusos_horarios
	// definir um valor padrão para flag_1
    $flag_1 = 1;
    $fusos_horarios = mysql_query("SELECT * FROM fusos_horarios WHERE flag = '$flag_1'")
    or die("Algo está errado. ".mysql_error());
    
    $row = mysql_fetch_assoc($fusos_horarios); //obtém linha recuperada
    
    $fusos_horario_referencia = $row['fusos_horario_referencia']; //obtém fuso horário ativo
    
    date_default_timezone_set($fusos_horario_referencia); //define o fuso horário padrão para uso
    
    $data_corrente = date("Y-m-d"); //obtém a data atual
    
    $tempo_corrente = date("H:i:s"); //obtém a hora atual
    
	//Limpar os valores POST
    $mensagem_assunto = limpar($_POST['mensagem_assunto']);
	$mensagem_texto   = limpar($_POST['mensagem_texto']);
	$id_cliente 	  = 0;
	
	if(isset($_POST['id_cliente'])){
		$id_cliente = limpar($_POST['id_cliente']);
	}
    
    $mensagem_de = "administrator"; //define padrão para o administrador (que pode ser alterada, se PM for implementada no futuro)
	
     //Atualizar a entrada
     $resultado = mysql_query("INSERT INTO mensagens (mensagem_de, mensagem_data, mensagem_tempo, mensagem_assunto, mensagem_texto, id_cliente) VALUES('$mensagem_de','$data_corrente','$tempo_corrente','$mensagem_assunto','$mensagem_texto', '$id_cliente')")
     or die("O envio da mensagem falhou..." . mysql_error()); 
 
     if($resultado){
         //Redirecionar de volta para a página de mensagens
         header("Location: mensagens.php");
         exit();
     }
     else
     //Se não forem enviados, dar um erro
     {
        die("O envio da mensagem falhou..." . mysql_error());
     }
?>