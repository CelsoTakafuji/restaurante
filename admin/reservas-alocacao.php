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
	
	//Limpar os valores POST 
	$id_reserva 	= limpar($_POST['id_reserva']);
	$id_funcionario = limpar($_POST['id_funcionario']);
	
    //Definir o valor padrão para a flag_1
    $flag_1 = 1;
 
     //Atualizar a entrada
     $resultado = mysql_query("UPDATE reservas SET id_funcionario = '$id_funcionario', flag='$flag_1' WHERE id_reserva = '$id_reserva'")
     or die("A reserva ou o funcionário não existe... \n" . mysql_error()); 
     
     //Verificar se consulta foi executada
     if($resultado) {
		 //Redirecionar de volta para a página de alocação
		 header("Location: funcionarios-alocacao.php");
		 exit();
     }
     else
     //Lançar um erro
     {
		die("Alocação de reserva falhou..." . mysql_error());
     }
 
?>