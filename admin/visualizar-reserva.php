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
	
    if (isset($_GET['id']))
    {
        //Obter o valor id
        $id_reserva = $_GET['id'];
    }
    else
    //Se o id não está definido, redirecionar de volta para as comidas
    {
        die("Reserva não selecionada!");
    }
	
	//Selecionar todos os registros das tabelas clientes, reservas e mesas. Retornar um erro se não há registros na tabela
	$resultado = mysql_query("SELECT clientes.id_cliente, clientes.nome, clientes.sobrenome, reservas.id_reserva, reservas.id_mesa, reservas.id_salao_festas, reservas.reserva_data, reservas.reserva_tempo, mesas.id_mesa, mesas.mesa_nome, saloes_festa.id_salao_festas, saloes_festa.salao_festas_nome, funcionarios.id_funcionario, funcionarios.nome as nome_funcionario, funcionarios.sobrenome as sobrenome_funcionario FROM reservas LEFT OUTER JOIN saloes_festa ON reservas.id_salao_festas = saloes_festa.id_salao_festas LEFT OUTER JOIN mesas ON reservas.id_mesa = mesas.id_mesa LEFT OUTER JOIN funcionarios ON reservas.id_funcionario = funcionarios.id_funcionario, clientes WHERE clientes.id_cliente = reservas.id_cliente AND reservas.id_reserva = $id_reserva")
	or die("Não há registros para mostrar... \n" . mysql_error()); 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reserva Selecionada</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<link rel="icon" type="image/png" href="../ico/chave.png" />
<script language="JavaScript" src="validation/admin.js"></script>
</head>
<body>
<div id="page" style="width:770px;">
	<div id="header">
		<h1>Reserva Selecionada</h1>
	</div>
	
	<div id="container" style="width:750px;">
		<!--ALTERAÇÃO-->
		<fieldset><legend>Reserva</legend>
			<table border="1" width="735" align="center">
			
			<tr class="tituloTabela">
				<th>Código</th>
				<th>Cliente</th>
				<th width="180">Nome</th>
				<th>Data</th>
				<th>Horário</th>
				<th>Funcionário</th>
			</tr>

			<?php
			//loop através de todas as linhas da tabela
			while ($row = mysql_fetch_array($resultado)){ 
				echo "<tr>";
					echo "<td align=\"center\">" . $row['id_reserva']."</td>";
					
					echo "<td>";
						echo $row['nome']." ".$row['sobrenome'];
					echo "</td>";
					
					echo "<td>";
						if($row['mesa_nome']!=""){
							echo $row['mesa_nome'];
						}else{
							echo $row['salao_festas_nome'];
						}
					echo "</td>";
					
					echo "<td>".date('d/m/Y',strtotime($row['reserva_data']))."</td>";
					echo "<td>".date('H:i:s',strtotime($row['reserva_tempo']))."</td>";
				
					echo "<td>";
						echo $row['nome_funcionario']." ".$row['sobrenome_funcionario'];
					echo "</td>";
					
				echo "</tr>";
			}
			?>
			</table>
		</fieldset>
		<hr>
		
	
	<?php
		mysql_free_result($resultado);
		mysql_close($link);
	?>	
	
</div>
</body>
</html>