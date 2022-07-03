<?php 
require('../controller/VerificaLogado.php');
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div id="ModalData" class="modal fade" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informe a nova data.</h5>
                </div>
                <div class="modal-body">
                    <input class="form-control" type="text" placeholder="Observações" id="obsdata">
                    <input class="form-control mt-2" id="dateReagenda" name="date" placeholder="MM/DD/YYYY" type="date"
                        autocomplete="off" />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default FechaModal" data-dismiss="modal">Sair</button>
                        <button type="button" class="btn btn-primary confirmamodal">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalOBS" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deseja incluir observação ?</h5>
                </div>
                <div class="modal-body">
                    <input class="form-control" placeholder="Observações" type="text" id="obs">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default FechaModal" data-dismiss="modal">Sair</button>
                    <button type="button" class="btn btn-primary confirmamodal">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="input-group w-50">
                    <input class="form-control" id="data" placeholder="MM/DD/YYYY" type="date"
                        autocomplete="off" />
                    <button type="button" class="btn btn-success" id="Consultar">Consultar</button>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-sm border border-secondary table-hover mt-2">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fonecedor</th>
                    <th>Nota/Pedido</th>
                    <th>Volume</th>
                    <th>QTD Paletes</th>
                    <th>Tipo</th>
                    <th>Categoria</th>
                    <th>Produto</th>
                    <th>Agendamento</th>
                    <th colspan="3">Status</th>
                </tr>
            </thead>
            <tbody id="itens">

            </tbody>
        </table>
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
                            td += '<td id="botaoA' + dado[item].id + '"><div ><button type="button"  name="A" id="' + dado[item].id + '" onclick="AlteraItem(this.name,this.id)" class="btn-success btn-sm text-white">Atendido</button></div></td>';
                            td += '<td id="botaoR' + dado[item].id + '"><div><button type="button" name="R" id="' + dado[item].id + '" onclick="ExibeModal(this.name,this.id)" class="btn-warning btn-sm text-white">Reagendar</button></div></td>';
                            td += '<td id="botaoN' + dado[item].id + '"><div><button type="button" name="N" id="' + dado[item].id + '" onclick="ExibeModal(this.name,this.id)" class="btn-danger btn-sm text-white">Não atendido</button></div></td>';
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
    dataatual = $('#data').val();
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
            Consulta($('#data').val());
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