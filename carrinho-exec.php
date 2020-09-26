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
    
    //Incluir detalhes da sessão
    require_once('auth.php');
    
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
	
	//Definir valor padrão para as flag_0 e flag_1
	$flag_0 = 0;
	$flag_1 = 1;
	
	//Obter id_cliente da sessão
	$id_cliente = $_SESSION['SESS_MEMBER_ID'];
	
	//Verificar se o cliente tem uma configuração de endereço de cobrança 
	//Obter registro da tabela enderecos com base no id_cliente em auth.php
	$qry_select = mysql_query("SELECT * FROM enderecos WHERE id_cliente = '$id_cliente'")
	or die("O sistema está com problemas técnicos. \n Nossa equipe está trabalhando nisso. \n Tente novamente depois de alguns poucos minutos.");
			
    
    //Verificar se o id da comida foi definido na url
    if(mysql_num_rows($qry_select) > 0 && isset($_GET['id'])){

		//Obter o valor da id
		$id_comida = $_GET['id'];
	
		$qryPedidos =  mysql_query("SELECT * FROM pedidos, carrinhos, quantidades WHERE pedidos.id_pedido = carrinhos.id_pedido AND carrinhos.id_quantidade = quantidades.id_quantidade AND pedidos.id_cliente = '$id_cliente' AND pedidos.flag = '$flag_0'")
		or die("Algo está errado... \n" . mysql_error()); 
			
		if(mysql_num_rows($qryPedidos) > 0){
			
			$rowPedidos = mysql_fetch_assoc($qryPedidos);
			
			$qryPedidosUpd =  mysql_query("SELECT * FROM pedidos, carrinhos, quantidades WHERE pedidos.id_pedido = carrinhos.id_pedido AND carrinhos.id_quantidade = quantidades.id_quantidade AND pedidos.id_cliente = '$id_cliente' AND carrinhos.id_comida = '$id_comida' AND pedidos.flag = '$flag_0'")
			or die("Algo está errado... \n" . mysql_error()); 
			
			if(mysql_num_rows($qryPedidosUpd) > 0){
				//Recuperar a quantidade indicada na tabela quantidades
				$quantidades = mysql_query("SELECT * FROM quantidades WHERE quantidade_valor = '$rowPedidos[quantidade_valor]'")
				or die("Algo está errado... \n" . mysql_error()); 
			
				$rowQtd = mysql_fetch_assoc($quantidades);
				$quantidade_valor = $rowQtd['quantidade_valor'] + 1;
				
				//Criar a query UPDATE carrinhos
				$qryUpdCarrinhos = "UPDATE carrinhos SET id_quantidade = '$quantidade_valor' WHERE carrinhos.id_pedido = '$rowPedidos[id_pedido]' AND carrinhos.id_comida = '$rowPedidos[id_comida]'";
				$resultadoUpdCarrinhos = @mysql_query($qryUpdCarrinhos);
			}else{
				//recuperar a primeira quantidade indicada na tabela quantidades
				$quantidades = mysql_query("SELECT * FROM quantidades WHERE id_quantidade = 1")
				or die("Algo está errado... \n" . mysql_error()); 
				
				$rowQtd = mysql_fetch_assoc($quantidades);
				$quantidade_valor = $rowQtd['quantidade_valor'];
				
				//Criar a query INSERT carrinhos
				$qryInsCarrinhos = "INSERT INTO carrinhos (id_pedido, id_comida, id_quantidade) VALUES ('$rowPedidos[id_pedido]', '$id_comida', '$quantidade_valor')";
				$resultadoInsCarrinhos = @mysql_query($qryInsCarrinhos);
			}
			
			//Verificar se a query foi bem sucedida ou não
			if(mysql_affected_rows() > 0) {
				header("location: carrinho.php");
				exit();
			}else {
				die("Um problema ocorreu com o sistema: " . mysql_error());
			}
		}else{
			//recuperar a primeira quantidade indicada na tabela quantidades
			$quantidades = mysql_query("SELECT * FROM quantidades WHERE id_quantidade = 1")
			or die("Algo está errado... \n" . mysql_error()); 
			
			$rowQtd = mysql_fetch_assoc($quantidades);
			$quantidade_valor = $rowQtd['quantidade_valor'];
			
			//recuperar comida_preco da tabela comidas de acordo com o id da comida
			$resultado = mysql_query("SELECT * FROM comidas WHERE id_comida = '$id_comida'") 
			or die("Ocorreu um problema... \n" . "Nossa equipe está trabalhando nisso neste momento... \n" . "Por favor, volte depois de algumas horas."); 
			$comida_row  = mysql_fetch_assoc($resultado);
			$comida_preco = $comida_row['comida_preco'];
			
			//definir os valores padrão para a id_quantidade (1º registro da tabela)
			$id_quantidade = $rowQtd['id_quantidade'];

			//Recuperar um fuso horário da tabela fusos_horarios
			$fusohorario = mysql_query("SELECT * FROM fusos_horarios WHERE flag='$flag_1'")
			or die("O sistema está com problemas técnicos. \n Nossa equipe está trabalhando nisso. \n Tente novamente depois de alguns poucos minutos.");
			
			$rowFuso = mysql_fetch_assoc($fusohorario); //obter linha recuperada
			
			$fuso_referencia_ativa = $rowFuso['fuso_horario_referencia']; //obter fuso horário ativo
			
			date_default_timezone_set($fuso_referencia_ativa); //definir o fuso horário padrão para uso
			
			$time_stamp = date("H:i:s"); //obter a hora atual
			
			$delivery_date = date("Y-m-d"); //obter a data atual
			
			//Armazenar o id_endereco em uma variável
			$rowEndereco = mysql_fetch_array($qry_select);
			$id_endereco = $rowEndereco['id_endereco'];
			
			//criar a query INSERT pedidos
			$qryInsPedidos = "INSERT INTO pedidos (id_cliente, id_endereco, id_funcionario, id_forma_pagto, data_entrega, horario_entrega, flag) VALUES ('$id_cliente', '$id_endereco', '', '', '$delivery_date', '$delivery_date', '$flag_0')";
			$resultadoInsPedidos = @mysql_query($qryInsPedidos);
			
			//verificar se a query foi bem sucedida ou não
			if(mysql_affected_rows() == 0) {
				die("Um problema ocorreu com o sistema: " . mysql_error());
			}	
			
			//criar a query INSERT carrinhos
			$qryInsCarrinhos = "INSERT INTO carrinhos (id_pedido, id_comida, id_quantidade) VALUES (". mysql_insert_id() .", '$id_comida', '$id_quantidade')";
			$resultadoInsCarrinhos = @mysql_query($qryInsCarrinhos);
			
			//verificar se a query foi bem sucedida ou não
			if(mysql_affected_rows() > 0) {
				header("location: carrinho.php");
				exit();
			}else {
				die("Um problema ocorreu com o sistema: " . mysql_error());
			}
		}
	}else{
		header("location: endereco-cadastro.php"); //redireciona para endereco-cadastro.php se não estiver configurado
	}
 ?>