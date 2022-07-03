<?php
require('VerificaLogado.php');
require('bd.php');

$metodo =  $_POST['metodo'];

if($metodo == 'inclusao'){
    $modulo =  $_POST['modulo'];
    $menu =  $_POST['menu'];
    if($modulo == 'tipo'){
        $dados =  strtoupper($_POST['dados']);
        $sql = "INSERT INTO agendatipo(tipo) VALUES ('$dados')";
        if($mysqli->query($sql)){
            echo json_encode("Tipo Salvo");
        }else {
            echo json_encode("Erro");
        }
    }elseif($modulo == 'categoria'){
        $dados =  strtoupper($_POST['dados']);
        $sql = "INSERT INTO categorias(descricao,menu) VALUES ('$dados','$menu')";
        if($mysqli->query($sql)){
            echo json_encode("Categoria Salva");
        }else {
            echo json_encode("Erro");
        }
    }

}elseif($metodo == 'exclusao'){
    $id =  $_POST['id'];
    $modulo =  $_POST['modulo'];
    if($modulo == 'tipo'){
        $sql = "DELETE FROM agendatipo WHERE id = '$id'";
        if($mysqli->query($sql)){
            echo json_encode("Cadastro de Tipo Excluido !!");
        }else{
            echo json_encode("Aviso: Nao foi possível excluir o Cadastro de Tipo");
        }
    }elseif($modulo == 'categoria'){
        $sql = "DELETE FROM categorias WHERE id = '$id'";
        if($mysqli->query($sql)){
            echo json_encode("Cadastro da Categoria Excluido !!");
        }else{
            echo json_encode("Aviso: Nao foi possível excluir o Cadastro da Categoria");
        }
    }
}elseif($metodo == 'consulta'){
    $menu = $_POST['menu'];
    $rows = ['tipo'=>[],'categoria'=>[]];

    $sql = "select * from agendatipo";
    if($result = $mysqli->query($sql)){
		if($mysqli->affected_rows > 0){
                while($row2 = $result->fetch_array(MYSQLI_ASSOC)){
                    array_push( $rows['tipo'], $row2);
                }
		}
	}

    if($menu == 'todos'){
        $sql2 = "select * from categorias";
        if($result = $mysqli->query($sql2)){
            if($mysqli->affected_rows > 0){
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    array_push($rows['categoria'], $row);
                }
            }
        }
    }else{
        $sql2 = "select * from categorias where menu = '$menu'";
        if($result = $mysqli->query($sql2)){
            if($mysqli->affected_rows > 0){
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    array_push($rows['categoria'], $row);
                }
            }
        }
    }
    echo json_encode($rows);  
}else{
    echo json_encode("Dados Inconsistentes!!");
}

mysqli_close($mysqli);
?>