<?php 
require('../controller/VerificaLogado.php');
?>
<html>

<head>
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
	</style>
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />

</head>

<body>
	<div class="d-flex flex-row d-print-none">
		<div id="Alditoria" class="container-fluid mt-2">

			<div class="bootstrap-iso d-print-none">
				<div class="row mb-2 ">
					<div class="col-3 d-flex align-items-end d-none" id='ColSecoes'>
						<div class="input-group">
							<select class="form-select " aria-label="Disabled select" id="Secoes">
							</select>
						</div>
					</div>
					<div class="col-3 d-none" id='ColCodigo'>
						<input class="form-check-input" type="radio" name="Radio_Codigo" id="RCodigo"> Código
						<input class="form-check-input" type="radio" name="Radio_Codigo" id="REAN" checked> EAN
						<div class="input-group">
							<input type="number" class="form-control" id="Codigo" placeholder="Codigo"
								aria-label="Codigo" aria-describedby="basic-addon1">
							<button class="btn btn-primary mt-auto" id="submit" type="submit">Consultar</button>
						</div>
					</div>
					<div class="col"></div>
					
					<div class="col-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Quantidade de dias pra trás que o sistema usará para considerar se um item está ou não vencido.">
						<label for="floatingInput">Data Base(Dias)</label>
						<input type="number" class="form-control" id="DataBase" disabled>
					</div>
					<div class="col-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Quantidade de dias que o sistema usará para considerar se um item está ou não próximo do vencimento.">
						<label for="floatingInput">Próximo do Vencimento(Dias)</label>
						<input type="number" class="form-control" id="DiaVencimento" disabled>
					</div>
					<div class="col-auto mt-auto">
						<button type="button" class="btn btn-secondary" id="ImprimeErro"><svg
								xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
								class="bi bi-printer" viewBox="0 0 16 16">
								<path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
								<path
									d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
						</svg></button>
					</div>
				</div>
			</div>

			<div id="Load" style="display: none">
				<div class="d-flex justify-content-center mb-2 mt-2">
					<div class="spinner-border" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
					<span>&nbsp;&nbsp;&nbsp;Carregando Itens...</span>
				</div>
			</div>
			<div id="paraimprimir" class="w-100 mw-100 overflow-auto border border-secondary" style="height: 85%;">
				<table class="table table-bordered border-dark table-hover" id="Tabela">
					<thead>
						<tr>
							<th scope="col">Código</th>
							<th scope="col" class="text-center">DESCRIÇÃO</th>
							<th scope="col">ESTOQUE ATUAL</th>
							<th scope="col" class="text-center">
								<select class="form-select form-select-sm d-print-none" id="Layout">
									<option id="00" selected>STATUS</option>
									<option id="OPT01">VENCIDOS</option>
									<option id="OPT02">PRÓXIMO DO VENCIMENTO</option>
									<option id="OPT03">DENTRO DA VALIDADE</option>
								</select>
								ETRADAS NO ESTOQUE
							</th>
						</tr>
					</thead>
					<tbody id="itens" class="text-center">

					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="DivPrincipal d-none">
		<div class="Desc"></div>
		<table class="table table-bordered table-sm border-dark">
			<thead>
				<tr><th colspan="3" class="ColTabela01" id="ImpEAN"></th></tr>
				<tr>
					<th scope="col" class="ColTabela01">LOTE</th>
					<th scope="col" class="ColTabela01">ENTRADA</th>
					<th scope="col" class="ColTabela01">VALIDADE</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td scope="col" class="ColTabela02"><div class="Lote"></div></td>
					<td scope="col" class="ColTabela02"><div class="Entrada"></div></td>
					<td scope="col" class="ColTabela02"><div class="Validade"></div></td>
				</tr>	
			</tbody>
		</table>
	</div>
	<div id="areadeimpressao" class="p-2">

	</div>
</body>

