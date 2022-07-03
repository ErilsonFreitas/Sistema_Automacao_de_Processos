<?php
require('../controller/VerificaLogado.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="js/xlsx.full.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="container-fluid ">

        <div class="row">
            <div class="col">
                <div class="input-group w-50">
                    <input class="form-control" id="data" type="date" autocomplete="off" />
                    <button type="button" class="btn btn-success" id="Consultar">Consultar</button>
                </div>
            </div>
        </div>
        <div class="" style="overflow-x: auto;overflow-y: auto;white-space: nowrap;">
            <table class="table table-bordered table-sm border border-secondary table-success table-striped table-hover mt-2 vh-50" id="SendGrafica">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th colspan="2">status</th>
                        <th>Produto</th>
                        <th>Custo</th>
                        <th>Venda</th>
                        <th>Margem</th>
                        <th>Fornecedor</th>
                        <th>CNPJ</th>
                        <th>Encarte</th>
                        <th>Categoria</th>
                        <th>Inicio</th>
                        <th>Fim</th>
                        <th>Verba</th>

                    </tr>
                </thead>
                <tbody id="itens">

                </tbody>
            </table>
        </div>

    </div>
    <div class="d-flex flex-row-reverse bd-highlight mb-3">
        <button onclick="ExportToExcel('xlsx')" type="button" class="btn btn-success m-2 p-2 ">Envia P/Gráfica</button>
    </div>

    </div>
</body>

</html>

<script>
    function compare(a, b) {
        const bandA = a.encarte.toUpperCase();
        const bandB = b.encarte.toUpperCase();

        let comparison = 0;
        if (bandA > bandB) {
            comparison = 1;
        } else if (bandA < bandB) {
            comparison = -1;
        }
        return comparison;
    }

    function ExportToExcel(type, fn, dl) {
        if ($("#data").val() == '') {
            alert("Data do encarte não informada.")
        } else {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: '../controller/EncarteSendGrafica.php',
                data: {
                    data: $("#data").val()
                },
                cache: false,
                success: function(dado) {
                    const rows = dado.map(row => ({
                        encarte: row.encarte,
                        produto: row.produto,
                        venda: row.venda,
                    }));
                    rows.sort(compare)
                    const planilha = XLSX.utils.book_new();
                    const json = XLSX.utils.json_to_sheet(rows, {
                        origin: "A2"
                    });
                    XLSX.utils.sheet_add_aoa(json, [
                        ["REDE PARCERIA"]
                    ], {
                        origin: "A1"
                    });

                    json["!merges"] = merge;
                    XLSX.utils.sheet_add_aoa(json, [
                        ["ENCARTE", "PRODUTO", "PREÇO DE VENDA"]
                    ], {
                        origin: "A2"
                    });
                    XLSX.utils.book_append_sheet(planilha, json, "Enviar para Gráfica");
                    XLSX.writeFile(planilha, "Encarte Aprovado.xlsx");
                }
            });
        }

    }

    function AlteraItem(x, y) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../controller/EncarteAlteracao.php',
            data: {
                alt: x,
                id: y
            },
            cache: false,
            success: function(dado) {
                if (dado.err != 's') {
                    dataatual = $('#data').val();
                    Consulta(dataatual);
                } else {
                    alert(dado.errmsg);
                }

            }
        });
    }

    function Consulta(data) {
        if (data !== '') {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../controller/EncarteConsulta.php',
                data: {
                    data: data
                },
                cache: false,
                success: function(dado) {
                    $('#itens').html("");
                    if (dado.length == 0) {
                        alert("Não exitem encartes incluidos nesta data.");
                    } else {
                        td = '';
                        Object.keys(dado).forEach(item => {
                            td += '<tr ">';
                            td += '<td >"' + dado[item].id + '"</td>';
                            if (dado[item].aprovado != 'P') {
                                if (dado[item].aprovado == 'A') {
                                    status = 'Aprovado';
                                    fclass = "text-success";
                                } else if (dado[item].aprovado == 'R') {
                                    status = 'Reprovado';
                                    fclass = "text-danger";
                                }
                                td += '<td id="botao' + dado[item].id + '" colspan="2"><span class="' + fclass + ' fw-bold">"' + status + '"</span></td>';
                            } else {
                                td += '<td id="botao' + dado[item].id + '"><div ><button type="button"  name="A" id="' + dado[item].id + '" onclick="AlteraItem(this.name,this.id)" class="btn-success btn-sm text-white m-2">Aprovar</button></div></td>';
                                td += '<td id="botao2' + dado[item].id + '"><div ><button type="button" name="R" id="' + dado[item].id + '" onclick="AlteraItem(this.name,this.id)" class="btn-danger btn-sm text-white m-2" >Reprovar</button></div></td>';
                            }
                            td += '<td >"' + dado[item].produto + '"</td>';
                            td += '<td >R$"' + dado[item].custo + '"</td>';
                            td += '<td ><input class="form-control" value="' + dado[item].venda + '" type="number" autocomplete="off"/></td>';
                            td += '<td >"' + dado[item].margem + '"%</td>';
                            td += '<td >"' + dado[item].nomefornecedor + '"</td>';
                            td += '<td >"' + dado[item].cnpjfornecedor + '"</td>';
                            td += '<td >"' + dado[item].encarte + '"</td>';
                            td += '<td >"' + dado[item].categoria + '"</td>';
                            td += '<td >"' + dado[item].inicio + '"</td>';
                            td += '<td >"' + dado[item].fim + '"</td>';
                            td += '<td >R$"' + dado[item].verba + '"</td>';


                            td += '</tr>';
                        });
                        $('#itens').html(td.replace(/\"/g, ""));
                    }
                }
            });
        } else {
            alert("Selecione uma data.");
        }

    }
    $('#Consultar').click(() => {
        dataatual = $('#data').val();
        Consulta(dataatual);
    });
</script>