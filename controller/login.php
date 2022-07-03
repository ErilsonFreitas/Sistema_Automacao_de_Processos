<?php
require('bd.php');
session_start();

$login = $_POST['login'];
$senha = $_POST['senha'];

function ConvertBool($x){
    return(filter_var($x, FILTER_VALIDATE_BOOLEAN));
}

$sql = "SELECT pwd,useradmin,moduloAcesso FROM usuario WHERE usuario = '$login'";

if($result = $mysqli->query($sql)){
    $hash = $result->fetch_array(MYSQLI_ASSOC);
    $Acesso = json_decode($hash['moduloAcesso'],true);

    $verify = password_verify($senha, $hash['pwd']);
    if ($verify) {
        $_SESSION['login'] = $login;
        $_SESSION['admin'] = ConvertBool($hash['useradmin']);
        $_SESSION['agenda'] = ConvertBool($Acesso['agenda']['ativo']);
        $_SESSION['encartes'] = ConvertBool($Acesso['encartes']['ativo']);
        $_SESSION['validade'] = ConvertBool($Acesso['validade']['ativo']);
        $_SESSION['portaria'] = ConvertBool($Acesso['portaria']['ativo']);
        $_SESSION['CheckRelatorio'] = ConvertBool($Acesso['relatorio']['ativo']);

        $_SESSION['agendainclusao'] = ConvertBool($Acesso['agenda']['permissao']['inclusao']);
        $_SESSION['agendaAlteracao'] = ConvertBool($Acesso['agenda']['permissao']['alteracao']);

        $_SESSION['portariainclusao'] = ConvertBool($Acesso['portaria']['permissao']['inclusao']);

        $_SESSION['encarteinclusao'] = ConvertBool($Acesso['encartes']['permissao']['inclusao']);
        $_SESSION['encarteAlteracao'] = ConvertBool($Acesso['encartes']['permissao']['alteracao']);

        $_SESSION['GerenciaAgenda'] = ConvertBool($Acesso['gerencia']['permissao']['Agenda']);
        $_SESSION['GerenciaEncarte'] = ConvertBool($Acesso['gerencia']['permissao']['encarte']);

        $_SESSION['CheckRelAgenda'] = ConvertBool($Acesso['relatorio']['permissao']['Agenda']);
        $_SESSION['CheckGerEncarte'] = ConvertBool($Acesso['relatorio']['permissao']['encarte']);
        $_SESSION['CheckRelValidade'] = ConvertBool($Acesso['relatorio']['permissao']['validade']);
        $_SESSION['CheckRelPortaria'] = ConvertBool($Acesso['relatorio']['permissao']['portaria']);
        header('Location: ../view/home.php');
    } else {
        $_SESSION['msg'] = 'Usuário ou senha informado inválidos.';
        unset($_SESSION['login']);
        unset($_SESSION['admin']);
        unset($_SESSION['agenda']);
        unset($_SESSION['validade']);
        unset($_SESSION['encartes']);
        header('Location: ../index.php');
    }
}else {
    $_SESSION['msg'] = 'ALERTA: Erro ao acessar o sistema, contate o suporte.';
    header('Location: ../index.php');
}
mysqli_close($mysqli);
?>