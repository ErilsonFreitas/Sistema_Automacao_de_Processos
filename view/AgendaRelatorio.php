<?php 
require('../controller/VerificaLogado.php');
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="view/js/datepicker.js"></script>
    <script type="text/javascript" src="view/js/bootstrap-datepicker.pt-BR.min.js"></script>
    <link rel="stylesheet" href="view/css/datepicker.css">
    
    <title>Document</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="input-daterange input-group w-50 ">
                    <input type="date" name="start" class="form-control" placeholder="MM/DD/YYYY" value="" autocomplete="off">
                    <div class="input-group-addon"> Até </div>
                    <input type="date" name="end" class="form-control" placeholder="MM/DD/YYYY" value="" autocomplete="off">
                    <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span></span>
                    <button type="button" class="btn btn-success" id="Consultar">Consultar</button>
                </div>
            </div>
        </div>
        <div class="mt-3 border border-2 p-2">
            <span class="fs-6 fw-bolder">Quebrar Por:</span>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="RadioData" checked>
                <label class="form-check-label" for="RadioData">
                  Data
                </label>
              </div>
              <div class="form-check mt-2">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="RadioStatus">
                <label class="form-check-label" for="RadioStatus">
                  Status
                </label>
              </div>
              <div class="form-check mt-2">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="RadioTipo">
                <label class="form-check-label" for="RadioTipo">
                  Tipo
                </label>
              </div>
              <div class="form-check mt-2">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="RadioCategoria">
                <label class="form-check-label" for="RadioCategoria">
                  Categoria
                </label>
              </div>
        </div>

    </div>

</body>

</html>
<script>
    
xid = '';
yalt = '';
dataatual = '';
$(document).ready(function () {
    myModal = new bootstrap.Modal($("#ModalData"), {
        keyboard: false
    });
    ModalOBS = new bootstrap.Modal($("#ModalOBS"), {
        keyboard: false
    });

});

function Consulta(data) {
    if(data !== ''){
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../controller/AgendaConsulta.php',
            data: { data: data },
            cache: false,
            success: function (dado) {
                $('#itens').html("");
                if(dado.length == 0){
                    alert("Não exitem agendamentos para esta data.");
                }else{
                    td = '';
                    Object.keys(dado).forEach(item => {
                        td += '<tr ">';
                        td += '<td >"' + dado[item].id + '"</td>';
                        td += '<td >"' + dado[item].fornecedor + '"</td>';
                        td += '<td >"' + dado[item].notaped + '"</td>';
                        td += '<td >"' + dado[item].volume + '"</td>';
                        td += '<td >"' + dado[item].qtdpalete + '"</td>';
                        td += '<td >"' + dado[item].TIPO + '"</td>';
                        td += '<td >"' + dado[item].categoria + '"</td>';
                        td += '<td >"' + dado[item].produto + '"</td>';
                        td += '<td >"' + dado[item].agendamento + '"</td>';
                        if (dado[item].status != '') {
                            if (dado[item].status == 'A') {
                                status = 'Atendido';
                                fclass = "text-success";
                            } else if (dado[item].status == 'R') {
                                status = 'Reagendado';
                                fclass = "text-warning";
                            } else if (dado[item].status == 'N') {
                                status = 'Não Atendido';
                                fclass = "text-danger";
                            }
                            td += '<td id="botao' + dado[item].id + '" class="fw-bold"><p class="'+fclass+'">"'+ status +'"</p></td>';
                        } else {
                            td += '<td id="botao' + dado[item].id + '"><button type="button"  name="A" id="' + dado[item].id + '" onclick="AlteraItem(this.name,this.id)" class="btn-success btn-sm text-white m-1">Atendido</button><button type="button" name="R" id="' + dado[item].id + '" onclick="ExibeModal(this.name,this.id)" class="btn-warning btn-sm text-white m-1" >Reagendar</button><button type="button" name="N" id="' + dado[item].id + '" onclick="ExibeModal(this.name,this.id)" class="btn-danger btn-sm text-white m-1">Não atendido</button></td>';
                        }
        
                        td += '</tr>';
                    });
                    $('#itens').html(td.replace(/\"/g, ""));
                }
            }
        });
    }else{
        alert("Selecione uma data.");
    }

}
$('#Consultar').click(() => {
    dataatual = $('#date').val();
    Consulta(dataatual);
});
$('.FechaModal').click(() => {
    myModal.hide();
    ModalOBS.hide();
});
function AlteraItem(x, y) {
    if(x == 'R'){
        obs = $("#obsdata").val();
        novadata = $("#dateReagenda").val();
    }else if(x == 'N'){
        obs = $("#obs").val();
        novadata = '';
    }else{
        obs = '';
        novadata = '';
    }
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '../controller/AgendaAlteracao.php',
        data: { alt: x, id: y,nova:novadata, obs1:obs},
        cache: false,
        success: function (dado) {
            if(dado.err != 's'){
                alert(dado.msg);
                $('#botao' + y).html("<span class="+dado.classe+">"+dado.status+"</span>");
            }else{
                alert(dado.errmsg);
            }
            Consulta($('#date').val());
            myModal.hide();
            ModalOBS.hide();

        }
    });
}
function ExibeModal(x, y) {
    xid = x;
    yalt = y;
    if(xid == "R"){
        myModal.show();
    }else if(xid == "N"){
        ModalOBS.show();
    }
    
}
$('.confirmamodal').click(function () {
    AlteraItem(xid, yalt);
});
$('#Secoes').change(() => {
    $("#Layout option[id='00']").attr('value');
    ListaItensSecao();
});

</script>