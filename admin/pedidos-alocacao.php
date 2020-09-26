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
    
    //Definir o valor padrão para a flag_1
    $flag_1 = 1;
	
	//Limpar os valores POST
	$id_pedido 		= limpar($_POST['id_pedido']);
	$id_funcionario = limpar($_POST['id_funcionario']);
	
 
     //Atualizar a entrada
     $resultado = mysql_query("UPDATE pedidos SET id_funcionario = '$id_funcionario', flag='$flag_1' WHERE id_pedido = '$id_pedido'")
     or die("A encomenda ou o funcionário não existe... \n" . mysql_error()); 
     
     //Verificar se consulta foi executada
     if($resultado) {
		 //Redirecionar de volta para a página funcionarios-alocacao.php
		 header("Location: funcionarios-alocacao.php");
		 exit();
     }
     else
     //Lançar um erro
     {
		die("Alocação de encomendas falhou..." . mysql_error());
     }
 
?>