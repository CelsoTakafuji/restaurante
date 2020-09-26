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
    
	//Função para limpar os valores recebidos do formulário. Impede SQL Injection
	function limpar($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
    
    if(isset($_POST['id_quantidade']) && isset($_POST['id_comida']))
        {
            //obter id_quantidade
            $id_quantidade = limpar($_POST['id_quantidade']);
                
            //obter id_cliente da sessão
            $id_cliente = $_SESSION['SESS_MEMBER_ID'];
            
            //obter id_comida
            $id_comida = limpar($_POST['id_comida']);
            
            //obter os valores de quantidade de acordo com o id_quantidade
            $qry_select=mysql_query("SELECT * FROM quantidades WHERE id_quantidade='$id_quantidade'")
            or die("O sistema está com problemas técnicos. Por favor, tente novamente após alguns poucos minutos.");
            
            //armazenar o valor de quantidade em uma variável
            $row=mysql_fetch_array($qry_select);
            $quantidade_valor=$row['quantidade_valor'];
            
            //obter dados tabela comidas carrinhos e pedidos de acordo com o id_cliente e a flag
            $resultado=mysql_query("SELECT * FROM comidas, carrinhos, pedidos WHERE pedidos.id_cliente='$id_cliente' AND pedidos.flag='$flag_0' AND carrinhos.id_comida = '$id_comida' AND carrinhos.id_comida=comidas.id_comida AND carrinhos.id_pedido=pedidos.id_pedido") 
			or die("Ocorreu um problema... \n "." Nossa equipe está trabalhando nisso no momento... \n "." Por favor, volte depois de algumas horas."); 
            
            //armazenar o valor do preço dos alimentos em uma variável
            $row=mysql_fetch_array($resultado);
            $comida_preco=$row['comida_preco'];
            
            //Criar a query para DELETE/UPDATE na tabela cart_details
			if($quantidade_valor <= 0){
				$qry_delete = "DELETE FROM carrinhos WHERE id_pedido = '$row[id_pedido]' AND id_comida  = '$row[id_comida]'";
				mysql_query($qry_delete);
				
				if($qry_delete){
					//Contar a quantidade de carrinhos do pedido
					$qryCarrinhosPedido = mysql_query("SELECT * FROM carrinhos WHERE id_pedido = '$row[id_pedido]'")
					or die("Algo está errado... \n". mysql_error());
					
					if(mysql_num_rows($qryCarrinhosPedido) == 0){
						//Remover pedido
						$qryDeletePedido = mysql_query("DELETE FROM pedidos WHERE id_pedido = '$row[id_pedido]'")
						or die("Algo está errado... \n". mysql_error());
					}
				}
				else
				// Gerar um erro
				{
					die("Falha ao remover carrinho do pedido..." . mysql_error());
				}
			}else{
				$qry_update = "UPDATE carrinhos SET id_quantidade = '$id_quantidade' WHERE id_pedido = '$row[id_pedido]' AND id_comida  = '$row[id_comida]'";
				mysql_query($qry_update);
            }
			
			
			
            if(mysql_affected_rows() > 0){
                header("location: carrinho.php");
            }else{
                die("Ocorreu um problema... \n "." Nenhum registro foi alterado... \n "." Por favor, volte depois de algumas horas."); 
            }
            
        }else {
            die("Algo deu errado! Nossa equipe técnica está trabalhando em resolver o problema. Por favor, tente novamente após alguns minutos.");
        }
?>