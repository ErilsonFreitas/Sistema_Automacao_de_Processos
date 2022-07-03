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
    <script src="js/jquery.maskMoney.js" type="text/javascript"></script>
    <script src="js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="js/papaparse.min.js" type="text/javascript"></script>



</head>

<body>
    <div class="container-fluid ">
        <div class="row border b-2 align-items-center m-2 p-2 " id="validacao1">

            <div class="col-sm-2">
                <div class="input-group">
                    <span class="input-group-text">Início</span>
                    <input class="form-control" id="dataini" placeholder="MM-DD-YYYY" type="date" autocomplete="off" required />
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group">
                    <span class="input-group-text">Fim</span>
                    <input class="form-control" id="datafim" placeholder="MM-DD-YYYY" type="date" autocomplete="off" required />
                </div>
            </div>
        </div>
        <div id="entradas" class="mt-2 p-2">
            <div class="card mt-2">
                <a href="#collapseBodyImportar" class="card-header collapse-indicator-plus fw-bolder" id="ImportarcaoArq" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapseIndicatorPlus">
                    Importar Arquivo
                </a>

                <div id="collapseBodyImportar" class="collapse" aria-labelledby="ImportarcaoArq" data-bs-parent="#entradas">
                    <div class="card-body">
                        <div class="input-group w-50">
                            <input type="file" class="form-control" id="ArquivoInput">
                            <button type="submit" class="btn btn-primary btn-sm" id="btnImportar">Importar Arquivo</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="d-flex align-items-end flex-row-reverse m-2">
            <button type="button" class="btn btn-primary btn-group-sm" id="AdicionarItem">Novo Item<img src="icon/add_item.svg" width="20" height="20"></button>
        </div>
        <div class="p-2" style="overflow-x: auto;overflow-y: auto;white-space: nowrap;">
            <table class="table table-bordered table-sm border table-hover" id="tableItens">
                <thead class="bg-secondary">
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Encarte</th>
                        <th>Categoria</th>
                        <th>Fornecedor</th>
                        <th>Cnpj</th>
                        <th>Produto</th>
                        <th>Custo</th>
                        <th>Venda</th>
                        <th>Margem %</th>
                        <th>Verba</th>
                        <th>Dados Do Vendedor</th>
                        <th>Validade da Proposta</th>
                        <th>Observações</th>
                    </tr>
                </thead>
                <tbody id="itens">

                </tbody>
            </table>
        </div>

        <div class="d-flex align-items-end flex-row-reverse m-2">
            <button type="button" class="btn btn-success btn-group-sm" id="Salvar">Salvar (F4)</button>
        </div>
    </div>
</body>

</html>

