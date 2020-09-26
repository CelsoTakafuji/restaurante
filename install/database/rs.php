<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	//Verificar a ligação e conexão com o banco de dados
	require_once('../connection/config.php');
	$db_error=false;
	//Conectar ao servidor MySQL
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		$db_error=true;
		$error_msg="Falha ao conectar ao servidor: " . mysql_error();
	}
	
	//Selecionar base de dados
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		$db_error=true;
		$error_msg="Não é possível selecionar banco de dados: " . mysql_error();
	}

//--
//-- Database: `restaurante`
//--

if ($db_error==false){
	
	//-- ----------------------------
	//-- Table structure for `admin`
	//-- ----------------------------
	
	$query = "CREATE TABLE IF NOT EXISTS `admin` (
	  `id_admin` int(45) NOT NULL AUTO_INCREMENT,
	  `usuario` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  `senha` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_admin`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
	
	mysql_query($query);

	//-- ----------------------------
	//-- Table structure for `avaliacoes`
	//-- ----------------------------

	$query = "CREATE TABLE IF NOT EXISTS`avaliacoes` (
	  `id_avaliacao` int(15) NOT NULL AUTO_INCREMENT,
	  `id_cliente` int(15) NOT NULL,
	  `id_comida` int(15) NOT NULL,
	  `id_classificacao` int(5) NOT NULL,
	  PRIMARY KEY (`id_avaliacao`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
	
	mysql_query($query);

	//-- ----------------------------
	//-- Table structure for `carrinhos`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`carrinhos` (
	  `id_pedido` int(15) NOT NULL AUTO_INCREMENT,
	  `id_comida` int(15) NOT NULL,
	  `id_quantidade` int(15) NOT NULL,
	  PRIMARY KEY (`id_pedido`,`id_comida`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `categorias`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`categorias` (
	  `id_categoria` int(15) NOT NULL AUTO_INCREMENT,
	  `categoria_nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_categoria`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `classificacoes`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`classificacoes` (
	  `id_classificacao` int(5) NOT NULL AUTO_INCREMENT,
	  `classificacao_nome` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_classificacao`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `clientes`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`clientes` (
	  `id_cliente` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `nome` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `sobrenome` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
	  `login` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	  `senha` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
	  `id_pergunta` int(5) NOT NULL,
	  `resposta` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_cliente`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `comidas`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`comidas` (
	  `id_comida` int(15) NOT NULL AUTO_INCREMENT,
	  `id_categoria` int(15) NOT NULL,
	  `comida_nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  `comida_descricao` text COLLATE utf8_unicode_ci NOT NULL,
	  `comida_preco` float NOT NULL,
	  `comida_foto` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_comida`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `conteudo`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`conteudo` (
	  `id_conteudo` int(1) NOT NULL AUTO_INCREMENT,
	  `nome` varchar(55) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `titulo` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `subtitulo` varchar(1000) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `sobre_nos_descricao` varchar(2500) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `sobre_nos_missao` varchar(2500) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `sobre_nos_visao` varchar(2500) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `contatos` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `localizacao` varchar(45) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `descricao_promocao` varchar(1000) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `descricao_minha_conta` varchar(1000) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `descricao_meu_perfil` varchar(1000) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `descricao_caixa_entrada` varchar(1000) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `descricao_mesas` varchar(1000) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `descricao_saloes_festa` varchar(1000) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `descricao_avaliacao` varchar(1000) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `outros_enderecos` varchar(1000) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `outros_deslogado` varchar(1000) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  `outros_acesso_negado` varchar(1000) CHARACTER SET latin1 NOT NULL DEFAULT 'undefined',
	  PRIMARY KEY (`id_conteudo`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `enderecos`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`enderecos` (
	  `id_endereco` int(10) NOT NULL AUTO_INCREMENT,
	  `id_cliente` int(15) NOT NULL,
	  `endereco` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	  `cep` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
	  `cidade` text COLLATE utf8_unicode_ci NOT NULL,
	  `celular` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
	  `telefone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
	  PRIMARY KEY (`id_endereco`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `formas_pagto`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`formas_pagto` (
	  `id_forma_pagto` int(10) NOT NULL AUTO_INCREMENT,
	  `forma_pagto_descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_forma_pagto`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `funcionarios`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`funcionarios` (
	  `id_funcionario` int(15) NOT NULL AUTO_INCREMENT,
	  `nome` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
	  `sobrenome` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
	  `endereco` text COLLATE utf8_unicode_ci NOT NULL,
	  `celular` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_funcionario`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `fusos_horarios`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`fusos_horarios` (
	  `id_fuso_horario` int(5) NOT NULL AUTO_INCREMENT,
	  `fuso_horario_referencia` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  `flag` int(1) NOT NULL,
	  PRIMARY KEY (`id_fuso_horario`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);
	
	//-- ----------------------------
	//--  Table structure for `itens_pedidos`
	//-- ----------------------------
	$query = "CREATE TABLE `itens_pedidos` (
	  `id_pedido_concluido` int(10) NOT NULL,
	  `categoria_nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  `comida_nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  `comida_preco` float NOT NULL,
	  `quantidade_valor` int(5) NOT NULL,
	  `comida_foto` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_pedido_concluido`,`comida_nome`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
	
	mysql_query($query);
	
	//-- ----------------------------
	//-- Table structure for `mensagens`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`mensagens` (
	  `id_mensagem` int(15) NOT NULL AUTO_INCREMENT,
	  `mensagem_de` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
	  `mensagem_email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  `mensagem_data` date NOT NULL,
	  `mensagem_tempo` time NOT NULL,
	  `mensagem_assunto` text COLLATE utf8_unicode_ci NOT NULL,
	  `mensagem_texto` text COLLATE utf8_unicode_ci NOT NULL,
	  `mensagem_flag` int(1) NOT NULL,
	  `id_cliente` int(11) NOT NULL,
	  PRIMARY KEY (`id_mensagem`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `mesas`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`mesas` (
	  `id_mesa` int(5) NOT NULL AUTO_INCREMENT,
	  `mesa_nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_mesa`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `modelo`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`modelo` (
	  `id_modelo` int(1) NOT NULL DEFAULT '1',
	  `site_logo` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
	  `site_background` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
	  `site_header` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
	  `site_center` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
	  `site_footer` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
	  `site_background_color` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
	  `site_center_color` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
	  `site_footer_color` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_modelo`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `moedas`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`moedas` (
	  `id_moeda` int(5) NOT NULL AUTO_INCREMENT,
	  `moeda_simbolo` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
	  `flag` int(1) NOT NULL,
	  PRIMARY KEY (`id_moeda`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `pedidos`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`pedidos` (
	  `id_pedido` int(10) NOT NULL AUTO_INCREMENT,
	  `id_cliente` int(10) NOT NULL,
	  `id_endereco` int(10) NOT NULL,
	  `id_funcionario` int(15) NOT NULL,
	  `id_forma_pagto` int(10) NOT NULL,
	  `data_entrega` date NOT NULL,
	  `horario_entrega` time NOT NULL,
	  `flag` int(1) NOT NULL,
	  PRIMARY KEY (`id_pedido`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//--  Table structure for `pedidos_concluidos`
	//-- ----------------------------
	$query = "CREATE TABLE `pedidos_concluidos` (
	  `id_pedido_concluido` int(10) NOT NULL AUTO_INCREMENT,
	  `id_cliente` int(10) NOT NULL,
	  `nome_completo_cliente` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	  `endereco_completo` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
	  `nome_completo_funcionario` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	  `data_horario_entrega` datetime NOT NULL,
	  `forma_pagto_descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `taxa_entrega` float NOT NULL,
	  `custo_total` float NOT NULL,
	  `celular` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
	  `telefone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
	  PRIMARY KEY (`id_pedido_concluido`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED";
	
	mysql_query($query);
	
	//-- ----------------------------
	//-- Table structure for `perguntas`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`perguntas` (
	  `id_pergunta` int(5) NOT NULL AUTO_INCREMENT,
	  `pergunta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_pergunta`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `promocoes`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`promocoes` (
	  `id_promocao` int(15) NOT NULL AUTO_INCREMENT,
	  `promocao_nome` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
	  `promocao_descricao` text COLLATE utf8_unicode_ci NOT NULL,
	  `promocao_preco` float NOT NULL,
	  `promocao_data_inicio` date NOT NULL,
	  `promocao_data_fim` date NOT NULL,
	  `promocao_foto` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_promocao`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `quantidades`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`quantidades` (
	  `id_quantidade` int(5) NOT NULL AUTO_INCREMENT,
	  `quantidade_valor` int(5) NOT NULL,
	  PRIMARY KEY (`id_quantidade`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `reservas`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`reservas` (
	  `id_reserva` int(15) NOT NULL AUTO_INCREMENT,
	  `id_cliente` int(15) NOT NULL,
	  `id_mesa` int(5) NOT NULL,
	  `id_salao_festas` int(5) NOT NULL,
	  `reserva_data` date NOT NULL,
	  `reserva_tempo` time NOT NULL,
	  `id_funcionario` int(15) NOT NULL,
	  `flag` int(1) NOT NULL,
	  `flag_mesa` int(1) NOT NULL,
	  `flag_salao_festas` int(1) NOT NULL,
	  PRIMARY KEY (`id_reserva`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//-- Table structure for `saloes_festa`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`saloes_festa` (
	  `id_salao_festas` int(5) NOT NULL AUTO_INCREMENT,
	  `salao_festas_nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_salao_festas`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

	mysql_query($query);	
	
	//-- ----------------------------
	//--  Table structure for `taxas`
	//-- ----------------------------
	$query = "CREATE TABLE `taxas` (
	  `id_taxa` int(10) NOT NULL AUTO_INCREMENT,
	  `taxa_descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `taxa_valor` float NOT NULL,
	  PRIMARY KEY (`id_taxa`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
	
	mysql_query($query);
	
	//-- ----------------------------
	//-- Table structure for `usuarios`
	//-- ----------------------------
	$query = "CREATE TABLE IF NOT EXISTS`usuarios` (
	  `id_usuario` int(10) NOT NULL AUTO_INCREMENT,
	  `usuario` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
	  `senha` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
	  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id_usuario`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
	
	mysql_query($query);
	
	@header("Location: ../administracao.php");
}
else{
	@header("Location: ../conexao.php");
}
?>