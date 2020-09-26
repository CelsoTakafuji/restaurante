
/*****************************************************
Desenvolvedor: Napapapão
Email: napapapao@gmail.com

COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
******************************************************/

//função para lidar com a validação fo formulário de conexão
function validarConexao(conForm){
	var validationVerified=true;
	var errorMessage="";

	if (conForm.dbName.value=="")
	{
		errorMessage+="Nome do banco de dados não foi preenchido!\n";
		validationVerified=false;
	}
	if(conForm.dbHost.value=="")
	{
		errorMessage+="Nome do host do banco de dados não preenchido!\n";
		validationVerified=false;
	}
	if (conForm.dbUser.value=="")
	{
		errorMessage+="Nome de suário do banco de dados não preenchido!\n";
		validationVerified=false;
	}
	if(conForm.dbPass.value=="" && conForm.local.checked==false)
	{
		errorMessage+="Senha do banco de dados não foi preenchida! Não é aconselhável deixar seu banco de dados desprotegido! Se você estiver executando o script localmente e a senha é nula, em seguida, marque a caixa uso local para ignorar este aviso.\n";
		validationVerified=false;
	}
	if(!validationVerified)
	{
		alert(errorMessage);
	}
	return validationVerified;
}

//função para lidar com a validação de formulário do admin
function validarAdmin(adminForm){
	var validationVerified=true;
	var errorMessage="";

	if (adminForm.adminName.value=="")
	{
		errorMessage+="Usuário do administrador não preenchido!\n";
		validationVerified=false;
	}
	if(adminForm.adminPass.value=="")
	{
		errorMessage+="Senha do administrador não preenchida!\n";
		validationVerified=false;
	}
	if(!validationVerified)
	{
		alert(errorMessage);
	}
	return validationVerified;
}