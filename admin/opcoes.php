<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
    require_once('auth.php');
	require_once('conteudo-site.php');
	require_once('js/jscSis.php');
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
	
	//Configurar charset do banco de dados
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');	
	
	//Recuperar categorias da tabela categorias (exclusão)
	$categorias = mysql_query("SELECT * FROM categorias")
	or die("Não há registros para mostrar... \n" . mysql_error()); 

	//Recuperar categorias da tabela categorias (alteração)
	$categorias_1 = mysql_query("SELECT * FROM categorias")
	or die("Não há registros para mostrar... \n" . mysql_error()); 
	
	//Recuperar quantidades da tabela quantidades (exclusão)
	$quantidades = mysql_query("SELECT * FROM quantidades")
	or die("Algo está errado... \n" . mysql_error()); 

	//Recuperar quantidades da tabela quantidades (alteração)
	$quantidades_1 = mysql_query("SELECT * FROM quantidades")
	or die("Algo está errado... \n" . mysql_error()); 
	
	//recuperar moedas da tabela moedas (exclusão)
	$moedas = mysql_query("SELECT * FROM moedas")
	or die("Algo está errado... \n" . mysql_error()); 

	//recuperar moedas da tabela moedas (ativação)
	$moedas_1=mysql_query("SELECT * FROM moedas")
	or die("Algo está errado... \n" . mysql_error()); 

	//recuperar moedas da tabela moedas (alteração)
	$moedas_2=mysql_query("SELECT * FROM moedas")
	or die("Algo está errado... \n" . mysql_error()); 
	
	//recuperar moedas da tabela moedas (ativa)
	$moeda_ativa=mysql_query("SELECT * FROM moedas WHERE flag = 1")
	or die("Algo está errado... \n" . mysql_error()); 
	
	//recuperar moedas da tabela moedas (formulários de taxas)
	$moeda_ativa_1=mysql_query("SELECT * FROM moedas WHERE flag = 1")
	or die("Algo está errado... \n" . mysql_error()); 
	
	//recuperar classificação da tabela classificacoes (exclusão)
	$classificacoes = mysql_query("SELECT * FROM classificacoes")
	or die("Algo está errado... \n" . mysql_error());
	
	//recuperar classificação da tabela classificacoes (alteração)
	$classificacoes_1 = mysql_query("SELECT * FROM classificacoes")
	or die("Algo está errado... \n" . mysql_error());	

	//recuperar fusos horários da tabela fusos_horarios (exclusão)
	$fusos_horarios = mysql_query("SELECT * FROM fusos_horarios")
	or die("Algo está errado... \n" . mysql_error()); 

	//recuperar fusos horários da tabela fusos_horarios (ativação)
	$fusos_horarios_1=mysql_query("SELECT * FROM fusos_horarios")
	or die("Algo está errado... \n" . mysql_error());  
	
	//recuperar fusos horários da tabela fusos_horarios (alteração)
	$fusos_horarios_2=mysql_query("SELECT * FROM fusos_horarios")
	or die("Algo está errado... \n" . mysql_error());  
	
	//recuperar fusos horários da tabela fusos_horarios (ativo)
	$fuso_horario_ativo=mysql_query("SELECT * FROM fusos_horarios WHERE flag = 1")
	or die("Algo está errado... \n" . mysql_error());  
	
	//recuperar mesas da tabela mesas (exclusão)
	$mesas = mysql_query("SELECT * FROM mesas")
	or die("Algo está errado... \n" . mysql_error());

	//recuperar mesas da tabela mesas (alteração)
	$mesas_1 = mysql_query("SELECT * FROM mesas")
	or die("Algo está errado... \n" . mysql_error());	
	
	//recuperar Salões de Festas da tabela saloes_festa (exclusão)
	$saloes_festa = mysql_query("SELECT * FROM saloes_festa")
	or die("Algo está errado... \n" . mysql_error());

	//recuperar Salões de Festas da tabela saloes_festa (alteração)
	$saloes_festa_1 = mysql_query("SELECT * FROM saloes_festa")
	or die("Algo está errado... \n" . mysql_error());	
	
	//recuperar perguntas da tabela perguntas (exclusão)
	$perguntas = mysql_query("SELECT * FROM perguntas")
	or die("Algo está errado... \n" . mysql_error());
	
	//recuperar perguntas da tabela perguntas (alteração)
	$perguntas_1 = mysql_query("SELECT * FROM perguntas")
	or die("Algo está errado... \n" . mysql_error());
	
	//recuperar formas de pagamento da tabela formas_pagto (exclusão)
	$formas_pagto = mysql_query("SELECT * FROM formas_pagto")
	or die("Algo está errado... \n" . mysql_error());
	
	//recuperar formas de pagamento da tabela formas_pagto (alteração)
	$formas_pagto_1 = mysql_query("SELECT * FROM formas_pagto")
	or die("Algo está errado... \n" . mysql_error());

	//recuperar perguntas da tabela taxas (exclusão)
	$taxas = mysql_query("SELECT * FROM taxas")
	or die("Algo está errado... \n" . mysql_error());
	
	//recuperar perguntas da tabela taxas (alteração)
	$taxas_1 = mysql_query("SELECT * FROM taxas")
	or die("Algo está errado... \n" . mysql_error());	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Opções</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Opções </h1>
		<?php require('incluir-menu.php'); ?>
	</div>
	
	<div id="container">
	<fieldset><legend>Gerenciar categorias</legend>
		<table width="910">
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="categoriasForm" id="categoriasForm" action="categorias-exec.php" method="post" onsubmit="return validarCategorias(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Categoria</td>
							<td width="50%"><input type="text" name="categoria_nome" class="textfield" maxlength="25" placeholder="Nome da categoria" required/></td>
							<td width="18%" ><input type="submit" name="Adicionar" value="Adicionar" /></td>
						</tr>
					</table>
					</form>
				</td>
			
				<td width="50%">
					<form name="categoriasForm" id="categoriasForm" action="remover-categoria.php" method="post" onsubmit="return validarCategorias(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Categoria</td>
							<td width="50%">
								<select name="id_categoria" id="id_categoria">
									<option value="select">- selecione a categoria -
									<?php 
									//loop através de linhas da tabela categorias
									while ($row=mysql_fetch_array($categorias)){
										echo "<option value=$row[id_categoria]>$row[categoria_nome]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"><input type="submit" name="Remover" value="Remover" /></td>
						</tr>
					</table>
					</form>
				</td>
			</tr>	
				
			<tr><td style="background:black;" colspan="2"></td></tr>
			
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="categoriasForm" id="categoriasForm" action="alterar-categoria.php" method="post" onsubmit="return validarCategorias(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Categoria</td>
							<td width="50%">
								<select name="id_categoria" id="id_categoria">
									<option value="select">- selecione a categoria -
									<?php 
									//loop através de linhas da tabela categorias
									while ($row=mysql_fetch_array($categorias_1)){
										echo "<option value=$row[id_categoria]>$row[categoria_nome]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"></td>
						</tr>
						<tr>
							<td width="32%">Categoria</td>
							<td width="50%"><input type="text" name="categoria_nome" class="textfield" maxlength="25" placeholder="Nome da categoria" required/></td>
							<td width="18%"><input type="submit" name="Alterar" value="Alterar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
				</td>
			</tr>
		</table>
	</fieldset>
	
	<hr>
	
	<fieldset><legend>Gerenciar Quantidades</legend>
		<table width="910">
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="quantidadeForm" id="quantidadeForm" action="quantidades-exec.php" method="post" onsubmit="return validarQantidade(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Quantidade</td>
							<td width="50%"><input type="number" name="quantidade_valor" class="textfield" maxlength="2" min="1" max="99" placeholder="1" required/></td>
							<td width="18%"><input type="submit" name="Adicionar" value="Adicionar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
					<form name="quantidadeForm" id="quantidadeForm" action="remover-quantidade.php" method="post" onsubmit="return validarQuantidade(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Quantidade</td>
							<td width="50%">
								<select name="id_quantidade" id="id_quantidade">
									<option value="select">- selecione a quantidade -
									<?php 
									//Loop através de linhas de tabela quantidades
									while ($row = mysql_fetch_array($quantidades)){
										echo "<option value=$row[id_quantidade]>$row[quantidade_valor]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"><input type="submit" name="Remover" value="Remover" /></td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
			
			<tr><td style="background:black;" colspan="2"></td></tr>
			
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="quantidadeForm" id="quantidadeForm" action="alterar-quantidade.php" method="post" onsubmit="return validarQuantidade(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Quantidade</td>
							<td width="50%">
								<select name="id_quantidade" id="id_quantidade">
									<option value="select">- selecione a quantidade -
									<?php 
									//Loop através de linhas de tabela quantidades
									while ($row = mysql_fetch_array($quantidades_1)){
										echo "<option value=$row[id_quantidade]>$row[quantidade_valor]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"></td>
						</tr>
						<tr>
							<td width="32%">Quantidade</td>
							<td width="50%"><input type="number" name="quantidade_valor" class="textfield" maxlength="2" min="1" max="99" placeholder="1" required/></td>
							<td width="18%"><input type="submit" name="Alterar" value="Alterar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
				</td>
			</tr>			
		</table>
	</fieldset>
	
	<hr>
	
	<fieldset><legend>Gerenciar Moedas</legend>
		<table width="910">
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="moedaForm" id="moedaForm" action="moedas-exec.php" method="post" onsubmit="return validarMoedas(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
					<tr>
						<td width="32%">Moeda</td>
						<td width="50%"><input type="text" name="moeda_simbolo" class="textfield" maxlength="5" placeholder="Fornecer símbolo da moeda" required/></td>
						<td width="18%"><input type="submit" name="Adicionar" value="Adicionar" /></td>
					</tr>
					</table>
					</form>
				</td>
				<td width="50%">
					<form name="moedaForm" id="moedaForm" action="remover-moeda.php" method="post" onsubmit="return validarMoedas(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Moeda</td>
							<td width="50%">
								<select name="id_moeda" id="id_moeda">
									<option value="select">- sel. moeda -
									<?php 
									//loop através de linhas de tabela moedas
									while ($row=mysql_fetch_array($moedas)){
										echo "<option value = $row[id_moeda]>$row[moeda_simbolo]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"><input type="submit" name="Remover" value="Remover" /></td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
			
			<tr><td style="background:black;" colspan="2"></td></tr>
			
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="moedaForm" id="moedaForm" action="alterar-moeda.php" method="post" onsubmit="return validarMoedas(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td colspan="3">
							<?php 
								$row = mysql_fetch_array($moeda_ativa); 
								echo "Moeda ativa: <b style=\"color:black;\">" . $row['moeda_simbolo'] ."</b>";
							?>
							</td>
						</tr>
						<tr>
							<td width="32%">Moeda</td>
							<td width="50%">
								<select name="id_moeda" id="id_moeda">
									<option value="select">- sel. moeda -
									<?php 
									//loop através de linhas de tabela moedas
									while ($row=mysql_fetch_array($moedas_1)){
										echo "<option value=$row[id_moeda]>$row[moeda_simbolo]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"><input type="submit" name="Alterar" value="Ativar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
					<form name="moedaForm" id="moedaForm" action="alterar-moeda.php" method="post" onsubmit="return validarMoedas(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Moeda</td>
							<td width="50%">
								<select name="id_moeda" id="id_moeda">
									<option value="select">- sel. moeda -
									<?php 
									//loop através de linhas de tabela moedas
									while ($row=mysql_fetch_array($moedas_2)){
										echo "<option value = $row[id_moeda]>$row[moeda_simbolo]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"></td>
						</tr>
						<tr>
							<td width="32%">Moeda</td>
							<td width="50%"><input type="text" name="moeda_simbolo" class="textfield" maxlength="5" placeholder="Fornecer símbolo da moeda" required/></td>
							<td width="18%"><input type="submit" name="Alterar" value="Alterar" /></td>
						</tr>
					</table>
					</form>
				</td>
			</tr>	
		</table>
	</fieldset>
	
	<hr>
	
	<fieldset><legend>Gerenciar Classificação das Avaliações</legend>
		<table width="910">
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="classificacaoForm" id="classificacaoForm" action="classificacoes-exec.php" method="post" onsubmit="return validarClassificacoes(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Nível de Classificação</td>
							<td width="50%"><input type="text" name="classificacao_nome" id="classificacao_nome" class="textfield" maxlength="15" placeholder="Isto é excelente, bom, médio etc" required/></td>
							<td width="18%"><input type="submit" name="Adicionar" value="Adicionar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
					<form name="classificacaoForm" id="classificacaoForm" action="remover-classificacao.php" method="post" onsubmit="return validarClassificacoes(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Nível de Classificação</td>
							<td width="50%">
								<select name="id_classificacao" id="id_classificacao">
									<option value="select">- selecione o nível -
									<?php 
									//loop através de linhas da tabela classificacoes
									while ($row = mysql_fetch_array($classificacoes)){
										echo "<option value=$row[id_classificacao]>$row[classificacao_nome]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"><input type="submit" name="Remover" value="Remover" /></td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
				
			<tr><td style="background:black;" colspan="2"></td></tr>
			
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="classificacaoForm" id="classificacaoForm" action="alterar-classificacao.php" method="post" onsubmit="return validarClassificacoes(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Nível de Classificação</td>
							<td width="50%">
								<select name="id_classificacao" id="id_classificacao">
									<option value="select">- selecione o nível -
									<?php 
									//loop através de linhas da tabela classificacoes
									while ($row = mysql_fetch_array($classificacoes_1)){
										echo "<option value=$row[id_classificacao]>$row[classificacao_nome]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"></td>
						</tr>
						<tr>
							<td width="32%">Nível de Classificação</td>
							<td width="50%"><input type="text" name="classificacao_nome" id="classificacao_nome" class="textfield" maxlength="15" placeholder="Isto é excelente, bom, médio etc" required/></td>
							<td width="18%"><input type="submit" name="Alterar" value="Alterar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
				</td>
			</tr>
		</table>
	</fieldset>
	
	<hr>
	
	<fieldset><legend>Gerenciar Fuso Horário</legend>
		<table width="910">
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="fusohorarioForm" id="fusohorarioForm" action="fuso-horario-exec.php" method="post" onsubmit="return validarFusoHorario(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Fuso Horário</td>
							<td width="50%"><input type="text" name="fuso_horario_referencia" class="textfield" maxlength="20" placeholder="Fornecer fuso horário" required/></td>
							<td width="18%"><input type="submit" name="Adicionar" value="Adicionar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
					<form name="fusohorarioForm" id="fusohorarioForm" action="remover-fuso-horario.php" method="post" onsubmit="return validarFusoHorario(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Fuso Horário</td>
							<td width="50%">
								<select name="id_fuso_horario" id="id_fuso_horario">
									<option value="select">- selecione fuso horário -
									<?php 
									//loop através das linhas da tabela fusos_horarios
									while ($row=mysql_fetch_array($fusos_horarios)){
										echo "<option value=$row[id_fuso_horario]>$row[fuso_horario_referencia]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"><input type="submit" name="Remover" value="Remover" /></td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
			
			<tr><td style="background:black;" colspan="2"></td></tr>
			
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="fusohorarioForm" id="fusohorarioForm" action="Ativar-fuso-horario.php" method="post" onsubmit="return validarFusoHorario(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td colspan="3">
							<?php 
								$row = mysql_fetch_array($fuso_horario_ativo); 
								echo "Fuso horário ativo: <b style=\"color:black;\">" . $row['fuso_horario_referencia'] ."</b>";
							?>
							</td>
						</tr>
						<tr>
							<td width="32%">Fuso Horário</td>
							<td width="50%">
								<select name="id_fuso_horario" id="id_fuso_horario">
									<option value="select">- selecione fuso horário -
									<?php 
									//loop através das linhas da tabela fusos_horarios
									while ($row = mysql_fetch_array($fusos_horarios_1)){
										echo "<option value=$row[id_fuso_horario]>$row[fuso_horario_referencia]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"><input type="submit" name="Ativar" value="Ativar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
					<form name="fusohorarioForm" id="fusohorarioForm" action="alterar-fuso-horario.php" method="post" onsubmit="return validarFusoHorario(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Fuso Horário</td>
							<td width="50%">
								<select name="id_fuso_horario" id="id_fuso_horario">
									<option value="select">- selecione fuso horário -
									<?php 
									//loop através das linhas da tabela fusos_horarios
									while ($row = mysql_fetch_array($fusos_horarios_2)){
										echo "<option value=$row[id_fuso_horario]>$row[fuso_horario_referencia]"; 
									}
									?>
								</select>
								
							</td>
							<td width="18%"></td>
						</tr>
						<tr>
							<td width="32%">Fuso Horário</td>
							<td width="50%"><input type="text" name="fuso_horario_referencia" class="textfield" maxlength="20" placeholder="Fornecer fuso horário" required/></td>
							<td width="18%"><input type="submit" name="Alterar" value="Alterar" /></td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
			
		</table>
	</fieldset>
	
	<hr>
	
	<fieldset><legend>Gerenciar Mesas</legend>
		<table width="910">
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="mesasForm" id="mesasForm" action="mesas-exec.php" method="post" onsubmit="return validarMesas(this)">		
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Mesa Nome/Número</td>
							<td width="50%"><input type="text" name="mesa_nome" class="textfield" maxlength="15" placeholder="Isto é Mesa X, Mesa 01, 01, 02 etc" required/></td>
							<td width="18%"><input type="submit" name="Adicionar" value="Adicionar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
					<form name="mesasForm" id="mesasForm" action="remover-mesa.php" method="post" onsubmit="return validarMesas(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Mesa Nome/Número</td>
							<td width="50%">
								<select name="id_mesa" id="id_mesa">
									<option value="select">- selecione a mesa -
									<?php 
									//loop através das linhas da tabela mesas
									while ($row=mysql_fetch_array($mesas)){
										echo "<option value=$row[id_mesa]>$row[mesa_nome]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"><input type="submit" name="Remover" value="Remover" /></td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
			
			<tr><td style="background:black;" colspan="2"></td></tr>
			
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="mesasForm" id="mesasForm" action="alterar-mesa.php" method="post" onsubmit="return validarMesas(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Mesa Nome/Número</td>
							<td width="50%">
								<select name="id_mesa" id="id_mesa">
									<option value="select">- selecione a mesa -
									<?php 
									//loop através das linhas da tabela mesas
									while ($row=mysql_fetch_array($mesas_1)){
										echo "<option value=$row[id_mesa]>$row[mesa_nome]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"></td>
						</tr>
						<tr>
							<td width="32%">Mesa Nome/Número</td>
							<td width="50%"><input type="text" name="mesa_nome" class="textfield" maxlength="15" placeholder="Isto é Mesa X, Mesa 01, 01, 02 etc" required/></td>
							<td width="18%"><input type="submit" name="Alterar" value="Alterar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
				</td>
			</tr>
		</table>
	</fieldset>
	
	<hr>
	
	<fieldset><legend>Gerenciar Salões de Festa</legend>
		<table width="910">
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="saloesFestaForm" id="saloesFestaForm" action="saloes-festa-exec.php" method="post" onsubmit="return validarSaloesFesta(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Salão de Festa Nome/Número</td>
							<td width="50%"><input type="text" name="salao_festas_nome" class="textfield" maxlength="15" placeholder="Isto é Nome X, Nome 01, 01, 02 etc" required/></td>
							<td width="18%"><input type="submit" name="Adicionar" value="Adicionar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
					<form name="saloesFestaForm" id="saloesFestaForm" action="remover-salao-festas.php" method="post" onsubmit="return validarSaloesFesta(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Salão de Festa Nome/Número</td>
							<td width="50%">
								<select name="id_salao_festas" id="id_salao_festas">
									<option value="select">- selecione o salão de festas -
									<?php 
									//loop through saloes_festa table rows
									while ($row=mysql_fetch_array($saloes_festa)){
										echo "<option value=$row[id_salao_festas]>$row[salao_festas_nome]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"><input type="submit" name="Remover" value="Remover" /></td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
			
			<tr><td style="background:black;" colspan="2"></td></tr>
			
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="saloesFestaForm" id="saloesFestaForm" action="alterar-salao-festas.php" method="post" onsubmit="return validarSaloesFesta(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Salão de Festa Nome/Número</td>
							<td width="50%">
								<select name="id_salao_festas" id="id_salao_festas">
									<option value="select">- selecione o salão de festas -
									<?php 
									//loop through saloes_festa table rows
									while ($row=mysql_fetch_array($saloes_festa_1)){
										echo "<option value=$row[id_salao_festas]>$row[salao_festas_nome]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"></td>
						</tr>
						<tr>
							<td width="32%">Salão de Festa Nome/Número</td>
							<td width="50%"><input type="text" name="salao_festas_nome" class="textfield" maxlength="15" placeholder="Isto é Nome X, Nome 01, 01, 02 etc" required/></td>
							<td width="18%"><input type="submit" name="Alterar" value="Alterar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
				</td>
			</tr>
		</table>
	</fieldset>
	
	<hr>
	
	<fieldset><legend>Gerenciar perguntas</legend>
		<table width="910">
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="perguntaForm" id="perguntaForm" action="perguntas-exec.php" method="post" onsubmit="return validarPerguntas(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Pergunta</td>
							<td width="50%"><input type="text" name="pergunta" class="textfield" maxlength="40" placeholder="Criar uma pergunta de segurança (usado para redefinir a senha)" required/></td>
							<td width="18%"><input type="submit" name="Adicionar" value="Adicionar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
					<form name="perguntaForm" id="perguntaForm" action="remover-pergunta.php" method="post" onsubmit="return validarPerguntas(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Pergunta</td>
							<td width="50%">
								<select name="id_pergunta" id="id_pergunta" style="font-size:11;">
									<option value="select">- selecione a pergunta -
									<?php 
									//loop através das linhas da tabela perguntas
									while ($row=mysql_fetch_array($perguntas)){
										echo "<option value=$row[id_pergunta]>$row[pergunta]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"><input type="submit" name="Remover" value="Remover" /></td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
			
			<tr><td style="background:black;" colspan="2"></td></tr>
			
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="perguntaForm" id="perguntaForm" action="alterar-pergunta.php" method="post" onsubmit="return validarPerguntas(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Pergunta</td>
							<td width="50%">
								<select name="id_pergunta" id="id_pergunta" style="font-size:11;">
									<option value="select">- selecione a pergunta -
									<?php 
									//loop através das linhas da tabela perguntas
									while ($row=mysql_fetch_array($perguntas_1)){
										echo "<option value=$row[id_pergunta]>$row[pergunta]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"></td>
						</tr>
						<tr>
							<td width="32%">Pergunta</td>
							<td width="50%"><input type="text" name="pergunta" class="textfield" maxlength="40" placeholder="Criar uma pergunta de segurança (usado para redefinir a senha)" required/></td>
							<td width="18%"><input type="submit" name="Alterar" value="Alterar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
				</td>
			</tr>
		</table>
	</fieldset>
	
	<hr>
	
	<fieldset><legend>Gerenciar formas de pagamento</legend>
		<table width="910">
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="pagtoForm" id="pagtoForm" action="formas-pagto-exec.php" method="post" onsubmit="return validarFormasPagto(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Forma de pagamento</td>
							<td width="50%"><input type="text" name="forma_pagto_descricao" class="textfield" maxlength="25" placeholder="Criar uma nova forma de pagamento" required/></td>
							<td width="18%"><input type="submit" name="Adicionar" value="Adicionar" /></td>
						</tr>
					</table>
					</form>
				</td>	
				<td width="50%">
					<form name="pagtoForm" id="pagtoForm" action="remover-forma-pagto.php" method="post" onsubmit="return validarFormasPagto(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Forma de pagamento</td>
							<td width="50%">
								<select name="id_forma_pagto" id="id_forma_pagto">
									<option value="select">- selecione a forma de pagamento -
									<?php 
									//loop através das linhas da tabela formas_pagto
									while ($row = mysql_fetch_array($formas_pagto)){
										echo "<option value=$row[id_forma_pagto]>$row[forma_pagto_descricao]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"><input type="submit" name="Remover" value="Remover" /></td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
			
			<tr><td style="background:black;" colspan="2"></td></tr>
			
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="pagtoForm" id="pagtoForm" action="alterar-forma-pagto.php" method="post" onsubmit="return validarFormasPagto(this)">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Forma de pagamento</td>
							<td width="50%">
								<select name="id_forma_pagto" id="id_forma_pagto">
									<option value="select">- selecione a forma de pagamento -
									<?php 
									//loop através das linhas da tabela formas_pagto
									while ($row = mysql_fetch_array($formas_pagto_1)){
										echo "<option value=$row[id_forma_pagto]>$row[forma_pagto_descricao]"; 
									}
									?>
								</select>
							</td>
							<td width="18%"></td>
						</tr>
						<tr>
							<td width="32%">Forma de pagamento</td>
							<td width="50%"><input type="text" name="forma_pagto_descricao" class="textfield" maxlength="25" placeholder="Criar uma nova forma de pagamento" required/></td>
							<td width="18%"><input type="submit" name="Alterar" value="Alterar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
				</td>
			</tr>
		</table>
	</fieldset>
	
	<hr>
	
	<fieldset><legend>Gerenciar taxas</legend>
		<?php
			$simbolo = mysql_fetch_assoc($moeda_ativa_1); //obter moeda ativa
		?>
		<p align="center" style="color:red"><b>Atenção</b> as taxas ("Entrega", "Reserva de Mesa" e "Reserva de Salão") deverão ter os nomes mantidos para uso no sistema</p>
		
		<table width="910">
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="taxaForm" id="taxaForm" action="taxas-exec.php" method="post" onsubmit="return this">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Taxa</td>
							<td width="50%"><input type="text" name="taxa_descricao" class="textfield" maxlength="25" placeholder="Criar uma nova taxa" required/></td>
							<td width="18%"></td>
						</tr>
						<tr>
							<td width="32%">Valor (<?php echo $simbolo['moeda_simbolo']?>)</td>
							<td width="50%"><input type="text" name="taxa_valor" class="textfield formValor" maxlength="25" placeholder="Valor da nova taxa" required/></td>
							<td width="18%"><input type="submit" name="Adicionar" value="Adicionar" /></td>
						</tr>
					</table>
					</form>
				</td>	
				<td width="50%">
					<form name="taxaForm" id="taxaForm" action="remover-taxa.php" method="post" onsubmit="return this">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Taxa</td>
							<td width="50%">
								<select name="id_taxa" id="id_taxa">
									<option value="select">- selecione a taxa -
									<?php 
									//loop através das linhas da tabela taxas
									while ($row = mysql_fetch_array($taxas)){
										echo "<option value=$row[id_taxa]>".$row['taxa_descricao']." ".number_format($row['taxa_valor'],2,',','.').""; 
									}
									?>
								</select>
							</td>
							<td width="18%"><input type="submit" name="Remover" value="Remover" /></td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
			
			<tr><td style="background:black;" colspan="2"></td></tr>
			
			<tr>
				<td width="50%" style="border-right:black 10px solid;">
					<form name="taxaForm" id="taxaForm" action="alterar-taxa.php" method="post" onsubmit="return this">
					<table width="455" border="0" cellpadding="2" cellspacing="0">
						<tr>
							<td width="32%">Taxa</td>
							<td width="50%">
								<select name="id_taxa" id="id_taxa">
									<option value="select">- selecione a taxa -
									<?php 
									//loop através das linhas da tabela taxas
									while ($row = mysql_fetch_array($taxas_1)){
										echo "<option value=$row[id_taxa]>".$row['taxa_descricao']." ".number_format($row['taxa_valor'],2,',','.')."";  
									}
									?>
								</select>
							</td>
							<td width="18%"></td>
						</tr>
						<tr>
							<td width="32%">Taxa</td>
							<td width="50%"><input type="text" name="taxa_descricao" class="textfield" maxlength="25" placeholder="Alterar a taxa" required/></td>
							<td width="18%"></td>
						</tr>
						<tr>
							<td width="32%">Valor (<?php echo $simbolo['moeda_simbolo']?>)</td>
							<td width="50%"><input type="text" name="taxa_valor" class="textfield formValor" maxlength="25" placeholder="Alterar o valor da taxa" required/></td>
							<td width="18%"><input type="submit" name="Alterar" value="Alterar" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="50%">
				</td>
			</tr>
		</table>
	</fieldset>
	
	<hr>	
	
	</div>
	
	<?php require('incluir-rodape.php'); ?>
	
</div>
</body>
</html>
