<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	require_once('auth.php');
	require_once('locale.php');
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
    
    //Definir o valor padrão para a flag
    $flag_1 = 1;
    
    //Definir variáveis globais
    $qry="";
    $excellent_qry="";
    $good_qry="";
    $average_qry="";
    $bad_qry="";
    $worse_qry="";
    
	//contar o número de registros nas tabelas members, orders_details e reservations_details 
	$members=mysql_query("SELECT * FROM members")
	or die("Não há registros para contar... \n" . mysql_error()); 

	$orders_placed=mysql_query("SELECT * FROM orders_details")
	or die("Não há registros para contar... \n" . mysql_error());

	$orders_processed=mysql_query("SELECT * FROM orders_details WHERE flag='$flag_1'")
	or die("Não há registros para contar... \n" . mysql_error());

	$tables_reserved=mysql_query("SELECT * FROM reservations_details WHERE table_flag='$flag_1'")
	or die("Não há registros para contar... \n" . mysql_error());

	$partyhalls_reserved=mysql_query("SELECT * FROM reservations_details WHERE partyhall_flag='$flag_1'")
	or die("Não há registros para contar... \n" . mysql_error());

	$tables_allocated=mysql_query("SELECT * FROM reservations_details WHERE flag='$flag_1' AND table_flag='$flag_1'")
	or die("Não há registros para contar... \n" . mysql_error());

	$partyhalls_allocated=mysql_query("SELECT * FROM reservations_details WHERE flag='$flag_1' AND partyhall_flag='$flag_1'")
	or die("Não há registros para contar... \n" . mysql_error());

	//obter detalhes dos alimentos através da tabela food_details
	$foods=mysql_query("SELECT * FROM food_details")
	or die("Algo está errado... \n" . mysql_error());
