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
        <div class="mb-1 border border-1 p-2" id="campos">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Data</span>
                        <input type="date" class="form-control" id="Data" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Loja</span>
                        <input type="text" class="form-control" id="Loja" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Endereço</span>
                        <input type="text" class="form-control" id="Endereco" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Placa</span>
                        <input type="text" class="form-control" id="Placa" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Chegada</span>
                        <input type="time" class="form-control" id="Chegada" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">Saída</span>
                        <input type="time" class="form-control" id="Saida" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                    </div>
                </div>
            </div>

        </div>
        <div class="d-grid gap-2 d-md-block mb-2">
            <button class="btn btn-primary" type="submit" id="Salvar">Salvar</button>
        </div>
        <div style="overflow-x: auto;overflow-y: auto;white-space: nowrap;">
            <table class="table table-bordered table-sm border table-hover" id="tableItens">
                <thead class="bg-secondary">
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th>Loja</th>
                        <th>Endereço</th>
                        <th>Placa</th>
                        <th>Chegada</th>
                        <th>Saída</th>
                    </tr>
                </thead>
                <tbody id="itens">

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<script>
    $('#campos').keypress(function(e) {
        if (event.which == 13) {
            var generico = $("#campos").find('input:visible');
            var indice = generico.index(event.target) + 1;
            var seletor = $(generico[indice]).focus();

            if (indice == 6) {
                Salvar()
            }

        }
    })

    function zeraCampos() {
        $('#Produto').val('');
        $('#Custo').val('');
        $('#Venda').val('');
        $('#Margem').val('');
        $('#Verba').val('');

    }

    function addItemLista(arrayDados = {}) {
        Object.keys(arrayDados).forEach(item => {
            id = arrayDados[item].id;
            var tbodyRef = document.getElementById('tableItens').getElementsByTagName('tbody')[0];
            var newRow = tbodyRef.insertRow();

            var cellId = newRow.insertCell();
            var cellData = newRow.insertCell();
            var cellLoja = newRow.insertCell();
            var cellEndereco = newRow.insertCell();
            var cellPlaca = newRow.insertCell();
            var cellChegada = newRow.insertCell();
            var cellSaida = newRow.insertCell();

            var inputId = document.createElement('span');
            inputId.id = 'id' + id;
            inputId.innerHTML = arrayDados[item].id || '';

            var inputData = document.createElement('span');
            inputData.id = 'Data' + id;
            inputData.innerHTML = arrayDados[item].data_inclusao || '';

            var inputLoja = document.createElement('span');
            inputLoja.id = 'Loja' + id;
            inputLoja.innerHTML = arrayDados[item].loja || '';
                        var inputEndereco = document.createElement('span');
            inputEndereco.id = 'End' + id;
            inputEndereco.innerHTML = arrayDados[item].endereco || '';

            var inputPlaca = document.createElement('span');
            inputPlaca.id = 'Placa' + id;
            inputPlaca.innerHTML = arrayDados[item].placa || '';
            
            var inputChegada = document.createElement('span');
            inputChegada.id = 'Chegada' + id;
            inputChegada.innerHTML = arrayDados[item].chegada || '';

            var inputSaida = document.createElement('input');
            inputSaida.type = 'time';
            inputSaida.id = 'Saida' + id;
            inputSaida.name = 'Saida';
            inputSaida.value = arrayDados[item].saida || '';
            
            cellId.appendChild(inputId);
            cellData.appendChild(inputData);
            cellLoja.appendChild(inputLoja);
            cellEndereco.appendChild(inputEndereco);
            cellPlaca.appendChild(inputPlaca);
            cellChegada.appendChild(inputChegada);
            cellSaida.appendChild(inputSaida);
        });

    };

    function Salvar() {
        if ($('#Data').val() == '' || $('#Loja').val() == '') {
            alert("Existem Campos não preenchidos.")
        } else {
            var ItensParaSalvar = {}
            $('#campos input').each(function(index) {
                ItensParaSalvar[this.id] = this.value
            })
            ItensParaSalvar["usuario"] = $('#Usuario').html()
            ItensParaSalvar["m"] = "i"
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../controller/PortariaInclusao.php',
                data: {
                    json: JSON.stringify(ItensParaSalvar)
                },
                cache: false,
                success: function(dado) {
                    console.log(dado)
                    addItemLista(dado)
                }
            })
        }
    }
    $('#Salvar').click(Salvar)
</script>