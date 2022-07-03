<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['admin']);
unset($_SESSION['agenda']);
unset($_SESSION['validade']);
unset($_SESSION['encartes']);
session_destroy();
header('Location: ../index.php');
?>