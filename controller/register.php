<?php
require('VerificaLogado.php');
require('bd.php');
$login = $_GET['login'];
$senha = $_GET['senha'];
$acessos = $_GET['acesso'];
$useradmin = $_GET['admin'];
$ativo = $_GET['ativo'];

$hash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "SELECT usuario FROM usuario WHERE usuario = '$login'";
if($mysqli->query($sql)){
    if($mysqli->affected_rows > 0){
        echo json_encode("Usuario ja Cadastrado");
    }else {
        $sql2 = "INSERT INTO usuario (usuario,pwd,moduloAcesso,useradmin,ativo) VALUES ('$login','$hash','$acessos','$useradmin','$ativo')";
        if(mysqli_query($MySql, $sql2)){
            echo json_encode("Salvo");
        }else {
            echo json_encode("Erro");
        }
    }
}else {
    echo json_encode('ALERTA: Erro ao acessar o sistema, contate o suporte.');
}


mysqli_close($mysqli);

?>