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
	
	//Função para formatar data timestamp
	function formDate($data){
		$timestamp = explode(" ",$data);
		$getData = $timestamp[0];
		$getTime = $timestamp[1];
		
		$setData = explode('/',$getData);
		$dia = $setData[0];
		$mes = $setData[1];
		$ano = $setData[2];
		
		$res = checkdate($mes,$dia,$ano);
		if ($res != 1){
		   die ('A data foi passada em um formato inválido!');
		}
		
		if(!$getTime):
			$getTime = date('H:i:s');
		endif;

		$resultado = $ano.'-'.$mes.'-'.$dia.' '.$getTime;
		
		return $resultado;
	}
	
	//Função para validar o tempo
	function checkTime($hour, $minute, $second) 
	{
		return $hour >= 0 && $hour < 24 && $minute >= 0 && $minute < 60 && $second >= 0 && $second < 60;
	}
	
	//Função para formatar tempo
	function formTime($tempo){
		$setData = explode(':',$tempo);
		$h = $setData[0];
		$m = $setData[1];
		$s = $setData[2];
		
		$res = checkTime($h, $m, $s);
		if ($res != 1){
		   die ('O horário da reserva foi passado em um formato inválido!');
		}
		return $tempo;
	}
	
	//Limpar os valores POST
    $id_salao_festas = 0;
    $id_mesa = 0;
    $flag_salao_festas = 0;
    $flag_mesa = 0;
    
    if(isset($_POST['id_mesa'])){
        $id_mesa = limpar($_POST['id_mesa']);
        $flag_mesa = 1;
    }
    else if(isset($_POST['id_salao_festas'])){
        $id_salao_festas = limpar($_POST['id_salao_festas']);
        $flag_salao_festas = 1;
    }
    
	$id_cliente 	= limpar($_POST['id_cliente']);
	$reserva_data 	= formDate(limpar($_POST['reserva_data']));
	$reserva_tempo 	= formTime(limpar($_POST['reserva_tempo']));
	
	//Verificar se o id foi definido no link
	if (isset($_GET['id'])){
	    
	    //Criar a query de INSERT
	    $qry = "INSERT INTO reservas (id_cliente, id_mesa, id_salao_festas, reserva_data, reserva_tempo, flag_mesa, flag_salao_festas) VALUES('$id_cliente','$id_mesa','$id_salao_festas','$reserva_data','$reserva_tempo','$flag_mesa','$flag_salao_festas')";
	    
		mysql_query($qry) or die ('Erro ao cadastrar em reservas. Erro: '.mysql_error());
		
		if(mysql_affected_rows() > 0) {
			//Redirecionar para a página de reserva com sucesso
			header("location: reservas.php");
		}else{
			die ('Erro ao cadastrar em reservas.');
		}
		
	}else {
		die("A reserva falhou! Por favor tente novamente após alguns minutos.");
	}
?>