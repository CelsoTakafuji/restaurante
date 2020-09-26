	<?php
	//Iniciar sessão
	session_start();
	?>
	<div class="carrinho" align="right" style="padding-right:40; padding-bottom:10;">
		<?php
			//Verificar se a variável de sessão SESS_MEMBER_ID está presente ou não
			if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {	
				//Não exibir
			}else{
				echo '<a href="carrinho.php" alt="Acessar carrinho de compras" target="_blank"><img src="ico/carrinho.png" width="16" height="16"> Meu carrinho de compras</a>';
			}
		?>
	</div>
	
	<div id="menu">
	  <ul>
		  <li><a href="index.php">Página inicial</a></li>
		  <li><a href="zona-alimentacao.php">Zona de alimentação</a></li>
		  <li><a href="promocoes.php">Ofertas especiais</a></li>
		  <?php
		  	//Verificar se a variável de sessão SESS_MEMBER_ID está presente ou não
			if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
				//Não exibir
			}else{
				echo '<li><a href="minha-conta.php">Minha conta</a></li>';
			}
		  ?>
		  <li><a href="contatos.php">Entre em contato</a></li>
	  </ul>
	</div>
	
	<div id="header" class="stretchX">
		<div id="logo"> <a href="index.php" class="blockLink"></a></div>
		<div id="company_name"><?php echo $nome ?></div>
	</div>