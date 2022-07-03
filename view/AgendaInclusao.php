<?php 
require('../controller/VerificaLogado.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/css/datepicker.css">
    <script type="text/javascript" src="view/js/datepicker.js"></script>
    <script type="text/javascript" src="view/js/bootstrap-datepicker.pt-BR.min.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="container-fluid ">
            <div class="row border b-2 align-items-center m-2 p-1">
                <div class="col-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">Fornecedor</span>
                        <input type="email" class="form-control" id="Fornecedor" >
                    </div>
                </div> 
                <div class="col-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">Produto</span>
                        <input type="text" class="form-control" id="Produto">
                    </div>
                </div> 
                <div class="col-4 mb-3">
                     <div class="input-group">
                        <span class="input-group-text">Nota/Pedido</span>
                        <input type="number" class="form-control" id="Nota" >
                    </div>
                </div> 
                <div class="col-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">Nº de Volumes</span>
                        <input type="number" class="form-control" id="Volume" >
                    </div>
                </div> 
                <div class="col-3 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">Nº de Paletes</span>
                        <input type="number" class="form-control" id="Paletes">
                    </div>
                </div> 
                <div class="col-2 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">TIPO</span>
                        <select class="form-select" id="tipo">

                        </select>
                    </div>
                </div>
                <div class="col-3 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">Categoria</span>
                        <select class="form-select" id="categoria">

                        </select>
                    </div>
                </div> 
                <div class="col-3 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">Data</span>
                        <input class="form-control" id="date" placeholder="MM/DD/YYYY" type="date" autocomplete="off" />
                    </div>
                </div>
               
            </div>
            <div class="d-flex flex-row-reverse bd-highlight mb-3">
                <button type="button" id="Salvar" class="btn btn-success m-2 p-2 ">Salvar (F4)</button>
            </div>
            
    </div>
</body>
</html>

<script>
    $(document).ready(function () {
        Consulta();
	});
	$("body").keydown(function (event) {
		if (event.which == 115) { //F4
			Salvar();
			return false;
		}
	});
    function Consulta(){
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../controller/ConfiguracoesAgenda.php',
            data: {metodo:'consulta',menu:'agenda'},
            cache: false,
            success: function (dado) {
                OptionCateg = '';
                OptionTipo = '';
                Object.keys(dado.categoria).forEach( item => {
                    OptionCateg += `<option id=`+dado.categoria[item].id+` name=`+dado.categoria[item].	descricao+`>` +dado.categoria[item].	descricao+`</option>`;
                    
                });
                Object.keys(dado.tipo).forEach( item => {
                    OptionTipo += `<option id=`+dado.tipo[item].id+` name=`+dado.tipo[item].tipo+`>` +dado.tipo[item].tipo+`</option>`;
                });
                $('#categoria').html(OptionCateg.replace(/\"/g, ""));
                $('#tipo').html(OptionTipo.replace(/\"/g, ""));
            }
        });
    }
    $('#Salvar').click(function () {
        Salvar();
	});
    function Salvar(){
        tipo = $("#tipo option:selected").html();
        categ = $("#categoria option:selected").html();
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '../controller/AgendaInclusao.php',
			data: {fonecedor:$('#Fornecedor').val(),nota:$('#Nota').val(),volume:$('#Volume').val(),palete:$('#Paletes').val(),produto:$('#Produto').val(),tipo:tipo,categoria:categ,data:$('#date').val()},
			cache: false,
			success: function (dado) {
				alert(dado);
			}
		});
    }
</script>