<script>
	$('#ImprimeErro').click(function () {
		$("#areadeimpressao").html($('#paraimprimir').html());
		window.print($('#paraimprimir').html());
		$("#areadeimpressao").html("");
	});

	function BTImprime(imp){
		var LoteTMP = Itens[$(imp).attr('PID')].LFT_LOTE;
		$('#ImpEAN').html('EAN: '+Itens[$(imp).attr('PID')].GIT_CODIGO_EAN13+' | QUANTIDADE: '+LoteTMP[$(imp).attr('PIDL')].QTD);
		$('.Lote').html($(imp).attr('PIDL'));
		$('.Desc').html(Itens[$(imp).attr('PID')].GIT_DESCRICAO);
		$('.Entrada').html(LoteTMP[$(imp).attr('PIDL')].AGENDA);
		$('.Validade').html(LoteTMP[$(imp).attr('PIDL')].DATA);
		$(".DivPrincipal").removeClass("d-none");
		window.print();
		$(".DivPrincipal").addClass("d-none");
	}

	var Itens = '';
	$('#BaixaLote').change(function () {
		if (window.confirm("Baixa de Lote, esta opção não poderá ser desfeita!")) {
			alert($("#BaixaLote option:selected").attr('id'));
		} else {
			alert('Ação cancelada');
		}
	});
	$(document).ready(function () {
		$.ajax({
			type: 'GET',
			dataType: 'json',
			url: '../controller/ConfiguracoesSalvar.php',
			data: { id: '2' },
			cache: false,
			success: function (dado) {
				$('#DataBase').val(dado[0].Data_Base);
				$('#DiaVencimento').val(dado[0].Venc_Dias);
				if (dado[0].SECAO == '1') {
					$("#ColSecoes").removeClass("d-none");
				} else {
					$("#ColSecoes").addClass("d-none");
				}
				if (dado[0].CODIGO == '1') {
					$("#ColCodigo").removeClass("d-none");
				} else {
					$("#ColCodigo").addClass("d-none");
				}
			}
		});
		$.ajax({
			dataType: 'json', url: '../controller/ValidadeConsultaSecoes.php', cache: false,
			success: function (dado) {
				var td = '<option id="9999" selected>GERAL</option>';
				for (var i = 0; i < dado.length; i++) {
					td += '<option id="' + dado[i].SECAO + '">"' + dado[i].DESCR_SECAO + '"</option>';
				}
				$('#Secoes').html(td.replace(/\"/g, ""));

			}
		});
	});

	$('#submit').click(function () {
		Conferindo();
	});

	$('#Layout').change(function () {
		ListaItens();
	});
	$('#Secoes').change(function () {
		$("#Layout option[id='00']").attr('selected', 'selected');
		ListaItensSecao();
	});
	function ListaItensSecao() {
		$('#itens').html('');
		var td = '';
		var td1 = '';
		var Sub = '';
		var lote = '';
		var controle = 0;
		if ($("#Secoes option:selected").attr('id') == '9999') {
			for (var x = 0; x < Itens.length; x++) {
				controle = 0;
				Sub = '';
				lote = '';
				td1 = '<table class="table table-bordered border-dark" style="font-size:13px;"><thead"><tr><th scope="col">LOTE</th><th scope="col">ENTRADA</th><th scope="col">VALIDADE</th><th scope="col">QUANTIDADE</th><th scope="col">STATUS</th></tr></thead><tbody>';
				lote = Itens[x].LFT_LOTE;
				for (var key in lote) {
					td1 += '<tr ><td >Lote: "' + key + '"<br></td>';
					td1 += '<td >"' + lote[key].AGENDA + '"</td>';
					td1 += '<td >"' + lote[key].DATA + '"</td>';
					td1 += '<td >"' + lote[key].QTD + '"</td>';
					td1 += '<td class="' + lote[key].STATUS_COR + '" ><b>"' + lote[key].DESC_ESTATUS + '"</b></td>';
					td1 += '<td ><img onclick="BTImprime(this)" PID="'+x+'" PIDL="'+key+'" id="' + Itens[x].GIT_CODIGO + '" src="icon/printer.svg" class="rounded mx-auto d-block" alt="Imprimir"></td></tr>';
					controle = 1;
				}

				td1 += '</tbody></table>';

				td += '<tr >';
				td += '<td >"' + Itens[x].GIT_CODIGO + '"</td>';
				td += '<td class="text-center">"' + Itens[x].GIT_DESCRICAO + '"<br><b>"' + Itens[x].GIT_CODIGO_EAN13 + '"</b></td>';
				td += '<td >"' + Itens[x].GIT_ESTQ_ATUAL + '"</td>';
				td += '<td >"' + td1 + '"</td></tr>';
			}
			$("#Load").hide();
			$('#itens').html(td.replace(/\"/g, ""));
		} else {
			for (var x = 0; x < Itens.length; x++) {
				if ($("#Secoes option:selected").attr('id') == Itens[x].SECAO) {
					controle = 0;
					Sub = '';
					lote = '';
					td1 = '<table class="table table-bordered border-dark" style="font-size:13px;"><thead"><tr><th scope="col">LOTE</th><th scope="col">ENTRADA</th><th scope="col">VALIDADE</th><th scope="col">QUANTIDADE</th><th scope="col">STATUS</th></tr></thead><tbody>';
					lote = Itens[x].LFT_LOTE;
					for (var key in lote) {
						td1 += '<tr ><td >Lote: "' + key + '"<br></td>';
						td1 += '<td >"' + lote[key].AGENDA + '"</td>';
						td1 += '<td >"' + lote[key].DATA + '"</td>';
						td1 += '<td >"' + lote[key].QTD + '"</td>';
						td1 += '<td class="' + lote[key].STATUS_COR + '" ><b>"' + lote[key].DESC_ESTATUS + '"</b></td>';
						td1 += '<td ><img onclick="BTImprime(this)" PID="'+x+'" PIDL="'+key+'" id="' + Itens[x].GIT_CODIGO + '" src="icon/printer.svg" class="rounded mx-auto d-block" alt="Imprimir"></td></tr>';
						controle = 1;
					}

					td1 += '</tbody></table>';

					td += '<tr >';
					td += '<td >"' + Itens[x].GIT_CODIGO + '"</td>';
					td += '<td class="text-center">"' + Itens[x].GIT_DESCRICAO + '"<br><b>"' + Itens[x].GIT_CODIGO_EAN13 + '"</b></td>';
					td += '<td >"' + Itens[x].GIT_ESTQ_ATUAL + '"</td>';
					td += '<td >"' + td1 + '"</td></tr>';
				}
			}
			$("#Load").hide();
			$('#itens').html(td.replace(/\"/g, ""));
		}

	}

	function ListaItens() {
		$('#itens').html('');
		if ($("#Secoes option:selected").attr('id') == '9999') {
			$('#itens').html('');
			id = $("#Layout option:selected").attr('id');
			var td = '';
			var td1 = '';
			var Sub = '';
			var lote = '';
			var controle = 0;
			if (id == '00') {
				for (var x = 0; x < Itens.length; x++) {
					controle = 0;
					Sub = '';
					lote = '';
					td1 = '<table class="table table-bordered border-dark" style="font-size:13px;"><thead"><tr><th scope="col">LOTE</th><th scope="col">ENTRADA</th><th scope="col">VALIDADE</th><th scope="col">QUANTIDADE</th><th scope="col">STATUS</th></tr></thead><tbody>';
					lote = Itens[x].LFT_LOTE;
					for (var key in lote) {
						td1 += '<tr ><td >Lote: "' + key + '"<br></td>';
						td1 += '<td >"' + lote[key].AGENDA + '"</td>';
						td1 += '<td >"' + lote[key].DATA + '"</td>';
						td1 += '<td >"' + lote[key].QTD + '"</td>';
						td1 += '<td class="' + lote[key].STATUS_COR + '" ><b>"' + lote[key].DESC_ESTATUS + '"</b></td>';
						td1 += '<td ><img onclick="BTImprime(this)" PID="'+x+'" PIDL="'+key+'" id="' + Itens[x].GIT_CODIGO + '" src="icon/printer.svg" class="rounded mx-auto d-block" alt="Imprimir"></td></tr>';
						controle = 1;
					}

					td1 += '</tbody></table>';

					td += '<tr >';
					td += '<td >"' + Itens[x].GIT_CODIGO + '"</td>';
					td += '<td class="text-center">"' + Itens[x].GIT_DESCRICAO + '"</td>';
					td += '<td >"' + Itens[x].GIT_ESTQ_ATUAL + '"</td>';
					td += '<td >"' + td1 + '"</td></tr>';


				}
			} else {
				for (var x = 0; x < Itens.length; x++) {
					controle = 0;
					Sub = '';
					lote = '';
					td1 = '<table class="table" style="font-size:13px;"><thead"><tr><th scope="col">LOTE</th><th scope="col">ENTRADA</th><th scope="col">VALIDADE</th><th scope="col">QUANTIDADE</th><th scope="col">STATUS</th></tr></thead><tbody>';
					lote = Itens[x].LFT_LOTE;
					for (var key in lote) {
						if (lote[key].COD_ESTATUS == id) {
							td1 += '<tr ><td >Lote: "' + key + '"<br></td>';
							td1 += '<td >"' + lote[key].AGENDA + '"</td>';
							td1 += '<td >"' + lote[key].DATA + '"</td>';
							td1 += '<td >"' + lote[key].QTD + '"</td>';
							td1 += '<td class="' + lote[key].STATUS_COR + '" ><b>"' + lote[key].DESC_ESTATUS + '"</b></td>';
							td1 += '<td ><img onclick="BTImprime(this)" PID="'+x+'" PIDL="'+key+'" id="' + Itens[x].GIT_CODIGO + '" src="icon/printer.svg" class="rounded mx-auto d-block" alt="Imprimir"></td></tr>';
							controle = 1;
						}
					}

					td1 += '</tbody></table>';
					if (controle == 1) {
						td += '<tr >';
						td += '<td >"' + Itens[x].GIT_CODIGO + '"</td>';
						td += '<td >"' + Itens[x].GIT_DESCRICAO + '"<br><b>"' + Itens[x].GIT_CODIGO_EAN13 + '"</b></td>';
						td += '<td >"' + Itens[x].GIT_ESTQ_ATUAL + '"</td>';
						td += '<td >"' + td1 + '"</td></tr>';
					}


				}
			}
			$("#Load").hide();
			$('#itens').html(td.replace(/\"/g, ""));
		} else {
			$('#itens').html('');
			id = $("#Layout option:selected").attr('id');
			var td = '';
			var td1 = '';
			var Sub = '';
			var lote = '';
			var controle = 0;
			if (id == '00') {
				for (var x = 0; x < Itens.length; x++) {
					if ($("#Secoes option:selected").attr('id') == Itens[x].SECAO) {
						controle = 0;
						Sub = '';
						lote = '';
						td1 = '<table class="table table-bordered border-dark" style="font-size:13px;"><thead"><tr><th scope="col">LOTE</th><th scope="col">ENTRADA</th><th scope="col">VALIDADE</th><th scope="col">QUANTIDADE</th><th scope="col">STATUS</th></tr></thead><tbody>';
						lote = Itens[x].LFT_LOTE;
						for (var key in lote) {
							td1 += '<tr ><td >Lote: "' + key + '"<br></td>';
							td1 += '<td >"' + lote[key].AGENDA + '"</td>';
							td1 += '<td >"' + lote[key].DATA + '"</td>';
							td1 += '<td >"' + lote[key].QTD + '"</td>';
							td1 += '<td class="' + lote[key].STATUS_COR + '" ><b>"' + lote[key].DESC_ESTATUS + '"</b></td>';
							td1 += '<td ><img onclick="BTImprime(this)" PID="'+x+'" PIDL="'+key+'" id="' + Itens[x].GIT_CODIGO + '" src="icon/printer.svg" class="rounded mx-auto d-block" alt="Imprimir"></td></tr>';
							controle = 1;
						}

						td1 += '</tbody></table>';

						td += '<tr >';
						td += '<td >"' + Itens[x].GIT_CODIGO + '"</td>';
						td += '<td class="text-center">"' + Itens[x].GIT_DESCRICAO + '"<br><b>"' + Itens[x].GIT_CODIGO_EAN13 + '"</b></td>';
						td += '<td >"' + Itens[x].GIT_ESTQ_ATUAL + '"</td>';
						td += '<td >"' + td1 + '"</td></tr>';
					}
				}
			} else {
				for (var x = 0; x < Itens.length; x++) {
					if ($("#Secoes option:selected").attr('id') == Itens[x].SECAO) {
						controle = 0;
						Sub = '';
						lote = '';
						td1 = '<table class="table" style="font-size:13px;"><thead"><tr><th scope="col">LOTE</th><th scope="col">ENTRADA</th><th scope="col">VALIDADE</th><th scope="col">QUANTIDADE</th><th scope="col">STATUS</th></tr></thead><tbody>';
						lote = Itens[x].LFT_LOTE;
						for (var key in lote) {
							if (lote[key].COD_ESTATUS == id) {
								td1 += '<tr ><td >Lote: "' + key + '"<br></td>';
								td1 += '<td >"' + lote[key].AGENDA + '"</td>';
								td1 += '<td >"' + lote[key].DATA + '"</td>';
								td1 += '<td >"' + lote[key].QTD + '"</td>';
								td1 += '<td class="' + lote[key].STATUS_COR + '" ><b>"' + lote[key].DESC_ESTATUS + '"</b></td></tr>';
								td1 += '<td ><img onclick="BTImprime(this)" PID="'+x+'" PIDL="'+key+'" id="' + Itens[x].GIT_CODIGO + '" src="icon/printer.svg" class="rounded mx-auto d-block" alt="Imprimir"></td></tr>';
								controle = 1;
							}
						}

						td1 += '</tbody></table>';
						if (controle == 1) {
							td += '<tr >';
							td += '<td >"' + Itens[x].GIT_CODIGO + '"</td>';
							td += '<td >"' + Itens[x].GIT_DESCRICAO + '"<br><b>"' + Itens[x].GIT_CODIGO_EAN13 + '"</b></td>';
							td += '<td >"' + Itens[x].GIT_ESTQ_ATUAL + '"</td>';
							td += '<td >"' + td1 + '"</td></tr>';
						}
					}

				}
			}
			$("#Load").hide();
			$('#itens').html(td.replace(/\"/g, ""));
		}


	}

	function Conferindo() {
		$("#Load").show();
		$.ajax({
			type: 'GET',
			dataType: 'json',
			url: '../controller/ValidadeConfere.php',
			data: { Data_Base: $('#DataBase').val(), Venc_Dias: $('#DiaVencimento').val(), Codigo: $('#Codigo').val(), Opcao: $('#RCodigo').is(':checked') },
			cache: false,
			success: function (dado) {
				$('#itens').html('');
				ListaValidade(dado);
				Itens = dado;
				for (var z = 0; z < Itens.length; z++) {
					$("#" + Itens[z].SECAO + "").removeClass("d-none");
				}

			}
		});

	}

	function ListaValidade(dado2) {
		var Linha1 = '';
		var Linha2 = '';
		var Linha3 = '';
		var td1 = '';
		var Sub = '';
		var lote = '';
		for (var x = 0; x < dado2.length; x++) {
			if (dado2[x].PESO == '1') {
				Sub = '';
				lote = '';
				td1 = '<table class="table" style="font-size:13px;"><thead"><tr><th scope="col">LOTE</th><th scope="col">ENTRADA</th><th scope="col">VALIDADE</th><th scope="col">QUANTIDADE</th><th scope="col">STATUS</th></tr></thead><tbody>';
				Linha1 += '<tr >';
				Linha1 += '<td >"' + dado2[x].GIT_CODIGO + '"<br></td>';
				Linha1 += '<td >"' + dado2[x].GIT_DESCRICAO + '"<br><b>"' + dado2[x].GIT_CODIGO_EAN13 + '"</b><br></td>';
				Linha1 += '<td >"' + dado2[x].GIT_ESTQ_ATUAL + '"</td>';
				lote = dado2[x].LFT_LOTE;
				for (var key in lote) {
					td1 += '<tr ><td >"' + key + '"<br></td>';
					td1 += '<td >"' + lote[key].AGENDA + '"</td>';
					td1 += '<td >"' + lote[key].DATA + '"</td>';
					td1 += '<td >"' + lote[key].QTD + '"</td>';
					td1 += '<td class="' + lote[key].STATUS_COR + '" ><b>"' + lote[key].DESC_ESTATUS + '"</b></td>';
					td1 += '<td class="d-print-none"><img onclick="BTImprime(this)" PID="'+x+'" PIDL="'+key+'" id="' + dado2[x].GIT_CODIGO + '" src="icon/printer.svg" class="rounded mx-auto d-block" alt="Imprimir"></td></tr>';
				}
				td1 += '</tbody></table>';
				Linha1 += '<td >"' + td1 + '"</td></tr>';
			} else if (dado2[x].PESO == '2') {
				Sub = '';
				lote = '';
				td1 = '<table class="table" style="font-size:13px;"><thead"><tr><th scope="col">LOTE</th><th scope="col">ENTRADA</th><th scope="col">VALIDADE</th><th scope="col">QUANTIDADE</th><th scope="col">STATUS</th></tr></thead><tbody>';
				Linha2 += '<tr >';
				Linha2 += '<td >"' + dado2[x].GIT_CODIGO + '"<br></td>';
				Linha2 += '<td >"' + dado2[x].GIT_DESCRICAO + '"<br><b>"' + dado2[x].GIT_CODIGO_EAN13 + '"</b></td>';
				Linha2 += '<td >"' + dado2[x].GIT_ESTQ_ATUAL + '"</td>';
				lote = dado2[x].LFT_LOTE;
				for (var key in lote) {
					td1 += '<tr ><td >"' + key + '"<br></td>';
					td1 += '<td >"' + lote[key].AGENDA + '"</td>';
					td1 += '<td >"' + lote[key].DATA + '"</td>';
					td1 += '<td >"' + lote[key].QTD + '"</td>';
					td1 += '<td class="' + lote[key].STATUS_COR + '" ><b>"' + lote[key].DESC_ESTATUS + '"</b></td>';
					td1 += '<td class="d-print-none"><img onclick="BTImprime(this)" PID="'+x+'" PIDL="'+key+'" id="' + dado2[x].GIT_CODIGO + '" src="icon/printer.svg" class="rounded mx-auto d-block" alt="Imprimir"></td></tr>';
				}
				td1 += '</tbody></table>';
				Linha2 += '<td >"' + td1 + '"</td></tr>';
			} else {
				Sub = '';
				lote = '';
				td1 = '<table class="table" style="font-size:13px;"><thead"><tr><th scope="col">LOTE</th><th scope="col">ENTRADA</th><th scope="col">VALIDADE</th><th scope="col">QUANTIDADE</th><th scope="col">STATUS</th></tr></thead><tbody>';
				Linha3 += '<tr >';
				Linha3 += '<td >"' + dado2[x].GIT_CODIGO + '"<br></td>';
				Linha3 += '<td >"' + dado2[x].GIT_DESCRICAO + '"<br><b>"' + dado2[x].GIT_CODIGO_EAN13 + '"</b></td>';
				Linha3 += '<td >"' + dado2[x].GIT_ESTQ_ATUAL + '"</td>';
				lote = dado2[x].LFT_LOTE;
				for (var key in lote) {
					td1 += '<tr ><td >"' + key + '"<br></td>';
					td1 += '<td >"' + lote[key].AGENDA + '"</td>';
					td1 += '<td >"' + lote[key].DATA + '"</td>';
					td1 += '<td >"' + lote[key].QTD + '"</td>';
					td1 += '<td class="' + lote[key].STATUS_COR + '" ><b>"' + lote[key].DESC_ESTATUS + '"</b></td>';
					td1 += '<td class="d-print-none"><img onclick="BTImprime(this)" PID="'+x+'" PIDL="'+key+'" id="' + dado2[x].GIT_CODIGO + '" src="icon/printer.svg" class="rounded mx-auto d-block" alt="Imprimir"></td></tr>';
				}
				td1 += '</tbody></table>';
				Linha3 += '<td >"' + td1 + '"</td></tr>';
			}


		}
		Linha1 = Linha1 + Linha2 + Linha3;
		$("#Load").hide();
		$('#itens').html(Linha1.replace(/\"/g, ""));
	}

	$('#btn').click(function () {
		window.print();
	});
</script>
</html>