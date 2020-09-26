
/*****************************************************
Desenvolvedor: Napapapão
Email: napapapao@gmail.com

COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
******************************************************/

//resetar popup senha
function resetPassword()
{
	window.open('resetar-senha.php','resetPassword','toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=no,copyhistory=no,scrollbars=yes,width=480,height=320');
}

//função de relógio ao vivo
function updateClock ( )
{
	var currentTime = new Date ( );
	var currentHours = currentTime.getHours ( );
	var currentMinutes = currentTime.getMinutes ( );
	var currentSeconds = currentTime.getSeconds ( );

	// Adicione aos minutos e segundos zeros à esquerda, se necessário
	currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
	currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

	// Escolha "AM" ou "PM", conforme apropriado
	var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

	// Converter o componente horas para o formato de 12 horas, se necessário
	currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

	// Converter componente de horas de "0" a "12"
	currentHours = ( currentHours == 0 ) ? 12 : currentHours;

	// Compor a string para exibição
	var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

	// Atualizar a visualização do tempo
	document.getElementById("clock").innerHTML = currentTimeString;
}

//validar e-mail
function isValidEmail(val) {
	var re = /^[\w\+\'\.-]+@[\w\'\.-]+\.[a-zA-Z]{2,}$/;
	if (!re.test(val)) {
		return false;
	}
    return true;
}

//validate caracteres especial da senha
function isValidSpecialPIN(val) {
	var re = /^[0-9][0-9][A-Z][A-Z][A-Z][0-9][0-9][0-9][0-9][0-9][0-9][0-9]$/;
	if (!re.test(val)) {
		return false;
	}
	return true;
}

//validar comprimento da senha
function isValidLength(val){
	var length = 12;
	if (!re.test(val)) {
		return false;
	}
	return true;
}

// Ao mudar o campo quantidade totalizar o preço
function getProductTotal(field) {
    clearErrorInfo();
    var form = field.form;
	if (field.value == "") field.value = 0;
	if ( !isPosInt(field.value) ) {
        var msg = 'Por favor insira um número inteiro positivo para a quantidade.';
        addValidationMessage(msg);
        addValidationField(field)
        displayErrorInfo( form );
        return;
	} else {
		var product = field.name.slice(0, field.name.lastIndexOf("_") ); 
        var price = form.elements[product + "_price"].value;
		var amt = field.value * price;
		form.elements[product + "_tot"].value = formatDecimal(amt);
		doTotals(form);
	}
}

function doTotals(form) {
    var total = 0;
    for (var i=0; PRODUCT_ABBRS[i]; i++) {
        var cur_field = form.elements[ PRODUCT_ABBRS[i] + "_qty" ]; 
        if ( !isPosInt(cur_field.value) ) {
            var msg = 'Por favor insira um número inteiro positivo para a quantidade.';
            addValidationMessage(msg);
            addValidationField(cur_field)
            displayErrorInfo( form );
            return;
        }
        total += parseFloat(cur_field.value) * parseFloat( form.elements[ PRODUCT_ABBRS[i] + "_price" ].value );
    }
    form.elements['total'].value = formatDecimal(total);
}

//validar orderform
function finalCheck(orderForm) {
    var verificarValidacao=true;
	var mensagemErro="";

	if (orderForm.quantity.value=="")
	{
		mensagemErro+="Por favor, forneça uma quantidade.\n";
		verificarValidacao=false;
	}
	if (orderForm.quantity.value==0)
	{
		mensagemErro+="Por favor, forneça uma quantidade em vez de 0 (zero).\n";
		verificarValidacao=false;
	}
	if(orderForm.total.value=="")
	{
		mensagemErro+="Total não foi calculado! Por favor, forneça primeiro a quantidade.\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do formulário de login (index.php) (login-registrar.php)
function validarLogin(loginForm){

	var verificarValidacao=true;
	var mensagemErro="";

	if (loginForm.email.value=="")
	{
		mensagemErro+="E-mail não preenchido!\n";
		verificarValidacao=false;
	}
	if(loginForm.senha.value=="")
	{
		mensagemErro+="Senha não preenchida!\n";
		verificarValidacao=false;
	}
	if (!isValidEmail(loginForm.email.value)) {
		mensagemErro+="E-mail fornecido é inválido!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do registroForm (index.php) (login-registrar.php)
function validarRegistro(registroForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (registroForm.nome.value=="")
	{
		mensagemErro+="Primeiro nome não fornecido!\n";
		verificarValidacao=false;
	}
	if(registroForm.sobrenome.value=="")
	{
		mensagemErro+="Último nome não fornecido!\n";
		verificarValidacao=false;
	}
	if (registroForm.email.value=="")
	{
		mensagemErro+="E-mail não fornecido!\n";
		verificarValidacao=false;
	}
	if(registroForm.senha.value=="")
	{
		mensagemErro+="Senha não fornecida!\n";
		verificarValidacao=false;
	}
	if(registroForm.csenha.value=="")
	{
		mensagemErro+="Confirmação de senha não fornecida!\n";
		verificarValidacao=false;
	}
	if(registroForm.csenha.value!=registroForm.senha.value)
	{
		mensagemErro+="Senha e Confirmação de Senha não conferem!\n";
		verificarValidacao=false;
	}
	if (!isValidEmail(registroForm.email.value)) {
		mensagemErro+="E-mail fornecido é inválido!\n";
		verificarValidacao=false;
	}
	if(registroForm.pergunta.selectedIndex==0)
	{
		mensagemErro+="Pergunta não selecionada!\n";
		verificarValidacao=false;
	}
	if(registroForm.resposta.value=="")
	{
		mensagemErro+="Resposta não fornecida!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação Redefinir Formulário de senha (resetar-senha-php)
function validarResetSenha(resetForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (resetForm.email.value=="")
	{
		mensagemErro+="Digite sua conta de e-mail! Precisamos de seu e-mail, a fim de redefinir sua senha.\n";
		verificarValidacao=false;
	}
	if (!isValidEmail(resetForm.email.value)) {
		mensagemErro+="E-mail fornecido é inválido!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do resetForm (2) (resetar-senha-php)
function validarResetSenha2(resetForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (resetForm.resposta.value==""){
		mensagemErro+="Por favor, indique a sua resposta de segurança para sua pergunta de segurança fornecida.\n";
		verificarValidacao=false;
	}
	if (resetForm.nova_senha.value==""){
		mensagemErro+="Nova senha não definida!\n";
		verificarValidacao=false;
	}
	if (resetForm.cnova_senha.value==""){
		mensagemErro+="Confirmação da nova senha não definida!\n";
		verificarValidacao=false;
	}
	if (resetForm.nova_senha.value!=resetForm.cnova_senha.value){
		mensagemErro+="Nova Senha e Confirmação da Nova Senha não conferem!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//validar alteracaoSenhaForm (meu-perfil-php)
function validarAlteracaoSenha(alteracaoSenhaForm) {
    var verificarValidacao=true;
	var mensagemErro="";

	if (alteracaoSenhaForm.senhaantiga.value=="")
	{
		mensagemErro+="Por favor, forneça sua senha antiga.\n";
		verificarValidacao=false;
	}
	if (alteracaoSenhaForm.senhanova.value=="")
	{
		mensagemErro+="Por favor, forneça sua senha nova.\n";
		verificarValidacao=false;
	}
	if(alteracaoSenhaForm.senhanovaconfirm.value=="")
	{
		mensagemErro+="Por favor, confirme a sua nova senha.\n";
		verificarValidacao=false;
	}
	if(alteracaoSenhaForm.senhanovaconfirm.value!=alteracaoSenhaForm.senhanova.value)
	{
		mensagemErro+="Confirmação da Senha e Nova Senha não correspondem!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//validate enderecoForm (endereco-cadastro.php) (meu-perfil.php)
function validarEndereco(enderecoForm) {
    var verificarValidacao=true;
	var mensagemErro="";

	if (enderecoForm.endereco.value=="")
	{
		mensagemErro+="Por favor, forneça um endereço.\n";
		verificarValidacao=false;
	}
	if (enderecoForm.cep.value=="")
	{
		mensagemErro+="Por favor, forneça o Código Postal (CEP)\n";
		verificarValidacao=false;
	}
	if (enderecoForm.cidade.value=="")
	{
		mensagemErro+="Por favor, forneça a cidade.\n";
		verificarValidacao=false;
	}
	if(enderecoForm.celular.value=="")
	{
		mensagemErro+="Por favor forneça o nº do celular.\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//validar form de mesas (mesas.php)
function validarMesa(mesaForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (mesaForm.id_mesa.selectedIndex==0)
	{
		mensagemErro+="Por favor, selecione uma mesa pelo seu nome ou número.\n";
		verificarValidacao=false;
	}
	if (mesaForm.reserva_data.value=="")
	{
		mensagemErro+="Por favor forneça uma data de reserva.\n";
		verificarValidacao=false;
	}
	if (mesaForm.reserva_tempo.value=="")
	{
		mensagemErro+="Por favor, forneça o horário da reserva.\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//validar form Salão de festas (saloes-festa.php)
function validarSalaoFestas(salaofestasForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (salaofestasForm.id_salao_festas.selectedIndex==0)
	{
		mensagemErro+="Por favor selecione um salão de festas pelo seu nome ou número.\n";
		verificarValidacao=false;
	}
	if (salaofestasForm.reserva_data.value=="")
	{
		mensagemErro+="Por favor forneça uma data de reserva.\n";
		verificarValidacao=false;
	}
	if (salaofestasForm.reserva_tempo.value=="")
	{
		mensagemErro+="Por favor, forneça o horário da reserva.\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//validar form de categorias (categorias.php)
function validarCategorias(categoriaForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (categoriaForm.categoria.selectedIndex==0)
	{
		mensagemErro+="Por favor selecione primeiro a categoria!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//validar form de quantidade (carrinho.php)
function atualizarQuantidade(quantidadeForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (quantidadeForm.id_comida.selectedIndex==0)
	{
		mensagemErro+="Por favor selecione primeiro uma comida!\n";
		verificarValidacao=false;
	}
	if (quantidadeForm.id_quantidade.selectedIndex==0)
	{
		mensagemErro+="Por favor selecione primeiro a quantidade!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//validar form de avaliação (avalie-nos.php)
function validarAvaliacao(avaliacaoForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (avaliacaoForm.id_comida.selectedIndex==0)
	{
		mensagemErro+="Por favor selecione a comida. Esta informação é necessária, a fim de servi-lo melhor.\n";
		verificarValidacao=false;
	}
	if (avaliacaoForm.id_classificacao.selectedIndex==0)
	{
		mensagemErro+="Por favor, selecione a escala. Esta informação é necessária, a fim de servir melhor.\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

 //validar quantidade e redirecionr as quantidades para update-quantity.php
function getQuantity(int)
{
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.open("GET","update-quantity.php?quantity_id="+int,true);
    xmlhttp.send();
}

//função para lidar com a validação de mensagens (contatos.php)
function validarMensagem(mensagemForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (mensagemForm.nome.value=="")
	{
		mensagemErro+="Nome não preenchido!\n";
		verificarValidacao=false;
	}
	if (mensagemForm.sobrenome.value=="")
	{
		mensagemErro+="Último nome não preenchido!\n";
		verificarValidacao=false;
	}
	if (mensagemForm.email.value=="")
	{
		mensagemErro+="E-mail não fornecido!\n";
		verificarValidacao=false;
	}
	if (!isValidEmail(mensagemForm.email.value)) {
		mensagemErro+="E-mail inválido fornecido!\n";
		verificarValidacao=false;
	}
	if (mensagemForm.assunto.value=="")
	{
		mensagemErro+="Assunto não preenchido!\n";
		verificarValidacao=false;
	}
	if (mensagemForm.txtmensagem.value=="")
	{
		mensagemErro+="Caixa de mensagem não preenchida!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do pagtoForm (forma-pagto.php)
function validarPagto(pagtoForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if(pagtoForm.id_forma_pagto.selectedIndex==0)
	{
		mensagemErro+="Forma de pagamento não selecionada!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

