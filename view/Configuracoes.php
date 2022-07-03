<?php 
require('../controller/VerificaLogado.php');
?>
<style>
		.bootstrap-iso .formden_header h2,
		.bootstrap-iso .formden_header p,
		.bootstrap-iso form {
			font-family: Arial, Helvetica, sans-serif;
			color: black
		}

		.bootstrap-iso form button,
		.bootstrap-iso form button:hover {
			color: white !important;
		}

		.asteriskField {
			color: red;
		}
		fieldset.scheduler-border {
			border: solid 1px rgba(0, 0, 0, 0.411) !important;
			padding: 0 5px 5px 5px;
			border-bottom: none;
		}

		legend.scheduler-border {
			width: auto !important;
			border: none;
			font-size: 14px;
		}
	</style>
		<div class="container mt-2">
			<div class="row">
				<div class="col">
					<div class="input-group mb-3">
						<span class="input-group-text" id="basic-addon1">Data Base (Dias)</span>
						<input type="text" class="form-control" id="DataBase" placeholder="Data base" aria-label="Username"
							aria-describedby="basic-addon1">
					</div>
				</div>
				<div class="col">
					<div class="input-group mb-3">
						<span class="input-group-text" id="basic-addon1">Dias Para Vencer (Dias)</span>
						<input type="text" class="form-control" id="DiaVencimento" placeholder="Vencimento" aria-label="Username"
							aria-describedby="basic-addon1">
					</div>
				</div>
				<div class="col">
					<div class="input-group mb-3">
						<span class="input-group-text" id="basic-addon1">Calcula Emb do Lote</span>
						<select class="form-select" aria-label="Disabled select example" id="Layout">
							<option id="1">SIM</option>
							<option id="2">NÃO</option>
						</select>
					</div>

				</div>
			</div>

			<div class="row">
				<div class="col-4">
					<div class="input-group mb-3">
						<span class="input-group-text" id="basic-addon1">Habilita Filtro de Seções</span>
						<select class="form-select" aria-label="Disabled select" id="Secoes">
							<option id="1">SIM</option>
							<option id="2">NÃO</option>
						</select>
					</div>
				</div>
				<div class="col-4">
					<div class="input-group mb-3">
						<span class="input-group-text" id="basic-addon1">Habilita Consulta Por Codigo</span>
						<select class="form-select" aria-label="Disabled select" id="Codigo">
							<option id="1">SIM</option>
							<option id="2">NÃO</option>
						</select>
					</div>
				</div>
				<div class="col">
					<div class="input-group mb-3">
						<span class="input-group-text" id="basic-addon1">Filtrar Por Agenda de Compra</span>
						<input type="text" class="form-control" id="Agenda" placeholder="Agenda" aria-label="Agenda"
							aria-describedby="basic-addon1">
					</div>
				</div>
			</div>
			<button type="button" id="Salvar" class="btn btn-success">Salvar Configurações</button>
		</div>

<script>

	$(document).ready(function () {
		$.ajax({
			type: 'GET',
			dataType: 'json',
			url: '../controller/ConfiguracoesSalvar.php',
			data: {id:'2'},
			cache: false,
			success: function (dado) {
				console.log(dado);
				$('#DataBase').val(dado[0].Data_Base);
				$('#DiaVencimento').val(dado[0].Venc_Dias);
				$('#Agenda').val(dado[0].Agenda);
				$("#Layout option[id='"+dado[0].Emb_LOTE+"']").attr('selected', 'selected');
				$("#Secoes option[id='"+dado[0].SECAO+"']").attr('selected', 'selected');
				$("#Codigo option[id='"+dado[0].CODIGO+"']").attr('selected', 'selected');

			}
		})
	});

	$('#Salvar').click(function () {
		$.ajax({
			type: 'GET',
			dataType: 'json',
			url: '../controller/ConfiguracoesSalvar.php',
			data: {id:'1',Data_Base:$('#DataBase').val(),Venc_Dias:$('#DiaVencimento').val(),EmbLote:$("#Layout option:selected").attr('id'),HabilitaCod:$("#Codigo option:selected").attr('id'), Secoes:$("#Secoes option:selected").attr('id'),Agenda:$('#Agenda').val()},
			cache: false,
			success: function (dado) {
				alert(dado);
			}
		});
	});


</script>