<?php
require('VerificaLogado.php');
require('bd.php');

$metodo =  $_POST['metodo'];
if($metodo == 'inclusao'){
    $user =  $_POST['user'];
    $sqlverify = "SELECT usuario FROM usuario WHERE usuario = '{$user}'";
    $mysqli->query($sqlverify);
    if($mysqli->affected_rows > 0){
        echo json_encode(["msg"=>"ATENÇÃO: Já esxite um usuário com este nome."]);
    }else{
        $acesso =  json_encode($_POST['acesso']);
        $admin =  $_POST['admin'];
        $ativo =  $_POST['ativo'];
        $pass =  password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuario (usuario, pwd, moduloAcesso, useradmin, ativo) values ('{$user}','{$pass}','{$acesso}','{$admin}','{$ativo}')";
        if($mysqli->query($sql)){
            echo json_encode(["msg"=>"Usuario Salvo"]);
        }else{
            echo json_encode(["msg"=>"Ocorreu um erro ao inserir o usuário."]);
        }         
    }

}elseif($metodo == 'consulta'){
    $user =  $_POST['user'];
    $sqlverify = "SELECT id,usuario,moduloAcesso,useradmin,ativo FROM usuario WHERE usuario = '{$user}'";
    $result = $mysqli->query($sqlverify);
    if($mysqli->affected_rows > 0){
        echo json_encode(["msg"=>"","dados"=>$result->fetch_assoc()]);
    }else{
        echo json_encode(["msg"=>"ATENÇÃO: Usuário não encontrado."]);
    }
}elseif($metodo == 'update'){
    $user =  $_POST['user'];
    $acesso =  json_encode($_POST['acesso']);
    $admin =  $_POST['admin'];
    $ativo =  $_POST['ativo'];
    $sqlverify = "UPDATE usuario SET usuario='{$user}',moduloAcesso='{$acesso}',useradmin='{$admin}', ativo='{$ativo}' WHERE usuario = '{$user}'";
    $mysqli->query($sqlverify);
    if($mysqli->affected_rows > 0){
        echo json_encode(["msg"=>"Usuário Atualizado com Sucesso."]);
    }else{
        echo json_encode(["msg"=>"ATENÇÃO: Erro ao salvar o usuário."]); 
    }
}elseif($metodo == 'exclusao'){
    $id =  $_POST['id'];
}

mysqli_close($mysqli);
?>