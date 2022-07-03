<?php
require('VerificaLogado.php');
require('bd.php');

$data =  $_GET['data'];

try {
    $sql = "SELECT encarte,produto,venda FROM encartes WHERE datainclusao = '$data'";
    $rows = [];
    if ($result = $mysqli->query($sql)) {
        if ($mysqli->affected_rows > 0) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                array_push($rows, $row);
            }
        }
        echo json_encode($rows);
    } else {
        echo json_encode(["err" => "s", "errmsg" => "Não Foi Possível Gerar o Excell !"]);
    }
} catch (Exception $e) {
    echo ($e);
}

mysqli_close($mysqli);
