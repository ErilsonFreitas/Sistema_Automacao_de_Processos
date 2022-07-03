<?php
require('VerificaLogado.php');
require('bd.php');

$dataAtual= date('Y-m-d');
$json =  json_decode($_POST['json'],true);

try{
    $status = [];
    foreach($json as $item){
        if(!empty($item)){
            $sql = "INSERT INTO encartes(id,cnpjfornecedor,nomefornecedor,dadosvendedor,ean,validadeproposta,encarte,categoria, inicio, fim, diasdeoferta, produto, custo, venda, margem,verba, observacao,aprovado,datainclusao) 
            VALUES(null,'{$item['cnpj']}','{$item['Fornecedor']}','{$item['Vendedor']}','','{$item['Proposta']}','{$item['Encarte']}','{$item['Categoria']}','{$item['dataini']}','{$item['datafim']}','','{$item['Item']}','{$item['Custo']}','{$item['Venda']}','{$item['Margem']}','{$item['Verba']}','{$item['obs']}','P',CURRENT_TIMESTAMP)";
            if($mysqli->query($sql)){
                $status = ["status"=>"s","msg"=>"Itens incluidos com Sucesso.."];
            }else {
                $status = ["status"=>"e","msg"=>"Problemas ao incluir Itens."];
            }
        }

    }
    echo json_encode($status);

}catch(Exception $e){
	echo json_encode(["status"=>"e","msg"=>"Problemas ao incluir Itens."]);
}

mysqli_close($mysqli);

?>