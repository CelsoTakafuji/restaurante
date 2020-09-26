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
    //Configurar charset do banco de dados
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
	
	//recuperar todos os registros de conteúdo
    $conteudo=mysql_query("SELECT * FROM conteudo");
	if ($conteudo){
		//buscar o conteúdo em uma matriz
		$conteudo_ativo=mysql_fetch_array($conteudo);
		
		//inicializando diretamente as variáveis com valores de conteúdo com base em campos
		$nome                    		= $conteudo_ativo['nome'];                   
		$titulo                  		= $conteudo_ativo['titulo'];                 
		$subtitulo               		= $conteudo_ativo['subtitulo'];              
		$sobre_nos_descricao     		= $conteudo_ativo['sobre_nos_descricao'];    
		$sobre_nos_missao        		= $conteudo_ativo['sobre_nos_missao'];       
		$sobre_nos_visao         		= $conteudo_ativo['sobre_nos_visao'];        
		$contatos                		= $conteudo_ativo['contatos'];               
		$localizacao             		= $conteudo_ativo['localizacao'];            
		$descricao_promocao      		= $conteudo_ativo['descricao_promocao'];     
		$descricao_minha_conta 			= $conteudo_ativo['descricao_minha_conta'];  
		$descricao_pedidos_concluidos 	= $conteudo_ativo['descricao_pedidos_concluidos'];
		$descricao_meu_perfil    		= $conteudo_ativo['descricao_meu_perfil'];   
		$descricao_caixa_entrada 		= $conteudo_ativo['descricao_caixa_entrada'];
		$descricao_mesas         		= $conteudo_ativo['descricao_mesas'];        
		$descricao_saloes_festa  		= $conteudo_ativo['descricao_saloes_festa']; 
		$descricao_avaliacao     		= $conteudo_ativo['descricao_avaliacao'];    
		$outros_enderecos        		= $conteudo_ativo['outros_enderecos'];       
		$outros_deslogado        		= $conteudo_ativo['outros_deslogado'];       
		$outros_acesso_negado	 		= $conteudo_ativo['outros_acesso_negado'];	
	
	}
	else{
		die("Algo deu errado durante o carregamento de conteúdo... o erro MySql é" . mysql_error());
	}
?>