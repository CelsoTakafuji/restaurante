﻿<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	//Iniciar sessão
	session_start();
	
	//Verifique se a variável de sessão SESS_MEMBER_ID está presente ou não
	if(!isset($_SESSION['SESS_ADMIN_ID']) || (trim($_SESSION['SESS_ADMIN_ID']) == '')) {
		header("Location: acesso-negado.php");
		exit();
	}
?>