<?php 
require('../controller/VerificaLogado.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col border p-2">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Tipo</span>
                    <input type="text" class="form-control text-uppercase" id="Tipo" aria-label="Tipo"
                        aria-describedby="basic-addon1">
                </div>
                <button type="button" id="SalvarTipo" class="btn btn-success">Adicionar Tipo</button>
                <ul class="list-group mt-5" id="itensTipo">
                      
                </ul>
            </div>
            <div class="col border p-2">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Categoria</span>
                    <input type="text" class="form-control text-uppercase" id="Categoria" aria-label="Categoria"
                        aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                        <label class="input-group-text" for="qualmenu">Menu</label>
                        <select class="form-select" id="qualmenu">
                            <option value="selecione">Selecione..</option>
                            <option value="agenda">Agenda</option>
                            <option value="Encartes">Encartes</option>
                        </select>
                </div>
                <button type="button" id="SalvarCateoria" class="btn btn-success">Adicionar Categoria</button>
                <ul class="list-group mt-5" id="itensCategoria">
                      
                </ul>
            </div>
            
        </div>
        
    </div>
</body>
</html>

<SCript>
    $(document).ready(function () {
        Consulta();
	});
    function Consulta(){
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../controller/ConfiguracoesAgenda.php',
            data: {metodo:'consulta',menu:'todos'},
            cache: false,
            success: function (dado) {
                console.log(dado);
                liCateg = '';
                liTipo = '';
                Object.keys(dado.categoria).forEach( item => {
                    liCateg += `<li class="list-group-item"><button class="btn-danger btn-sm text-white m-2" onclick="ExcluiItem(this.id,this.name)" type="button" name='categoria' id=` +dado.categoria[item].id+`>X</button><span class="ms-2">` +dado.categoria[item].descricao+ ` (Menu - `+dado.categoria[item].menu+`)</span></li>`;
                });
                Object.keys(dado.tipo).forEach( item => {
                    liTipo += `<li class="list-group-item"><button class="btn-danger btn-sm text-white m-2" onclick="ExcluiItem(this.id,this.name)" type="button" name='tipo' id=` +dado.tipo[item].id+`>X</button><span class="ms-2">` +dado.tipo[item].tipo+`</span></li>`;
                });
                $('#itensCategoria').html(liCateg.replace(/\"/g, ""));
                $('#itensTipo').html(liTipo.replace(/\"/g, ""));
            }
        });
    }
    $('#SalvarTipo').click(function () {
        tip = $('#Tipo').val();
        SalvarParametros('inclusao','tipo','',tip);
	});
    $('#SalvarCateoria').click(function () {
        categ = $('#Categoria').val();
        menu = $("#qualmenu option:selected").val();
        SalvarParametros('inclusao','categoria',menu,categ);
	});
    function SalvarParametros(metodo,modulo,menu = null,dados){
        $.ajax({
			type: 'POST',
			dataType: 'json',
			url: '../controller/ConfiguracoesAgenda.php',
			data: {metodo:metodo,modulo:modulo,menu:menu,dados:dados},
			cache: false,
			success: function (dado) {
				alert(dado);
                Consulta();
			}
		});
    }
    function ExcluiItem(id,name){
        $.ajax({
			type: 'POST',
			dataType: 'json',
			url: '../controller/ConfiguracoesAgenda.php',
			data: {metodo:'exclusao',modulo:name,id:id},
			cache: false,
			success: function (dado) {
				alert(dado);
                Consulta();
			}
		});
    }
</SCript>