
/*****************************************************
Desenvolvedor: Napapapão
Email: napapapao@gmail.com

COPYRIGHT ©2016 RESTAURANTE DO NAPA. Todos os direitos reservados
******************************************************/

//validar e-mail
function isValidEmail(val) {
	var re = /^[\w\+\'\.-]+@[\w\'\.-]+\.[a-zA-Z]{2,}$/;
	if (!re.test(val)) {
		return false;
	}
    return true;
}

//função para lidar com a validação do formulário de login (login-form.php)
function validarLogin(loginForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (loginForm.usuario.value=="")
	{
		mensagemErro+="Nome de usuário não preenchido!\n";
		verificarValidacao=false;
	}
	if(loginForm.senha.value=="")
	{
		mensagemErro+="Senha não preenchida!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do formulário de alteração de senha (perfil.php)
function validarAlteracaoSenha(alterarSenhaForm) {
	var verificarValidacao=true;
	var mensagemErro="";

	if (alterarSenhaForm.senha.value=="")
	{
		mensagemErro+="Por favor, forneça sua senha atual.\n";
		verificarValidacao=false;
	}
	if (alterarSenhaForm.senhanova.value=="")
	{
		mensagemErro+="Por favor, forneça uma nova senha.\n";
		verificarValidacao=false;
	}
	if(alterarSenhaForm.senhanovaconfirm.value=="")
	{
		mensagemErro+="Por favor, confirme sua nova senha.\n";
		verificarValidacao=false;
	}
	if(alterarSenhaForm.senhanovaconfirm.value!=updateForm.senhanova.value)
	{
		mensagemErro+="Confirmação de Senha e a Nova Senha não correspondem!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do registroForm (clientes.php)
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


//validar form de mesas (reservas.php)
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

//validar form Salão de festas (reservas.php)
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

//validação no formulário de funcionários (perfil.php)
function validarFuncionarios(funcionariosForm) {
    var verificarValidacao=true;
	var mensagemErro="";

	if (funcionariosForm.nome.value=="")
	{
		mensagemErro+="Por favor, forneça o primeiro nome do funcionário.\n";
		verificarValidacao=false;
	}
	if (funcionariosForm.sobrenome.value=="")
	{
		mensagemErro+="Por favor, forneça o sobrenome do funcionário.\n";
		verificarValidacao=false;
	}
	if (funcionariosForm.endereco.value=="")
	{
		mensagemErro+="Por favor, forneça o endereço do funcionário.\n";
		verificarValidacao=false;
	}
	if(funcionariosForm.celular.value=="")
	{
		mensagemErro+="Por favor, forneça o telefone/celular do funcionário.\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do formulário de promoção (promocoes.php)
function validarPromocoes(promocoesForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if(promocoesForm.promocao_nome.value=="")
	{
		mensagemErro+="Nome não preenchido!\n";
		verificarValidacao=false;
	}
	if(promocoesForm.promocao_descricao.value=="")
	{
		mensagemErro+="Descrição não preenchida!\n";
		verificarValidacao=false;
	}
	if(promocoesForm.promocao_preco.value=="")
	{
		mensagemErro+="Preço não preenchido!\n";
		verificarValidacao=false;
	}
	if(promocoesForm.promocao_data_inicio.value=="")
	{
		mensagemErro+="Data de início não preenchida!\n";
		verificarValidacao=false;
	}
	if(promocoesForm.promocao_data_fim.value=="")
	{
		mensagemErro+="Data final não preenchida!\n";
		verificarValidacao=false;
	}
	if(promocoesForm.promocao_foto.value=="")
	{
		mensagemErro+="Foto não selecionada!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com validação do formulário de comidas (comidas.php)
function validarComidas(comidasForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if(comidasForm.comida_nome.value=="")
	{
		mensagemErro+="Nome do alimento não preenchido!\n";
		verificarValidacao=false;
	}
	if(comidasForm.comida_preco.value=="")
	{
		mensagemErro+="Preço do alimento não foi preenchido!\n";
		verificarValidacao=false;
	}
	if(comidasForm.id_categoria.selectedIndex==0)
	{
		mensagemErro+="Por favor selecione uma categoria de alimentos!\n";
		verificarValidacao=false;
	}
	if(comidasForm.comida_foto.value=="")
	{
		mensagemErro+="Foto da comida não foi selecionada!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com validação do formulário de categorias (categorias.php) (opcoes.php)
function validarCategorias(categoriasForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (categoriasForm.nome.value=="")
	{
		mensagemErro+="Nome da categoria não foi preenchida!\n";
		verificarValidacao=false;
	}
	if (categoriasForm.id_categoria.selectedIndex==0)
	{
		mensagemErro+="Por favor, selecione uma categoria para remover.\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do formulário de quantidades (opcoes.php)
function validarQuantidade(quantidadeForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (quantidadeForm.nome.value=="")
	{
		mensagemErro+="Valor de quantidade não foi preenchido!\n";
		verificarValidacao=false;
	}
	if (quantidadeForm.quantidade.selectedIndex==0)
	{
		mensagemErro+="Selecione um valor de quantidade para remover.\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do formulário de moeda (opcoes.php)
function validarMoedas(moedaForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (moedaForm.moeda_simbolo.value=="")
	{
		mensagemErro+="Moeda/Símbolo não preenchido!\n";
		verificarValidacao=false;
	}
	if (moedaForm.id_moeda.selectedIndex==0)
	{
		mensagemErro+="Não existe qualquer moeda selecionada!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do formulário de avaliação (opcoes.php)
function validarClassificacoes(classificacaoForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (classificacaoForm.classificacao_nome.value=="")
	{
		mensagemErro+="Nível da avaliação não preenchido!\n";
		verificarValidacao=false;
	}
	if (classificacaoForm.id_classificacao.selectedIndex==0)
	{
		mensagemErro+="Nível da avaliação não preenchido!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do formulário de fusos horários (opcoes.php)
function validarFusoHorario(fusohorarioForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (fusohorarioForm.fuso_horario_referencia.value=="")
	{
		mensagemErro+="Fuso horário não preenchido!\n";
		verificarValidacao=false;
	}
	if (fusohorarioForm.id_fuso_horario.selectedIndex==0)
	{
		mensagemErro+="Fuso horário não selecionado!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do formulário de mesas (opcoes.php)
function validarMesas(mesasForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (mesasForm.mesa_nome.value=="")
	{
		mensagemErro+="Nome/Número da mesa não preenchido!\n";
		verificarValidacao=false;
	}
	if (mesasForm.id_mesa.selectedIndex==0)
	{
		mensagemErro+="Mesa não selecionada!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do formulário de salões de festas (opcoes.php)
function validarSaloesFesta(saloesFestaForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (saloesFestaForm.salao_festas_nome.value=="")
	{
		mensagemErro+="Nome/Número do salão de festas não preenchido!\n";
		verificarValidacao=false;
	}
	if (saloesFestaForm.id_salao_festas.selectedIndex==0)
	{
		mensagemErro+="Salão de festas não selecionado!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do formulário de perguntas (opcoes.php)
function validarPerguntas(perguntaForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (perguntaForm.pergunta.value=="")
	{
		mensagemErro+="Pergunta não preenchida!\n";
		verificarValidacao=false;
	}
	if (perguntaForm.id_pergunta.selectedIndex==0)
	{
		mensagemErro+="Pergunta não selecionada!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do pagtoForm (opcoes.php)
function validarFormasPagto(pagtoForm){
	var verificarValidacao=true;
	var mensagemErro="";
	
	if (pagtoForm.name.value=="")
	{
		mensagemErro+="Forma de pagamento não preenchida!\n";
		verificarValidacao=false;
	}
	if(pagtoForm.formaPagto.selectedIndex==0)
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

//função para lidar com a validação do formulário de status da comida (index.php)
function validarAvaliacaoComida(comidaAvaliacaoForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (comidaAvaliacaoForm.id_comida.selectedIndex==0)
	{
		mensagemErro+="Alimento não selecionado!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do formulário de alocação de encomendas (funcionarios-alocacao.php)
function validarAlocacaoPedidos(alocacaoPedidosForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (alocacaoPedidosForm.id_pedido.selectedIndex==0)
	{
		mensagemErro+="Código da encomenda não selecionado!\n";
		verificarValidacao=false;
	}
	if(alocacaoPedidosForm.id_funcionario.selectedIndex==0)
	{
		mensagemErro+="Código do funcionário não selecionado!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com a validação do formulário de alocção de reservas (funcionarios-alocacao.php)
function validarAlocacaoReservas(alocacaoReservasForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (alocacaoReservasForm.id_reservas.selectedIndex==0)
	{
		mensagemErro+="Código da reserva não selecionado!\n";
		verificarValidacao=false;
	}
	if(alocacaoReservasForm.id_funcionario.selectedIndex==0)
	{
		mensagemErro+="Código do funcionário não selecionado!\n";
		verificarValidacao=false;
	}
	if(!verificarValidacao)
	{
		alert(mensagemErro);
	}
	return verificarValidacao;
}

//função para lidar com mensagem de validação (mensagem.php)
function validarMensagem(mensagemForm){
	var verificarValidacao=true;
	var mensagemErro="";

	if (mensagemForm.mensagem_assunto.value=="")
	{
		mensagemErro+="Assunto não preenchido!\n";
		verificarValidacao=false;
	}
	if (mensagemForm.mensagem_texto.value=="")
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
