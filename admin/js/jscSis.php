<!-- ARQUIVOS -->
<script type="text/javascript" src="js/jquery.js" /></script>
<script type="text/javascript" src="js/mascara.js"></script>
 
<!-- FUNÇÕES -->
<script type="text/javascript">

jQuery(function($){
   $(".formDate").mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
   $(".formTime").mask("99:99:99",{placeholder:"hh:mi:ss"});
   $(".formDateTime").mask("99/99/9999 99:99:99",{placeholder:"dd/mm/aaaa hh:mi:ss"});
   $(".formFone").mask("(99) 9999.9999");
   $(".formCel").mask("(99) 9999.9999?9");
   $(".formCep").mask("99.999-999");
   $(".formCpf").mask("999.999.999-99");
   $(".formMeses").mask("??99");
   //$(".formValor").mask("????9999,99");
});

</script>