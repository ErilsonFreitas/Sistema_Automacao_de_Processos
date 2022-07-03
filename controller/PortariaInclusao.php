<?php
require('VerificaLogado.php');
require('bd.php');

$json =  json_decode($_POST['json'],true);

try{
    function Consultar($mysqli,$data){
        $datetime = DateTime::createFromFormat('Y-m-d', $data);
        $data = $datetime->format('Y-m-d');
        
        $sql = "select * from portaria where data_inclusao='$data'";
        $rows = [];
        if($result = $mysqli->query($sql)){
            if($mysqli->affected_rows > 0){
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    array_push($rows, $row);
                }
            }
        }
        echo json_encode($rows);
    };
    
    if($json['m']  == 'i'){
        $status = [];
    
        $sql = "INSERT INTO portaria(id,loja,endereco,placa,chegada,saida,usuario,data_inclusao) 
        VALUES(null,'{$json['Loja']}','{$json['Endereco']}','{$json['Placa']}','{$json['Chegada']}','{$json['Saida']}','{$json['usuario']}','{$json['Data']}')";
        
        if($sta = $mysqli->query($sql)){
            $status = ["status"=>"s","msg"=>"Itens incluidos com Sucesso.."];
            Consultar($mysqli,$json['Data']);
        }else {
            $status = ["status"=>"e","msg"=>"Problemas ao incluir Itens."];
        }
    }

}catch(Exception $e){
	echo json_encode(["status"=>"e","msg"=>"Problemas ao incluir Itens."]);
}

mysqli_close($mysqli);
