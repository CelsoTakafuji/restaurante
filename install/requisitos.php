<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	//verificação de versão php
	$php_version=phpversion(); //recebe versão php do servidor
	
	if($php_version<5){
		$php_status="PHP versão é $php_version - demasiada velha!";
		$php_status_error=1; //define uma bandeira vermelha
	}
	else{
		$php_status="$php_version - OK!";
		$php_status_error=0; //define uma bandeira verde
	}
?>
<?php
	//Verificação de versão mysql
	//Declarar função para obter a versão do mysql
	function find_SQL_Version() { 
	  $output = @shell_exec('mysql -V');    
	  preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version); 
	  return @$version[0]?$version[0]:-1; 
	}

	$mysql_version=find_SQL_Version(); //obter a versão do mysql da função
	if($mysql_version<5){
		if($mysql_version==-1){
			$mysql_status="versão do MySQL será verificada na próxima etapa.";
			$mysql_status_error=1; //define uma bandeira vermelha
		}
		else{
			$mysql_status="versão do MySQL é $mysql_version. Versão 5 ou superior é requerida.";
			$mysql_status_error=1; //define uma bandeira vermelha
		}
	}
	else{
		$mysql_status="$mysql_version - OK!";
		$mysql_status_error=0; //define uma bandeira verde
	}
?>
<?php
	//checking mail function
	if(!function_exists('mail')){
		$mail_status="PHP Mail! função não está habilitada";
		$mail_status_error=1; //define uma bandeira vermelha
	}
	else{
		$mail_status="Parece habilitada!";
		$mail_status_error=0; //define uma bandeira verde
	}
?>
<?php
	//verificar o modo de segurança
	if( ini_get("safe_mode") ){
		$safeMode_status="Por favor, desligue o PHP Safe Mode (pode ser encontrado no php.ini)";
		$safeMode_status_error=1; //define uma bandeira vermelha
	}
	else{
		$safeMode_status="OK!";
		$safeMode_status_error=0; //define uma bandeira verde
	}
?>
<?php
	//verificação de sessões
	$_SESSION['check_sessions_work']=1;
	if(empty($_SESSION['check_sessions_work'])){
		$session_status="Sessões devem ser ativadas!";
		$session_status_error=1; //define uma bandeira vermelha
	}
	else{
		$session_status="OK!";
		$session_status_error=0; //define uma bandeira verde
	}
?>
<?php
	//Verificar a compatibilidade do navegador com HTML5
	class Browser { 
            public static function detect() { 
                $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']); 
                if ((substr($_SERVER['HTTP_USER_AGENT'],0,6)=="Opera/") || (strpos($userAgent,'opera')) != false ){ 
                    $name = 'Opera';
                } 
                elseif ((strpos($userAgent,'chrome')) != false) { 
                    $name = 'Chrome'; 
                } 
                elseif ((strpos($userAgent,'safari')) != false && (strpos($userAgent,'chrome')) == false && (strpos($userAgent,'chrome')) == false){ 
                    $name = 'Safari'; 
                } 
                elseif (preg_match('/msie/', $userAgent)) { 
                    $name = 'Msie'; 
                } 
                elseif ((strpos($userAgent,'firefox')) != false) { 
                    $name = 'Firefox'; 
                } 
                else { 
                    $name = 'Unrecognized'; 
                }
				if (preg_match('/.+(?:me|ox|it|ra|ie)[\/: ]([\d.]+)/', $userAgent, $matches)) { 
					$version = $matches[1]; 
				}
				if (preg_match('/.+(?:me|ox|it|on|ra|ie)[\/: ]([\d.]+)/', $userAgent, $matches)) { 
					$version = $matches[1]; 
				}
                else { 
                    $version = 'Unknown!'; 
                } 

                return array( 
                    'name'      => $name, 
                    'version'   => $version,
                ); 
            } 
        } 
        $browser = Browser::detect();
		if($browser['name']=="Chrome"){
			$browser_status='O seu navegador é ' .$browser['name'].' versão '.$browser['version'].' - OK!';
			$browser_status_error=0; //define uma bandeira verde
		}
		else{
			$browser_status='O seu navegador é ' .$browser['name'].' versão '.$browser['version'].' - menos compatível! (atualize para o Chrome)';
			$browser_status_error=1; //define uma bandeira vermelha
		}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Passo 2: Requisitos</title>
<link href="stylesheets/install_styles.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="validation/install.js">
</script>
</head>
<body>
<div id="page">
<div id="header">
<h1>Requisitos de instalação</h1>
<a href="index.php">Bem-vindo</a> -> <a href="requirements.php">Requisitos</a>
</div>
<div id="container">
	<fieldset><legend>Verificação de configuração do sistema</legend>
		<form action="conexao.php">
		  <table width="930" border="1" align="center">
		  	<tr>
			  <th align="center">Característica</th>
			  <th align="center">Estado</th>
			</tr>
			<tr>
			  <td>PHP Versão (Deve ser 5 ou melhor) </td>
			  <td><?php if($php_status_error==0) echo "<span style='color:green;'>$php_status</span>"; else echo "<span style='color:red;'>$php_status</span>";?></td>
			</tr>
			<tr>
			  <td>MySQL Versão (Deve ser 5 ou melhor) </td>
			  <td><?php if($mysql_status_error==0) echo "<span style='color:green;'>$mysql_status</span>"; else echo "<span style='color:red;'>$mysql_status</span>";?></td>
			</tr>
			<tr>
			  <td>PHP "mail" função deve ser ativada </td>
			  <td><?php if($mail_status_error==0) echo "<span style='color:green;'>$mail_status</span>"; else echo "<span style='color:red;'>$mail_status</span>";?></td>
			</tr>
			<tr>
			  <td>PHP "safe mode" deve estar desligado </td>
			  <td><?php if($safeMode_status_error==0) echo "<span style='color:green;'>$safeMode_status</span>"; else echo "<span style='color:red;'>$safeMode_status</span>";?></td>
			</tr>
			<tr>
			  <td>PHP sessões devem trabalhar </td>
			  <td><?php if($session_status_error==0) echo "<span style='color:green;'>$session_status</span>"; else echo "<span style='color:red;'>$session_status</span>";?></td>
			</tr>
			<tr>
			  <td>Navegador deve ser compatível com HTML5 </td>
			  <td><?php if($browser_status_error==0) echo "<span style='color:green;'>$browser_status</span>"; else echo "<span style='color:red;'>$browser_status</span>";?></td>
			</tr>
			<tr>
			  <td colspan="4" align="center"><input type="submit" name="Submit" value="Somente Clique Aqui se TODOS os requisitos acima estiverem OK para prosseguir" /></td>
			</tr>
		  </table>
		</form>
	</fieldset>
</div>

<?php require('incluir-rodape.php'); ?>

</div>
</body>
</html>