?>
<?php
    if(isset($_POST['Submit'])){
		//Função para limpar os valores recebidos do formulário. Impede SQL Injection
        function clean($str) {
            $str = @trim($str);
            if(get_magic_quotes_gpc()) {
                $str = stripslashes($str);
            }
            return mysql_real_escape_string($str);
        }
        //obter id da categoria
        $id = clean($_POST['food']);
        
        //Obter id de classificações
        $ratings=mysql_query("SELECT * FROM ratings")
        or die("Algo está errado... \n" . mysql_error());
        $row_1=mysql_fetch_array($ratings);
        $row_2=mysql_fetch_array($ratings);
        $row_3=mysql_fetch_array($ratings);
        $row_4=mysql_fetch_array($ratings);
        $row_5=mysql_fetch_array($ratings);
		
        if($row_1){
            $excellent=$row_1['rate_id'];
        }
        if($row_2){
            $good=$row_2['rate_id'];
        }
        if($row_3){
            $average=$row_3['rate_id'];
        }
        if($row_4){
            $bad=$row_4['rate_id'];
        }
        if($row_5){
            $worse=$row_5['rate_id'];
        }
        
        //selecionar todos os registros das tabelas food_details e polls_details de acordo com o id. Retornar um erro se não há registros na tabela
        $qry=mysql_query("SELECT * FROM food_details, polls_details WHERE polls_details.food_id='$id' AND food_details.food_id='$id'")
        or die("Algo está errado... \n" . mysql_error());
        
        $excellent_qry=mysql_query("SELECT * FROM food_details, polls_details WHERE polls_details.food_id='$id' AND food_details.food_id='$id' AND polls_details.rate_id='$excellent'")
        or die("Algo está errado... \n" . mysql_error()); 
        
        $good_qry=mysql_query("SELECT * FROM food_details, polls_details WHERE polls_details.food_id='$id' AND food_details.food_id='$id' AND polls_details.rate_id='$good'")
        or die("Algo está errado... \n" . mysql_error()); 
        
        $average_qry=mysql_query("SELECT * FROM food_details, polls_details WHERE polls_details.food_id='$id' AND food_details.food_id='$id' AND polls_details.rate_id='$average'")
        or die("Algo está errado... \n" . mysql_error()); 
        
        $bad_qry=mysql_query("SELECT * FROM food_details, polls_details WHERE polls_details.food_id='$id' AND food_details.food_id='$id' AND polls_details.rate_id='$bad'")
        or die("Algo está errado... \n" . mysql_error());
        
        $worse_qry=mysql_query("SELECT * FROM food_details, polls_details WHERE polls_details.food_id='$id' AND food_details.food_id='$id' AND polls_details.rate_id='$worse'")
        or die("Algo está errado... \n" . mysql_error());  
        
        $no_rate_qry=mysql_query("SELECT * FROM food_details WHERE food_id='$id'")
        or die("Algo está errado... \n" . mysql_error());
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Página Inicial de Administração</title>
<link href="stylesheets/admin_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/admin.js">
</script>
</head>
<body>
<div id="page">
	<div id="header">
		<h1>Painel de Controle do Administrador</h1>
		<?php require('include-menu.php'); ?>
	</div>
	
	<div id="container">
		<fieldset><legend>Status atual</legend>
		<table width="930" align="center" style="text-align:center; font-size:13px;">
			<tr>
				<th>Os membros registados</th>
				<th>Os pedidos colocados</th>
				<th>Encomendas processadas</th>
				<th>Encomendas pendentes</th>  
				<th>Mesas reservadas</th>
				<th>Mesas atribuídas</th>
				<th>Mesas pendentes</th>
				<th>Salões de Festas reservados</th>
				<th>Salões de Festas atribuídos</th>
				<th>Salões de Festas pendentes</th>    
			</tr>

			<?php
				$result1=mysql_num_rows($members);
				$result2=mysql_num_rows($orders_placed);
				$result3=mysql_num_rows($orders_processed);
				$result4=$result2-$result3; //obter ordem(ns) pendente(s)
				$result5=mysql_num_rows($tables_reserved);
				$result6=mysql_num_rows($tables_allocated);
				$result7=$result5-$result6; //obter mesa(s) pendente(s)
				$result8=mysql_num_rows($partyhalls_reserved);
				$result9=mysql_num_rows($partyhalls_allocated);
				$result10=$result8-$result9; //obter salão(ões) de festa pendente(s)
				echo "<tr align=>";
					echo "<td>" . $result1."</td>";
					echo "<td>" . $result2."</td>";
					echo "<td>" . $result3."</td>";
					echo "<td>" . $result4."</td>";
					echo "<td>" . $result5."</td>";
					echo "<td>" . $result6."</td>";
					echo "<td>" . $result7."</td>";
					echo "<td>" . $result8."</td>";
					echo "<td>" . $result9."</td>";
					echo "<td>" . $result10."</td>";
				echo "</tr>";
			?>
			</table>
			</fieldset>
			<hr>
			<fieldset><legend>Avaliações dos clientes (100%)</legend>
			<form name="foodStatusForm" id="foodStatusForm" method="post" action="index.php" onsubmit="return statusValidate(this)">
				<table width="360" align="center">
					 <tr>
						<td>Comida</td>
						<td width="168">
						<select name="food" id="food">
							<option value="select">- selecione a comida -
							<?php 
								//loop através de linhas da tabela foods
								while ($row=mysql_fetch_array($foods)){
									echo "<option value=$row[food_id]>$row[food_name]"; 
								}
							?>
						</select>
						</td>
						<td><input type="submit" name="Submit" value="Mostrar Pontuações" /></td>
					 </tr>
				</table>
			</form>
			<table width="900" align="center">
			<?php
				if(isset($_POST['Submit'])){
					
					echo "<tr>";
						echo "<th></th>";
						echo "<th>$row_1[rate_name]</th>";
						echo "<th>$row_2[rate_name]</th>";
						echo "<th>$row_3[rate_name]</th>";
						echo "<th>$row_4[rate_name]</th>";
						echo "<th>$row_5[rate_name]</th>";
					echo "</tr>";
					
					//valores atuais
					$excellent_value=mysql_num_rows($excellent_qry);
					$good_value=mysql_num_rows($good_qry);
					$average_value=mysql_num_rows($average_qry);
					$bad_value=mysql_num_rows($bad_qry);
					$worse_value=mysql_num_rows($worse_qry);
					
					//taxas percentuais
					$total_value=mysql_num_rows($qry);
					if($total_value != 0){
						$excellent_rate=$excellent_value/$total_value*100;
						$good_rate=$good_value/$total_value*100;
						$average_rate=$average_value/$total_value*100;
						$bad_rate=$bad_value/$total_value*100;
						$worse_rate=$worse_value/$total_value*100;
					}
					else{
						$excellent_rate=0;
						$good_rate=0;
						$average_rate=0;
						$bad_rate=0;
						$worse_rate=0;
					}
					//obter o nome do alimento
					if(mysql_num_rows($qry)>0){
						$row=mysql_fetch_array($qry);
						$food_name=$row['food_name'];
					}
					else{
						$row=mysql_fetch_array($no_rate_qry);
						$food_name=$row['food_name'];
					}
					echo "<tr>";
					echo "<th>" .$food_name."</th>";
					echo "<td>" .$excellent_value."(". round($excellent_rate,2)."%)"."</td>";
					echo "<td>" .$good_value."(". round($good_rate,2)."%)"."</td>";
					echo "<td>" .$average_value."(". round($average_rate,2)."%)"."</td>";
					echo "<td>" .$bad_value."(". round($bad_rate,2)."%)"."</td>";
					echo "<td>" .$worse_value."(". round($worse_rate,2)."%)"."</td>";
					echo "</tr>";
				}
			?>
			</table>
			</fieldset>
			<hr>
	</div>
	
	<?php require('include-footer.php'); ?>
	
</div>
</body>
</html>
