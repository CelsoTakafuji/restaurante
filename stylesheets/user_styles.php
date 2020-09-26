﻿<?
	/*****************************************************
	Desenvolvedor: Napapapão
	Email: napapapao@gmail.com

	COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
	******************************************************/
?>
<?php
	require_once('../admin/styles.php');
	header("Content-type: text/css");
?>

* html #wrap{
	height: 100%;
}

html,body {
	margin:0;
	padding:0;
	background:<?php if(@$background_color=='#000000') echo '#bd6f2f'; else echo @$background_color; ?> url("<?php if(@$background=='' && @$background_color=='#000000') echo '../images/base-bg.gif'; elseif(@$background=='' && @$background_color!='#000000') echo @$background_color; else echo '../images/'. @$background. ''; ?>") repeat-x top;
	width:100%;
	height:100%;
	font-family:tahoma;
}

a img{
	border:0;
}

a{
	color: #B80000;
	text-decoration: underline;
}

a:hover{
	color: #FF4322;
	text-decoration: underline;
}

a.hidden {
	text-decoration: none;
	color: #000000;
	cursor:default;
}

form {
	margin:0;
	padding:0;
}

h1 {
	font-weight: bold;
	color: #000000;
	margin: 0px; 
	font-size:15px;
	text-transform:uppercase; 
	margin: 15px 0 8px 0;
}

h3 {
	font-weight:bold;
	text-align:center;
	color:#bd6f2f;
}

h2{
	font-weight:bold;
	text-align:center;
	color:#bd6f2f;
}

p {
	text-align:center;
}

.error{
	text-align:center;
	color:#FF0000;
	font-weight:bold;
	font-size:15px;
}

.bottom_addr {
	font-size: 11px;
	color: #000;
	padding: 5px 0 12px 0; 
	text-align:center; 
	font-size:10px;
}

.bottom_addr a {
	text-decoration: none;
}

.bottom_addr a:hover {
	text-decoration: underline;
}

.bottom_menu {
	color: #000000;
	text-align: center;
	padding-top: 12px;
	padding-bottom: 4px; 
	font-size:11px;
}

.bottom_menu a {
	color: #000000;
	text-decoration: none;
}

.bottom_menu a:hover {
	color: #000000;
	text-decoration: underline;
}

.body_txt {
	color: #000000;
	text-align: justify;
	padding: 10px;
	vertical-align: top;
}

.textfield {
	font-size: 11px;
	color: #333333;
	padding-left: 1px;
}

.carrinho a{
	color: black;
	font-size: 14;
	text-decoration: underline;
}

.carrinho a:hover{
	color: #FF4322;
	text-decoration: underline;
}

.paginacao {
	background:black;
}

.paginacao a{
	color:white;
}

.paginacao a:hover{
	color:red;
}

.tituloTabela {
	background:#f0d28e;
}

#wrap{
	position:relative; 
	min-height:100%; 
	margin:0 auto; 
	width:100%;
}

#page{
	width:1000px;
	margin:0 auto; 
	padding-top:14px;
}

#menu{ 
	border-top: 1px solid #d19b6f;
	border-left: 1px solid #d19b6f;
	border-right: 1px solid #d19b6f;
	width:939px; 
	margin:0 auto; 
	background:#f9dec7; 
	position:relative; 
	height:44px; 
	overflow:hidden; 
	text-align:left;
}

#menu ul {
	padding:0px;
	margin:0px;
	margin-left:50px;
}

#menu ul li {
	width:auto;
	height:30px;
	float:left;
	font-family:Arial, Helvetica, sans-serif;
	font-size:15px;
	color:#000000;
	background-repeat:no-repeat;
	background-position:left center;
	line-height:20px;
	text-align:center;
	margin-left:0px;
	list-style:none;
	padding-left:65px;
	padding-top:10px;
	background:url(images/icon_menu.gif);
}

#menu ul li a {
	width:auto;
	height:30px;
	float:left;
	text-decoration:none;
	font-family:Arial, Helvetica, sans-serif;
	font-size:15px;
	color:#000000;
	list-style:none;
}

#menu ul li a:hover{
	text-decoration:none;
	color:#B00203;
}

#footer{
	width:939px; 
	margin:0 auto; 
	background:<?php if(@$footer_color=='#000000') echo '#f9dec7'; else echo @$footer_color; ?> url("<?php echo '../images/'. @$footer. ''; ?>") repeat;
	border: 1px solid #fff6f3;
}

#center{
	width:911px; 
	margin:0 auto; 
	background:<?php if(@$center_color=='#000000') echo '#fff6f3'; else echo @$center_color; ?> url("<?php echo '../images/'. @$center. ''; ?>") repeat; 
	padding:15px; 
	font-size:12px; 
	text-align:justify;
}

#center input{
	width: 150px;
}

#reset{
	width:400px; 
	margin:0 auto; 
	background:#fff6f3; 
	padding:15px; 
	font-size:12px; 
	text-align:center;
}

#header{ 
	width:1000px; 
	background:url("<?php if(@$header=='') echo '../images/head-img.jpg'; else echo '../images/'. @$header. ''; ?>") no-repeat; height:276px;
	background-size: cover;
}

#company_name {
	font-size: 24px;
	text-transform: none;
	color: #FFFFFF;
	position:absolute; 
	color:#f9e4be; 
	font-family:"trebuchet MS"; 
	width:250px; 
	text-align:center; 
	margin-top:165px;
	margin-left:25px;
}

#logo{background:url("<?php if(@$logo=='') echo '../images/logo.gif'; else echo '../images/'. @$logo. ''; ?>") no-repeat; 
	width:90px; 
	height:89px; 
	position:absolute; 
	margin: 67px 0 0 105px;
}

.blockLink
{
	position:absolute;
	top:0;
	left: 0;
	width:100%;
	height:100%;
	z-index: 1;
}

.stretchX {
    width: 1000px;
}
 
.stretchXY {
    width: 200px; height: 300px
}