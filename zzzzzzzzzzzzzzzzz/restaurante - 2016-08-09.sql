/*
MySQL Backup
Source Server Version: 5.6.17
Source Database: restaurante
Date: 09/08/2016 07:14:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
--  Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id_admin` int(45) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `avaliacoes`
-- ----------------------------
DROP TABLE IF EXISTS `avaliacoes`;
CREATE TABLE `avaliacoes` (
  `id_avaliacao` int(15) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(15) NOT NULL,
  `id_comida` int(15) NOT NULL,
  `id_classificacao` int(5) NOT NULL,
  PRIMARY KEY (`id_avaliacao`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `carrinhos`
-- ----------------------------
DROP TABLE IF EXISTS `carrinhos`;
CREATE TABLE `carrinhos` (
  `id_pedido` int(15) NOT NULL AUTO_INCREMENT,
  `id_comida` int(15) NOT NULL,
  `id_quantidade` int(15) NOT NULL,
  PRIMARY KEY (`id_pedido`,`id_comida`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `categorias`
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id_categoria` int(15) NOT NULL AUTO_INCREMENT,
  `categoria_nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `classificacoes`
-- ----------------------------
DROP TABLE IF EXISTS `classificacoes`;
CREATE TABLE `classificacoes` (
  `id_classificacao` int(5) NOT NULL AUTO_INCREMENT,
  `classificacao_nome` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_classificacao`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `clientes`
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id_cliente` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sobrenome` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `senha` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `id_pergunta` int(5) NOT NULL,
  `resposta` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `comidas`
-- ----------------------------
DROP TABLE IF EXISTS `comidas`;
CREATE TABLE `comidas` (
  `id_comida` int(15) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(15) NOT NULL,
  `comida_nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `comida_descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `comida_preco` float NOT NULL,
  `comida_foto` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_comida`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `conteudo`
-- ----------------------------
DROP TABLE IF EXISTS `conteudo`;
CREATE TABLE `conteudo` (
  `id_conteudo` int(1) NOT NULL DEFAULT '1',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `enderecos`
-- ----------------------------
DROP TABLE IF EXISTS `enderecos`;
CREATE TABLE `enderecos` (
  `id_endereco` int(10) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(15) NOT NULL,
  `endereco` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cep` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `cidade` text COLLATE utf8_unicode_ci NOT NULL,
  `celular` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_endereco`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `formas_pagto`
-- ----------------------------
DROP TABLE IF EXISTS `formas_pagto`;
CREATE TABLE `formas_pagto` (
  `id_forma_pagto` int(10) NOT NULL AUTO_INCREMENT,
  `forma_pagto_descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_forma_pagto`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `funcionarios`
-- ----------------------------
DROP TABLE IF EXISTS `funcionarios`;
CREATE TABLE `funcionarios` (
  `id_funcionario` int(15) NOT NULL AUTO_INCREMENT,
  `nome` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sobrenome` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `endereco` text COLLATE utf8_unicode_ci NOT NULL,
  `celular` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_funcionario`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `fusos_horarios`
-- ----------------------------
DROP TABLE IF EXISTS `fusos_horarios`;
CREATE TABLE `fusos_horarios` (
  `id_fuso_horario` int(5) NOT NULL AUTO_INCREMENT,
  `fuso_horario_referencia` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `flag` int(1) NOT NULL,
  PRIMARY KEY (`id_fuso_horario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `mensagens`
-- ----------------------------
DROP TABLE IF EXISTS `mensagens`;
CREATE TABLE `mensagens` (
  `id_mensagem` int(15) NOT NULL AUTO_INCREMENT,
  `mensagem_de` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `mensagem_email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `mensagem_data` date NOT NULL,
  `mensagem_tempo` time NOT NULL,
  `mensagem_assunto` text COLLATE utf8_unicode_ci NOT NULL,
  `mensagem_texto` text COLLATE utf8_unicode_ci NOT NULL,
  `mensagem_flag` int(1) NOT NULL,
  PRIMARY KEY (`id_mensagem`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `mesas`
-- ----------------------------
DROP TABLE IF EXISTS `mesas`;
CREATE TABLE `mesas` (
  `id_mesa` int(5) NOT NULL AUTO_INCREMENT,
  `mesa_nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_mesa`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `modelo`
-- ----------------------------
DROP TABLE IF EXISTS `modelo`;
CREATE TABLE `modelo` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `moedas`
-- ----------------------------
DROP TABLE IF EXISTS `moedas`;
CREATE TABLE `moedas` (
  `id_moeda` int(5) NOT NULL AUTO_INCREMENT,
  `moeda_simbolo` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `flag` int(1) NOT NULL,
  PRIMARY KEY (`id_moeda`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `pedidos`
-- ----------------------------
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `id_pedido` int(10) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(10) NOT NULL,
  `id_endereco` int(10) NOT NULL,
  `id_funcionario` int(15) NOT NULL,
  `id_forma_pagto` int(10) NOT NULL,
  `data_entrega` date NOT NULL,
  `horario_entrega` time NOT NULL,
  `flag` int(1) NOT NULL,
  PRIMARY KEY (`id_pedido`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED;

-- ----------------------------
--  Table structure for `perguntas`
-- ----------------------------
DROP TABLE IF EXISTS `perguntas`;
CREATE TABLE `perguntas` (
  `id_pergunta` int(5) NOT NULL AUTO_INCREMENT,
  `pergunta` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,
  PRIMARY KEY (`id_pergunta`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- ----------------------------
--  Table structure for `promocoes`
-- ----------------------------
DROP TABLE IF EXISTS `promocoes`;
CREATE TABLE `promocoes` (
  `id_promocao` int(15) NOT NULL AUTO_INCREMENT,
  `promocao_nome` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `promocao_descricao` text COLLATE utf8_unicode_ci NOT NULL,
  `promocao_preco` float NOT NULL,
  `promocao_data_inicio` date NOT NULL,
  `promocao_data_fim` date NOT NULL,
  `promocao_foto` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_promocao`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `quantidades`
-- ----------------------------
DROP TABLE IF EXISTS `quantidades`;
CREATE TABLE `quantidades` (
  `id_quantidade` int(5) NOT NULL AUTO_INCREMENT,
  `quantidade_valor` int(5) NOT NULL,
  PRIMARY KEY (`id_quantidade`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `reservas`
-- ----------------------------
DROP TABLE IF EXISTS `reservas`;
CREATE TABLE `reservas` (
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
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `saloes_festa`
-- ----------------------------
DROP TABLE IF EXISTS `saloes_festa`;
CREATE TABLE `saloes_festa` (
  `id_salao_festas` int(5) NOT NULL AUTO_INCREMENT,
  `salao_festas_nome` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_salao_festas`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `usuarios`
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` int(10) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `admin` VALUES ('1','cmassao','25f9e794323b453885f5181f1b624d0b');
INSERT INTO `avaliacoes` VALUES ('28','1','7','2'), ('27','1','6','4');
INSERT INTO `carrinhos` VALUES ('1','1','1'), ('1','2','1'), ('2','1','5'), ('2','2','1'), ('2','4','1'), ('2','5','1');
INSERT INTO `categorias` VALUES ('1','Pizza'), ('2','Hamburguer'), ('3','Batata Frita'), ('4','Frango'), ('5','Carne'), ('6','Peixe'), ('7','Arroz'), ('8','Vegetais'), ('9','Frutas'), ('10','Café da manhã'), ('11','Almoço'), ('12','Ceia'), ('13','Sobremesa'), ('14','Promoções');
INSERT INTO `classificacoes` VALUES ('1','Excelente'), ('2','Bom'), ('3','Média'), ('4','Ruim'), ('5','Péssima');
INSERT INTO `clientes` VALUES ('1','Nome1','Sobrenome1','nome1@gmail.com','25d55ad283aa400af464c76d713c07ad','2','1e4483e833025ac10e6184e75cb2d19d'), ('2','Nome2','Sobrenome2','nome2@gmail.com','25d55ad283aa400af464c76d713c07ad','2','1e4483e833025ac10e6184e75cb2d19d'), ('3','Nome3','Sobrenome3','nome3@gmail.com','25d55ad283aa400af464c76d713c07ad','2','1e4483e833025ac10e6184e75cb2d19d');
INSERT INTO `comidas` VALUES ('1','1','SUPER PIZZA DE CARNE','Pizza de carne...','54.99','meat.png'), ('2','1','SUPER PIZZA DE VEGETAIS','Pizza de palmito, brócolis, mussarela e catupiry','49.99','veggie.png'), ('3','1','PIZZA PEPPERONI','Pizza de pepperoni...','69.99','pepperoni.png'), ('4','1','SUPER PIZZA SUPREMA','Pizza de bacon, calabresa, milho, mussarela, tomate e oregano.','65.99','supersupreme.png'), ('5','1','PIZZA 4 QUEIJOS','Pizza de queijo mussarela, parmesão, gorgonzola e catupiry.','72.99','ultimatecheese.png'), ('6','1','PIZZA SUPREME','Pizza de bacon, calabresa, milho e mussarela','59.99','supremepizza.png'), ('7','14','COMBO PEPPERONI','Pizza mista de pepperoni e queijo mussarela','85','pepperoni.png');
INSERT INTO `conteudo` VALUES ('1','Restaurante do Napa','Bem vindo ao sistema de encomendas online do Restaurante do Napa!','Peça já a sua comida na zona de alimentação e ela será entregue em sua casa. Veja as promoções especiais, semanais, no menu de ofertas. Registre uma conta conosco para desfrutar das opções de alimentos, pesquisas ordenadas e rápidas, entregas e pagamentos convenientes. Comece agora fazendo o login em baixo ou registre-se, caso não tenha uma conta conosco:','<p> O restaurante do Napa é um restaurante de comida e prestação de serviços com o objetivo de fornecer alimentos nutritivos para todos os nossos clientes atuais e estimados no Brasil. Isto é conseguido através de serviços de qualidade que surpreendem e satisfazem os clientes. </p>\r\n\r\n<p> Junto com a nossa filosofia empresarial, pretendemos ser uma maneira conveniente de fornecer comida na sua porta com custos acessíveis. Sim, nós estamos aqui para atendê-lo e para atender às suas necessidades de estômago.</p>','<p> Fornecer a preços acessíveis, qualidade e alimentos nutritivos para todos os nossos clientes.</p>','<p> Se tornar uma marca respeitada no fornecimento de alimentos de qualidade para todos os nossos clientes.</p>','Restaurante do Napa<br>\r\nEndereço...<br>\r\nCidade/UF<br>\r\nEstado<br>\r\nBrasil<br>\r\nCEP: 99999-999<br> Telefone: (99)99999-9999<br><br>','pizza-inn-map4-mombasa-road.png','<p> Confira as promoções especiais abaixo. Estes são apenas por um período limitado. Faça a sua decisão agora.</p>','<P> Aqui você pode visualizar o histórico de pedidos da sua conta. As faturas podem ser vistas a partir do histórico de pedidos. Você também pode fazer reservas de mesas e salões de festas em sua conta. Para mais informações <a href=\"contatos.php\"> Clique Aqui </a> para entrar em contato.</p>','<P> Aqui você pode alterar sua senha e também adicionar um endereço de entrega. O endereço de entrega será usado para faturar seus pedidos de comida, bem como proporcionar os detalhes sobre onde será entregue seu pedido. Para mais informações <a href=\"contatos.php\"> Clique Aqui </a> para entrar em contato.</p>','<p>Aqui você pode visualizar as mensagens recebidas. Para mais informações <a href=\"contactus.php\"> Clique aqui </a> para entrar em contato.</p>','<p> Aqui você pode reserva uma mesa no restaurante. Para mais informações <a href=\"contactus.php\"> Clique aqui </a> para entrar em contato.</p>','<p> Aqui você pode reservar um salão de festas. Para mais informações <a href=\"contactus.php\"> Clique aqui </a> para entrar em contato.</p>','<p> Aqui você pode avaliar nossos pratos. Para mais informações <a href=\"contactus.php\"> Clique aqui </a> para entrar em contato.</p>','<P> Nós descobrimos que você não tem um endereço de cobrança na sua conta. Por favor, adicione um endereço de cobrança no formulário abaixo. É o mesmo endereço que será usado para entregar os seus pedidos de alimentos. Note que os endereços físicos devem ser preenchidos de forma correta, a fim de garantir a entrega de seus pedidos de comida. Para mais informações <a href=\"contactus.php\"> Clique Aqui </a> para entrar em contato.</p>','<p> <a href=\"login-registrar.php\"> Clique aqui </A> para fazer o login novamente</p>','<p> Você não tem acesso a esta página. <a href=\"login-register.php\"> Clique aqui </a> para logar-se ou registre-se de graça. O registro não vai demorar muito :-)</p>');
INSERT INTO `enderecos` VALUES ('1','1','Endereço A...','99999999','Cidade A','88888888888','3333333333');
INSERT INTO `formas_pagto` VALUES ('1','Mastercard Débito'), ('2','Mastercard Crédito'), ('3','Visa Débito'), ('4','Visa Crédito'), ('6','Dinheiro');
INSERT INTO `funcionarios` VALUES ('5','funcionario1','sobrenome func2','Endereço funcionário 2','(99) 9999.99999');
INSERT INTO `fusos_horarios` VALUES ('1','Africa/Dar_es_Salaam','0'), ('2','Africa/Nairobi','0'), ('3','GMT/London','0'), ('4','America/Sao_Paulo','1');
INSERT INTO `mensagens` VALUES ('1','administrator','','2013-05-02','13:06:56','Bem vindo!','Bem-vindo ao sistema de encomendas online do Restaurante do Napa. É nossa esperança que você ache o nosso site fácil de usar. Por favor, não hesite em contactar-nos em caso de dúvida.','0');
INSERT INTO `mesas` VALUES ('1','A'), ('2','B'), ('3','C'), ('4','D'), ('5','E'), ('6','F'), ('7','G'), ('8','H'), ('9','I'), ('10','J'), ('11','K'), ('12','Balcão');
INSERT INTO `modelo` VALUES ('1','','','','','','#000000','#000000','#000000');
INSERT INTO `moedas` VALUES ('1','R$','1'), ('2','Kshs.','0'), ('3','US$','0'), ('4','£','0'), ('5','€','0'), ('6','Tshs.','0');
INSERT INTO `pedidos` VALUES ('2','1','1','5','0','2016-08-08','16:00:00','1'), ('1','1','1','5','2','2016-08-05','12:00:00','1');
INSERT INTO `perguntas` VALUES ('1','Qual é o apelido do seu filho?'), ('2','Qual é o nome de seu animal de estimação?'), ('3','Onde você passou sua lua de mel?'), ('4','Qual é o nome do seu primeiro amor?'), ('5','Qual é o último nome do seu médico de família?'), ('6','Em que ano você se casou?');
INSERT INTO `promocoes` VALUES ('6','PEPPERONI COMBO','Pizza mista de pepperoni e queijo mussarela','85','2013-05-06','2013-05-11','pepperoni.png');
INSERT INTO `quantidades` VALUES ('-1','0'), ('1','1'), ('2','2'), ('3','3'), ('4','4'), ('5','5'), ('6','6'), ('7','7'), ('8','8'), ('9','9'), ('10','10'), ('11','11'), ('12','12'), ('13','13'), ('14','14'), ('15','15'), ('16','16'), ('17','17'), ('18','18'), ('19','19'), ('20','20'), ('21','21'), ('22','22'), ('23','23'), ('24','24'), ('25','25'), ('26','26'), ('27','27'), ('28','28'), ('29','29'), ('30','30');
INSERT INTO `reservas` VALUES ('45','1','0','1','2016-01-01','11:34:55','0','1','0','1');
INSERT INTO `saloes_festa` VALUES ('1','Norte'), ('2','Sul'), ('3','Leste'), ('4','Oeste');
