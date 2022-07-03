<?php
require('VerificaLogado.php');
require('bd.php');

$sql = "SELECT SECAO,DESCR_SECAO FROM VWGD_SECAO";
$stid = oci_parse($ConRms, $sql);
oci_execute($stid);
while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {

	$Itens[] = $row;
}
oci_free_statement($stid);
echo json_encode($Itens);
oci_close($ConRms);

?>