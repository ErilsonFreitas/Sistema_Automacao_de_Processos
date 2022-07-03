<?php
require('VerificaLogado.php');
require('bd.php');

$data =  $_POST['data'];

$datetime = DateTime::createFromFormat('Y-m-d', $data);
$data = $datetime->format('Y-m-d');

$sql = "select * from encartes where datainclusao='$data'";
$rows = [];
if($result = $mysqli->query($sql)){
  if($mysqli->affected_rows > 0){
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
      array_push($rows, $row);
    }
  }
}
echo json_encode($rows); 

mysqli_close($mysqli);
?>