<script>
    itensTabela = {};
    id = 0;

    function PulaInput() {
        $('#itens').keypress(function(e) {
            if (event.which == 13) {
                var generico = $("#itens").find('input:visible');
                var indice = generico.index(event.target) + 1;
                var seletor = $(generico[indice]).focus();
                if (seletor.length == 0) {
                    addItemLista()
                }

            }
        })
    }
    $("#btnImportar").click(function() {
        var csv = $('#ArquivoInput').prop('files')[0];
        Papa.parse(csv, {
            complete: function(results) {
                itensIport = {}
                Object.keys(results.data).forEach(item => {
                    if (item > 0) {
                        let data = results.data[item][0];
                        itensIport['data'] = data.substr(0, 10)
                        itensIport['encarte'] = results.data[item][2]
                        itensIport['categoria'] = results.data[item][3]
                        itensIport['cnpj'] = results.data[item][4]
                        itensIport['nomeFornecedor'] = results.data[item][5]
                        itensIport['dadosVendedor'] = results.data[item][6]
                        itensIport['ean'] = results.data[item][7]
                        itensIport['nomeItem'] = results.data[item][8]
                        itensIport['custoItem'] = results.data[item][9]
                        itensIport['sugestaoVda'] = results.data[item][10]
                        itensIport['validadeProposta'] = results.data[item][12]
                        itensIport['observacao'] = results.data[item][13]
                        itensIport['Venda'] = 0
                        itensIport['Margem'] = 0
                        itensIport['Verba'] = 0
                        addItemLista(itensIport)
                    }


                });
                $('.Mascara').maskMoney();
            }
        });
        PulaInput()
    })
    $(document).ready(function() {

        Consulta();
        $("#btnAdicionar").click(function() {
            var form = $("#addItens");

            if (form[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.addClass('was-validated');
        })
    });

    function zeraCampos() {
        $('#Produto').val('');
        $('#Custo').val('');
        $('#Venda').val('');
        $('#Margem').val('');
        $('#Verba').val('');

    }

    $("form").on('submit', function(e) {
        e.preventDefault();
        addItemLista;
    });

    $('#AdicionarItem').click(() => {
        addItemLista()
        PulaInput()
    })

    function CalculaMargem(x) {
        var prodcusto = $("input[idUnico=Custo" + x.id + "]").val();
        var prodvenda = $("input[idUnico=Venda" + x.id + "]").val();
        var prodmargem = ((prodvenda - prodcusto) / prodcusto) * 100;
        $("input[idUnico=Margem" + x.id + "]").val(prodmargem.toFixed(2));
    }

    function addItemLista(arrayDados = {}) {
        id++;
        var tbodyRef = document.getElementById('tableItens').getElementsByTagName('tbody')[0];
        var newRow = tbodyRef.insertRow();
        var cellExcluir = newRow.insertCell();
        var cellId = newRow.insertCell();
        var cellEncarte = newRow.insertCell();
        var cellCateoria = newRow.insertCell();
        var cellForne = newRow.insertCell();
        var cellCnpj = newRow.insertCell();
        var cellNomeProd = newRow.insertCell();
        var cellCusto = newRow.insertCell();
        var cellVenda = newRow.insertCell();
        var cellMargem = newRow.insertCell();
        var cellVerba = newRow.insertCell();
        var cellVendedor = newRow.insertCell();
        var cellValidade = newRow.insertCell();
        var cellObservacao = newRow.insertCell();
        itensTabela[id] = arrayDados

        var inputEncarte = document.createElement('input');
        inputEncarte.type = 'text';
        inputEncarte.id = id;
        inputEncarte.name = 'Encarte';
        inputEncarte.setAttribute("idUnico", 'Encarte' + id);
        inputEncarte.value = arrayDados['encarte'] || '';

        var inputCateg = document.createElement('input');
        inputCateg.type = 'text';
        inputCateg.id = id;
        inputCateg.name = 'Categoria';
        inputCateg.setAttribute("idUnico", 'Categoria' + id);
        inputCateg.value = arrayDados['categoria'] || '';

        var inputFornec = document.createElement('input');
        inputFornec.type = 'text';
        inputFornec.id = id;
        inputFornec.name = 'Fornecedor';
        inputFornec.setAttribute("idUnico", 'Fornecedor' + id);
        inputFornec.value = arrayDados['nomeFornecedor'] || '';

        var inputCnpj = document.createElement('input');
        inputCnpj.type = 'text';
        inputCnpj.id = id;
        inputCnpj.name = 'cnpj';
        inputCnpj.setAttribute("idUnico", 'cnpj' + id);
        inputCnpj.value = arrayDados['cnpj'] || '';

        var InputVendedor = document.createElement('input');
        InputVendedor.type = 'text';
        InputVendedor.id = id;
        InputVendedor.name = 'Vendedor';
        InputVendedor.setAttribute("idUnico", 'Vendedor' + id);
        InputVendedor.value = arrayDados['dadosVendedor'] || '';

        var InputProposta = document.createElement('input');
        InputProposta.type = 'date';
        InputProposta.id = id;
        InputProposta.name = 'Proposta';
        InputProposta.setAttribute("idUnico", 'Proposta' + id);
        InputProposta.value = arrayDados['validadeProposta'] || '';

        var InputObs = document.createElement('input');
        InputObs.type = 'text';
        InputObs.id = id;
        InputObs.name = 'obs';
        InputObs.setAttribute("idUnico", 'obs' + id);
        InputObs.setAttribute('IndexFim', 'fim');
        InputObs.value = arrayDados['observacao'] || '';

        var inputVenda = document.createElement('input');
        inputVenda.type = 'text';
        inputVenda.value = (arrayDados['Venda'] || '0').toString().replace(",", ".");
        inputVenda.id = id;
        inputVenda.name = 'Venda';
        inputVenda.setAttribute("idUnico", 'Venda' + id);
        inputVenda.classList.add('Mascara');
        inputVenda.onblur = function() {
            CalculaMargem(this)
        };

        var inputCusto = document.createElement('input');
        inputCusto.type = 'text';
        inputCusto.value = (arrayDados['custoItem'] || '0').toString().replace(",", ".");
        inputCusto.name = 'Custo';
        inputCusto.id = id;
        inputCusto.setAttribute("idUnico", 'Custo' + id);
        inputCusto.classList.add('Mascara');
        inputCusto.onblur = function() {
            CalculaMargem(this)
        };

        var inputItem = document.createElement('input');
        inputItem.type = 'text';
        inputItem.id = id;
        inputItem.name = 'Item';
        inputItem.setAttribute("idUnico", 'Item' + id);
        inputItem.value = arrayDados['nomeItem'] || '';

        var inputVerba = document.createElement('input');
        inputVerba.type = 'text';
        inputVerba.id = id;
        inputVerba.name = 'Verba';
        inputVerba.setAttribute("idUnico", 'Verba' + id);
        inputVerba.value = (arrayDados['Verba'] || '0').toString().replace(",", ".");
        inputVerba.classList.add('Mascara');

        var inputMargem = document.createElement('input');
        inputMargem.id = id;
        inputMargem.name = 'Margem';
        inputMargem.setAttribute("idUnico", 'Margem' + id);
        inputMargem.readOnly = true;
        inputMargem.value = arrayDados['Margem'] || 0;

        var btnExcluir = document.createElement('button');
        btnExcluir.onclick = function() {
            var row = btnExcluir.parentNode.parentNode;
            row.parentNode.removeChild(row);
        };
        btnExcluir.innerHTML = "X";
        btnExcluir.classList.add('bg-danger');
        btnExcluir.classList.add('text-white');

        var inputId = document.createTextNode(id);

        cellEncarte.appendChild(inputEncarte);
        cellCateoria.appendChild(inputCateg);
        cellForne.appendChild(inputFornec);
        cellCnpj.appendChild(inputCnpj);
        cellVendedor.appendChild(InputVendedor);
        cellValidade.appendChild(InputProposta);
        cellObservacao.appendChild(InputObs);
        cellExcluir.appendChild(btnExcluir);
        cellId.appendChild(inputId);
        cellNomeProd.appendChild(inputItem);
        cellCusto.appendChild(inputCusto);
        cellVenda.appendChild(inputVenda);
        cellMargem.appendChild(inputMargem);
        cellVerba.appendChild(inputVerba);
        $('#Encarte' + id).focus();

    };

    function Consulta() {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../controller/ConfiguracoesAgenda.php',
            data: {
                metodo: 'consulta',
                menu: 'encartes'
            },
            cache: false,
            success: function(dado) {
                OptionCateg = '<option value="0">Selecione...</option>';

                Object.keys(dado.categoria).forEach(item => {
                    OptionCateg += `<option id=` + dado.categoria[item].id + ` name=` + dado.categoria[item].descricao + `>` + dado.categoria[item].descricao + `</option>`;

                });
                $('#encarte').html(OptionCateg.replace(/\"/g, ""));
            }
        });
    }

    $('#Salvar').click(() => {
        if ($('#dataini').val() == '' || $('#datafim').val() == '') {
            alert("Período do Encarte não Informado.")
        } else {
            var ItensParaSalvar = []
            $('#itens input').each(function(index) {
                if (ItensParaSalvar[this.id]) {
                    ItensParaSalvar[this.id][this.name] = this.value
                } else {
                    ItensParaSalvar[this.id] = {
                        'dataini': $('#dataini').val(),
                        'datafim': $('#datafim').val(),
                        'Encarte': this.value
                    }
                }
            })
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../controller/EncarteInclusao.php',
                data: {
                    json: JSON.stringify(ItensParaSalvar)
                },
                cache: false,
                success: function(dado) {
                    if (dado.status == 's') {
                        alert(dado.msg);
                        $("#itens").html('')
                    } else {
                        alert(dado.msg);
                    }
                }
            })
        }

    })
</script>