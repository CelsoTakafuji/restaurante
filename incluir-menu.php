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
	
	//Obter id_cliente da sessão
	$id_cliente=$_SESSION['SESS_MEMBER_ID'];
	
    //Recuperar todas as linhas da tabela pedidos com base na flag = 0
    $flag_0 = 0;
    $items=mysql_query("SELECT * FROM pedidos WHERE pedidos.id_cliente = '$id_cliente' AND pedidos.flag = '$flag_0'")
    or die("Algo está errado... \n" . mysql_error()); 
    
	//Obter o número de linhas
    $num_items = mysql_num_rows($items);

    //Recuperar todas as linhas da tabela mensagens com base na flag = 0
    $mensagens = mysql_query("SELECT * FROM mensagens WHERE mensagem_flag='$flag_0'")
    or die("Algo está errado... \n" . mysql_error()); 
	
    //Obter o número de linhas
    $num_mensagens = mysql_num_rows($mensagens);
	
    //Recuperar todas as linhas da tabela reservas com base na flag = 1 para identificar mesa
    $flag_1 = 1;
    $mesas=mysql_query("SELECT * FROM reservas WHERE reservas.id_cliente = '$id_cliente' AND reservas.flag_mesa = '$flag_1'")
    or die("Algo está errado... \n" . mysql_error()); 
    
	//Obter o número de linhas
    $num_mesas = mysql_num_rows($mesas);
	
    //Recuperar todas as linhas da tabela reservas com base na flag = 1 para identificar salão de festas
    $flag_1 = 1;
    $saloes=mysql_query("SELECT * FROM reservas WHERE reservas.id_cliente = '$id_cliente' AND reservas.flag_salao_festas = '$flag_1'")
    or die("Algo está errado... \n" . mysql_error()); 
    
	//Obter o número de linhas
    $num_saloes = mysql_num_rows($saloes);
	
?>

	<a href="minha-conta.php">Minha Conta</a> | <a href="pedidos-concluidos-cliente.php">Pedidos Concluídos</a> | <a href="meu-perfil.php">Meu Perfil</a> | <a href="carrinho.php">Carrinho[<?php echo $num_items;?>]</a> |  <a href="caixa-entrada.php">Caixa de entrada[<?php echo $num_mensagens;?>]</a> | <a href="mesas.php">Mesas[<?php echo $num_mesas;?>]</a> | <a href="saloes-festa.php">Salão de Festas[<?php echo $num_saloes;?>]</a> | <a href="avalie-nos.php">Avalie-nos</a> | <a href="deslogar.php">Deslogar</a>