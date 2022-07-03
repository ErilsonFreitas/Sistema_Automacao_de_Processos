<?php
require('VerificaLogado.php');
require('bd.php');

$alt =  $_POST['alt'];
$obs =  $_POST['obs1'];
$id =  $_POST['id'];

function Msg($alt){
    if($alt == 'A'){
        return json_encode(["msg"=>"Salvo","status"=>"Atendido","classe"=>"text-success","err"=>"n"]);
    }elseif($alt == 'N'){
        return json_encode(["msg"=>"Salvo","status"=>"Não Atendido","classe"=>"text-danger","err"=>"n"]);
    }else{
        return json_encode(["msg"=>"Salvo","err"=>"n"]);
    }
}

try{
    if($alt == 'A' || $alt == 'N'){
        $sql = "UPDATE agendamento SET status = '$alt',`obs` = '$obs' WHERE id='$id'";
        if($mysqli->query($sql)){
            echo Msg($alt);
        }else {
            echo json_encode(["err"=>"s","errmsg"=>"ATENÇÃO:Ocarreu um Erro ao tentar executar esta ação !"]);
        }
    }elseif($alt == 'R'){
        $data =  $_POST['nova'];
        $datetime = DateTime::createFromFormat('Y-m-d', $data);
        $data = $datetime->format('Y-m-d');        
        $sql = "UPDATE agendamento SET `status`= '',`obs`='$obs', `agendamento`='$data' WHERE id='$id'";
        if($mysqli->query($sql)){
            echo Msg($alt);
        }else {
            echo json_encode(["err"=>"s","errmsg"=>"ATENÇÃO:Ocarreu um Erro ao tentar executar esta ação !"]);
        }
    }
}catch(Exception $e){
	echo ($e);
}

mysqli_close($mysqli);

?>