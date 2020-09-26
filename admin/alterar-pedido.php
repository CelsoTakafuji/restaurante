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
		   die ('O horário do pedido foi passado em um formato inválido!');
		}
		return $tempo;
	}	

	if(isset($_POST['AlterarItem'])){

		//Limpar os valores POST
		$id_pedido		= limpar($_POST['id_pedido']);
		$id_comida		= limpar($_POST['id_comida']);
		$id_quantidade 	= limpar($_POST['id_quantidade']);

		# echo "<script language='JavaScript'>alert('".$id_pedido."|".$id_comida."|".$id_quantidade."')</script>";
		
		//Obter a quantidade
		$quantidade = mysql_query("SELECT * FROM quantidades WHERE id_quantidade = '$id_quantidade'")
		or die("Algo está errado... \n". mysql_error()); 
		
		$rowqtd = mysql_fetch_assoc($quantidade);
		
		if($rowqtd['quantidade_valor'] > 0){
			//Atualizar carrinho
			$qryUpdate = mysql_query("UPDATE carrinhos SET id_quantidade = '$id_quantidade' WHERE id_pedido = '$id_pedido' AND id_comida = '$id_comida'")
			or die("Algo está errado... \n". mysql_error());
			
			//Verificar se a query foi executada
			if($qryUpdate){
				//Redirecionar para voltar para a página de pedidos
				header("Location: pedidos.php");
				exit();
			}
			else
			// Gerar um erro
			{
				die("Falha ao alterar carrinho do pedido..." . mysql_error());
			}
		}else{
			//Remover carrinho
			$qryDeleteCarrinho = mysql_query("DELETE FROM carrinhos WHERE id_pedido = '$id_pedido' AND id_comida = '$id_comida'")
			or die("Algo está errado... \n". mysql_error());
			
			//Verificar se a query foi executada
			if($qryDeleteCarrinho){
				//Contar a quantidade de carrinhos do pedido
				$qryCarrinhosPedido = mysql_query("SELECT * FROM carrinhos WHERE id_pedido = '$id_pedido'")
				or die("Algo está errado... \n". mysql_error());
				
				if(mysql_num_rows($qryCarrinhosPedido) == 0){
					//Remover pedido
					$qryDeletePedido = mysql_query("DELETE FROM pedidos WHERE id_pedido = '$id_pedido'")
					or die("Algo está errado... \n". mysql_error());
				}
				
				//Redirecionar para voltar para a página de pedidos
				header("Location: pedidos.php");
				exit();
			}
			else
			// Gerar um erro
			{
				die("Falha ao remover carrinho do pedido..." . mysql_error());
			}
		}
	}
	
    if(isset($_POST['Alterar'])){
		//Limpar os valores POST
		$id_pedido			= limpar($_POST['id_pedido']);
		$id_forma_pagto		= limpar($_POST['id_forma_pagto']);
		$data_entrega 		= formDate(limpar($_POST['data_entrega']));
		$horario_entrega 	= formTime(limpar($_POST['horario_entrega']));
		$id_funcionario 	= limpar($_POST['id_funcionario']);
		
		//Atualizar
		$resultado = mysql_query("UPDATE pedidos SET id_forma_pagto = '$id_forma_pagto', data_entrega = '$data_entrega', horario_entrega = '$horario_entrega', id_funcionario = '$id_funcionario' WHERE id_pedido = '$id_pedido'")
		or die("Algo está errado... \n". mysql_error()); 
		 
		//Verificar se a query foi executada
		if($resultado) {
			//Redirecionar para voltar para a página de pedidos
			header("Location: pedidos.php");
			exit();
		}
		else
		// Gerar um erro
		{
			die("Falha ao alterar um pedido..." . mysql_error());
		}
    }
?>