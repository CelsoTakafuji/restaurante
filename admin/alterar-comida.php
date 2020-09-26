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

    if(isset($_POST['Alterar'])){
		//Limpar os valores POST
		$id_comida				= limpar($_POST['id_comida']);
		$id_categoria			= limpar($_POST['id_categoria']);
		$comida_nome 			= limpar($_POST['comida_nome']);
		$comida_descricao 		= limpar($_POST['comida_descricao']);
		$comida_preco 			= limpar($_POST['comida_preco']);

		if(!empty($_FILES['file_comida_foto']['tmp_name'])){
			//Configurar um diretório onde a localização será salva
			$target = "../images/";
			$target = $target . basename( $_FILES['file_comida_foto']['name']);			
			
			$comida_foto = limpar($_FILES['file_comida_foto']['name']);
			
			//Mover a foto para o servidor
			$mover = move_uploaded_file($_FILES['file_comida_foto']['tmp_name'], $target);
			 
			if($mover){
				//Está tudo bem
				echo "A promoção". basename( $_FILES['file_comida_foto']['name']). " foi enviada com sucesso."; 
			} else {  
				//Gerar um erro se não está tudo bem
				echo "Desculpe, houve um problema upload na localizção do seu restaurante... o erro real é"  . $_FILES["file_localizacao"]["error"]; 
			}
		}else{
			$comida_foto = limpar($_POST['comida_foto']);
		}
		
		//Atualizar
		$resultado = mysql_query("UPDATE comidas SET id_categoria = '$id_categoria', comida_nome = '$comida_nome', comida_descricao = '$comida_descricao', comida_preco = REPLACE('$comida_preco',',','.'), comida_foto = '$comida_foto' WHERE id_comida = '$id_comida'")
		or die("Algo está errado... \n". mysql_error()); 
		 
		//Verificar se a query foi executada
		if($resultado) {
			//Redirecionar para voltar para a página de opções
			header("Location: comidas.php");
			exit();
		}
		else
		// Gerar um erro
		{
			die("Falha ao alterar uma comida..." . mysql_error());
		}
    }
?>