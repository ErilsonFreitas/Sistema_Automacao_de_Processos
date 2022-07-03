<?php
require('VerificaLogado.php');
require('bd.php');

$alt =  $_POST['alt'];
$id =  $_POST['id'];

function Msg($alt){
    if($alt == 'A'){
        return json_encode(["msg"=>"Salvo","status"=>"Aprovado","classe"=>"text-success fw-bolder","err"=>"n"]);
    }elseif($alt == 'R'){
        return json_encode(["msg"=>"Salvo","status"=>"Reprovado","classe"=>"text-danger fw-bolder","err"=>"n"]);
    }else{
        return json_encode(["msg"=>"Salvo","err"=>"n"]);
    }
}

try{
    $sql = "UPDATE encartes SET aprovado = '$alt' WHERE id='$id'";
    if($mysqli->query($sql)){
        echo Msg($alt);
    }else {
        echo json_encode(["err"=>"s","errmsg"=>"ATENÇÃO:Ocarreu um Erro ao tentar executar esta ação !"]);
    }

}catch(Exception $e){
	echo ($e);
}

mysqli_close($mysqli);
