<?php	
	//$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	
	$url = $_SERVER['REQUEST_URI'];
	$url = explode('/', $url);
	
	if( strpos(end($url), '?') !== false ){
		$url = substr(end($url), 0, strripos(end($url),'?'));
	}else{
		$url = end($url);
	}
	
	$menu = '<a href="index.php">Inicial</a> | <a href="admins.php">Admins</a> | <a href="categorias.php">Categorias</a> | <a href="comidas.php">Comidas</a> | <a href="clientes.php"> Clientes </a> | <a href="pedidos.php">Pedidos (~)</a> | <a href="pedidos-concluidos.php">Pedidos (F)</a> | <a href="reservas.php">Reservas</a> | <a href="promocoes.php">Promoções</a> | <a href="funcionarios-alocacao.php">Funcionários</a> | <a href="mensagens.php">Mensagens</a> | <a href="opcoes.php">Opções</a> | <a href="conteudo.php">Conteúdo</a> | <a href="modelo.php">Modelo</a> | <a href="deslogar.php">Deslogar</a>';
	
	$menuNovo = str_replace($url, $url."\" style=\"border-style:solid; border-color:#ffa500;\" " ,$menu);
	
	echo $menuNovo;
?>	
