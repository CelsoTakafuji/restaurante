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
    
    if(isset($_POST['Alterar'])){
        //definir os valores padrão para as flag_0 e flag_1
        $flag_0 = 0;
        $flag_1 = 1;
        
        //verificar se há uma moeda ativa
        $qry = mysql_query("SELECT * FROM moedas WHERE flag = '$flag_1'") or die("Algo está errado... \n" . mysql_error()); 
        
		if(mysql_num_rows($qry) > 0){
            $row = mysql_fetch_assoc($qry);
            $id_moeda = $row['id_moeda'];
			
            //atualizar a entrada com uma flag de desativação
            $resultado = mysql_query("UPDATE moedas SET flag = '$flag_0' WHERE id_moeda = '$id_moeda'")
			or die("Algo está errado... \n". mysql_error());
            
            //Executar a ativação de outra moeda
                
            //Limpar os valores POST
			$id_moeda = limpar($_POST['id_moeda']);
             
			//Atualizar
			$resultado = mysql_query("UPDATE moedas SET flag = '$flag_1' WHERE id_moeda = '$id_moeda'")
            or die("Algo está errado... \n". mysql_error()); 
                 
            //verificar se a query foi executada
            if($resultado) {
				//redirecionar para voltar para a página de opções
				header("Location: opcoes.php");
				exit();
			}
			else
			// Gerar um erro
			{
				die("Falha ao ativar uma moeda..." . mysql_error());
			}
        }
		else{
			//Limpar os valores POST
			$id_moeda = limpar($_POST['id_moeda']);
		 
			//atualizar
			$resultado = mysql_query("UPDATE moedas SET flag = '$flag_1' WHERE id_moeda = '$id_moeda'")
			or die("Algo está errado... \n". mysql_error()); 
			 
			//verificar se query foi executada
			if($resultado) {
				//redirecionar para voltar para a página de opções
				header("Location: opcoes.php");
				exit();
			}
			else
			// Gerar um erro
			{
				die("Falha ao ativar uma moeda..." . mysql_error());
			}
		}
    }
?>