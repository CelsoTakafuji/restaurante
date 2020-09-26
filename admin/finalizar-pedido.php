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
    
	//Verificar se a variável 'id' foi definida em URL
    if (isset($_GET['id']))
    {	

		//Obter o valor id
		$id_pedido = $_GET['id'];

		//Apenas na situação "Em entrega"
		$flag = 1;
		
		//Obter o pedido
		$query_pedido = mysql_query("SELECT * FROM pedidos WHERE id_pedido = '$id_pedido' AND flag = '$flag'")
		or die("Algo está errado... \n". mysql_error());
		
		$pedido = mysql_fetch_assoc($query_pedido);
		
		//Obter o cliente
		$query_cliente= mysql_query("SELECT * FROM clientes WHERE id_cliente = '".$pedido['id_cliente']."'")
		or die("Algo está errado... \n". mysql_error());
		
		$cliente = mysql_fetch_assoc($query_cliente);
		
		//Obter o endereço
		$query_endereco= mysql_query("SELECT * FROM enderecos WHERE id_cliente = '".$pedido['id_cliente']."'")
		or die("Algo está errado... \n". mysql_error());
		
		$endereco = mysql_fetch_assoc($query_endereco);
		
		//Obter o funcionário
		$query_funcionario= mysql_query("SELECT * FROM funcionarios WHERE id_funcionario = '".$pedido['id_funcionario']."'")
		or die("Algo está errado... \n". mysql_error());
		
		$funcionario = mysql_fetch_assoc($query_funcionario);
		
		//Obter a forma de pagamento
		$query_forma_pagto= mysql_query("SELECT * FROM formas_pagto WHERE id_forma_pagto = '".$pedido['id_forma_pagto']."'")
		or die("Algo está errado... \n". mysql_error());
		
		$forma_pagto = mysql_fetch_assoc($query_forma_pagto);		
		
		//Obter a taxa de entrega
		//Definir um valor padrão para flag_entrega
		$flag_entrega = 'Entrega';
		$query_taxa = mysql_query("SELECT * FROM taxas WHERE taxa_descricao = '$flag_entrega'")
		or die("Algo está errado... \n". mysql_error());
		
		$taxa = mysql_fetch_assoc($query_taxa);
		
		//Obter o custo total
		$query_custo_total = mysql_query("SELECT SUM(comidas.comida_preco * quantidades.quantidade_valor) as soma_total FROM carrinhos, comidas, quantidades WHERE id_pedido = '$id_pedido' AND carrinhos.id_comida = comidas.id_comida AND carrinhos.id_quantidade = quantidades.id_quantidade");
		
		$soma_total = mysql_fetch_assoc($query_custo_total);
		
		//INSERIR PEDIDO CONCLUÍDO
		$query_insert_ped_conc = "INSERT INTO pedidos_concluidos ".
		                                "(id_pedido_concluido, id_cliente, nome_completo_cliente, endereco_completo, nome_completo_funcionario, data_horario_entrega, forma_pagto_descricao, taxa_entrega, custo_total, celular, telefone) ".
		                         "VALUES ('$id_pedido', '".$cliente['id_cliente']."', '".$cliente['nome']." ".$cliente['sobrenome']."', '".$endereco['endereco']." ".$endereco['cidade']." ".$endereco['cep']."', '".$funcionario['nome']." ".$funcionario['sobrenome']."', '".date('Y-m-d H:i:s',strtotime($pedido['data_entrega']." ".$pedido['horario_entrega']))."', '".$forma_pagto['forma_pagto_descricao']."', '".$taxa['taxa_valor']."', REPLACE('".number_format(($soma_total['soma_total'] + $taxa['taxa_valor']), 2, ',', '.')."',',','.'), '".$endereco['celular']."', '".$endereco['telefone']."')";
						
		$insert_pedido_concluido = mysql_query($query_insert_ped_conc)
		or die("Algo está errado... \n". mysql_error());

		//Obter carrinhos
		$query_carrinhos = mysql_query("SELECT comidas.comida_nome, comidas.comida_preco, quantidades.quantidade_valor, categorias.categoria_nome, comidas.comida_foto FROM carrinhos, comidas, quantidades, categorias WHERE id_pedido = '$id_pedido' AND carrinhos.id_comida = comidas.id_comida AND carrinhos.id_quantidade = quantidades.id_quantidade AND comidas.id_categoria = categorias.id_categoria");
		
		while ($carrinho = mysql_fetch_assoc($query_carrinhos)) {
			
			//INSERIR ITENS DO PEDIDO CONCLUÍDO
			$query_insert_itens = "INSERT INTO itens_pedidos ".
		                             "(id_pedido_concluido, categoria_nome, comida_nome, comida_preco, quantidade_valor, comida_foto) ".
		                      "VALUES ('".$id_pedido."', '".$carrinho['categoria_nome']."', '".$carrinho['comida_nome']."', '".$carrinho['comida_preco']."', '".$carrinho['quantidade_valor']."', '".$carrinho['comida_foto']."')";
		
			$insert_itens = mysql_query($query_insert_itens)
			or die("Algo está errado... \n". mysql_error());
		}
		
		//REMOVER CARRINHOS
		$resultado = mysql_query("DELETE FROM carrinhos WHERE id_pedido = '$id_pedido'")
		or die("Algo está errado... \n". mysql_error());
		
		//REMOVER PEDIDO
		$resultado = mysql_query("DELETE FROM pedidos WHERE id_pedido = '$id_pedido'")
		or die("Algo está errado... \n". mysql_error());
		
		//verificar se a query foi executada
		if($resultado) {
			//redirecionar para voltar para a página de opções
			header("Location: pedidos.php");
			exit();
		}
		else
		// Gerar um erro
		{
				die("Falha ao finalizar o pedido..." . mysqlin_error());
		}
	}

?>