<?php
require('VerificaLogado.php');
require('bd.php');

$id =  $_GET['id'];

if($id == '2'){
	$sql = "select * from config_globais";
	if($result = $mysqli->query($sql)){
		if($mysqli->affected_rows > 0){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}
			echo json_encode($rows);
		}
	}
}else{
	$Data_Base =  $_GET['Data_Base'];
	$Venc_Dias =  $_GET['Venc_Dias'];
	$EmbLote =  $_GET['EmbLote'];
	$Secoes =  $_GET['Secoes'];
	$Codigo =  $_GET['HabilitaCod'];
	$Agenda =  $_GET['Agenda'];
	$sql = "UPDATE config_globais SET Data_Base='$Data_Base', Venc_Dias='$Venc_Dias', Emb_LOTE='$EmbLote',SECAO='$Secoes',CODIGO='$Codigo',Agenda='$Agenda'";
	if($mysqli->query($sql)){
		echo json_encode("Configurações Salvas !!");
	}else{
		echo json_encode("Aviso: Configurações Não Salvas!");
	}
}

mysqli_close($mysqli);
?>