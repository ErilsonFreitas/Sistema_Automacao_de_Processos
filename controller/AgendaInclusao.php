<?php
require('VerificaLogado.php');
require('bd.php');

$dataAtual= date('Y-m-d');

$fonecedor =  $_POST['fonecedor'];
$nota =  $_POST['nota'];
$volume =  $_POST['volume'];
$palete =  $_POST['palete'];
$produto =  $_POST['produto'];
$tipo =  $_POST['tipo'];
$categoria =  $_POST['categoria'];
$data =  $_POST['data'];

$datetime = DateTime::createFromFormat('Y-m-d', $data);
$data = $datetime->format('Y-m-d');

try{
    $sql = "INSERT INTO agendamento(fornecedor, notaped, volume, qtdpalete, produto, TIPO, categoria, agendamento,obs, inclusao) VALUES('$fonecedor','$nota','$volume','$palete','$produto','$tipo','$categoria','$data','','$dataAtual')";
    if($mysqli->query($sql)){
        echo json_encode("Salvo");
    }else {
        echo json_encode("Erro");
    }
}catch(Exception $e){
	echo ($e);
}

mysqli_close($mysqli);

?>