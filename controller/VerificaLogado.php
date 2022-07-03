<?php
session_start();
if (!isset($_SESSION['login'])) {
    $_SESSION['msg'] = 'Faça login para acessar o sistema.';
    header('location: ../index.php');
}
?>