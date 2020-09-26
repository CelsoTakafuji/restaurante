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
	
	// Recuperar um fuso horário a partir dos fusos horários da tabela 
	// definir um valor padrão para flag_1
    $flag_1 = 1;
    $fusos_horarios=mysql_query("SELECT * FROM fusos_horarios WHERE flag='$flag_1'")
    or die("Something is wrong. ".mysql_error());
    
    $row=mysql_fetch_assoc($fusos_horarios); //obtém linha recuperada
    
    $referencia_ativa = $row['fuso_horario_referencia']; //recebe fuso horário ativo
    
    date_default_timezone_set($referencia_ativa); //define o fuso horário padrão para uso
    
    $data_corrente = date("Y-m-d"); //obtém a data atual
    
    $tempo_corrente = date("H:i:s"); //obtém a hora atual
    
	//Limpar os valores POST
	$new_flag 		 = limpar(1);
	$new_nome 		 = limpar($_POST['nome']);
    $new_sobrenome 	 = limpar($_POST['sobrenome']);
	$new_email 		 = limpar($_POST['email']);
    $new_assunto 	 = limpar($_POST['assunto']);
	$new_mensagem 	 = limpar($_POST['txtmensagem']);
    $id_cliente      = limpar($_POST['id_cliente']);
	$new_mensagem_de = $new_nome." ". $new_sobrenome;
	
     //atualizar a entrada
     $resultado = mysql_query("INSERT INTO mensagens (mensagem_de, mensagem_email, mensagem_data, mensagem_tempo, mensagem_assunto, mensagem_texto, mensagem_flag, id_cliente) VALUES ('$new_mensagem_de','$new_email','$data_corrente','$tempo_corrente','$new_assunto','$new_mensagem','$new_flag', '$id_cliente')")
     or die("O envio da mensagem falhou... \n" . "Nossa equipe está trabalhando nisso neste momento... \n" . "Por favor, volte depois de algumas horas."); 
 
     if(mysql_affected_rows() > 0){
         // redirecionar de volta para a página de contato
         header("Location: contatos.php?msgenviada=true");
         exit();
     }
     else
     //se não forem enviados, dar um erro
     {
        die("O envio da mensagem falhou..." . mysql_error() . "... Nossa equipe está trabalhando na solução do problema!");
     }
?>