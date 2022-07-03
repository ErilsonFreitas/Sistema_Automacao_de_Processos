<?php
require('bd.php');
$Data_Base =  $_GET['Data_Base'];
$Venc_Dias =  $_GET['Venc_Dias'];
$data = '1' . date('ymd', strtotime('-' . $Data_Base . ' days'));
$ItensArray = [];
$ItensVencidos = [];
$ItensProximo = [];
$ItensValidos = [];
$TotalLoteVenc = '';
$TotalLoteProx = '';
$TotalLoteVal = '';

$SqlConfig = "SELECT Emb_LOTE,Agenda from config_globais cg";
$ResultConfig = $mysqli->query($SqlConfig);
$RowConfig = $ResultConfig->fetch_array(MYSQLI_ASSOC);
if (empty($RowConfig['Agenda']) or $RowConfig['Agenda'] == '0') {
   $Agenda = '';
} else {
   $Agenda = 'AND LFT_AGENDA =' . $RowConfig['Agenda'];
}

function ValidaCodigo($OpcaoItem, $CodigoItem, $ConRms){
   if ($OpcaoItem == 'true') {
      return $CodigoItem;
   } else {
      $sql = "SELECT GIT_COD_ITEM FROM AA3CITEM WHERE GIT_CODIGO_EAN13 = :Ean";
      $stid = oci_parse($ConRms, $sql);
      oci_bind_by_name($stid, ':Ean', $CodigoItem);
      oci_execute($stid);
      $row = oci_fetch_array($stid, OCI_ASSOC) ?? '';
      oci_free_statement($stid);
      if ($row != '') {
         return $row['GIT_COD_ITEM'];
      } else {
         $sql2 = "SELECT EAN_COD_PRO_ALT FROM AA3CCEAN WHERE EAN_COD_EAN = :CodAlt";
         $stid2 = oci_parse($ConRms, $sql2);
         oci_bind_by_name($stid2, ':CodAlt', $CodigoItem);
         oci_execute($stid2);
         $CODAUX = oci_fetch_array($stid2, OCI_ASSOC) ?? '';
         oci_free_statement($stid2);

         $CodSemDig = substr($CODAUX['EAN_COD_PRO_ALT'], 0, -1);
         return $CodSemDig;
      }
   }
}
if (empty($_GET['Codigo'])) {
   $sql = "SELECT LFT_DT_AGENDA,LFT_COD_ITEM,LFT_LOTE,LFT_QUANTIDADE,LFT_DT_VALIDADE FROM AG5FATLT af WHERE LFT_DT_VALIDADE >=$data $Agenda ORDER BY LFT_DT_AGENDA DESC";
} else {
   $Codigo =  ValidaCodigo($_GET['Opcao'], $_GET['Codigo'], $ConRms);
   $sql = "SELECT LFT_DT_AGENDA,LFT_COD_ITEM,LFT_LOTE,LFT_QUANTIDADE,LFT_DT_VALIDADE FROM AG5FATLT af WHERE LFT_COD_ITEM = $Codigo AND LFT_DT_VALIDADE >=$data $Agenda ORDER BY LFT_DT_AGENDA DESC";
}

$result = oci_parse($ConRms, $sql);
oci_execute($result);

while (($row = oci_fetch_array($result, OCI_ASSOC)) != false) {
   $sql3 = "SELECT GIT_DESCRICAO,GIT_COD_ITEM,GIT_DIGITO,GIT_ESTQ_ATUAL,GIT_SECAO,GIT_EMB_FOR,GIT_CODIGO_EAN13 FROM AA3CITEM WHERE GIT_COD_ITEM = :CodFim";
   $stid3 = oci_parse($ConRms, $sql3);
   oci_bind_by_name($stid3, ':CodFim', $row['LFT_COD_ITEM']);
   oci_execute($stid3);
   $row3 = oci_fetch_array($stid3, OCI_ASSOC) ?? '';
   oci_free_statement($stid3);
   if (!empty($row3)) {
      if ($row3['GIT_ESTQ_ATUAL'] > '0') {
         $GIT_CODIGO = $row3['GIT_COD_ITEM'] . $row3['GIT_DIGITO'];
         $data_inicio = date_create(date('y-m-d'));
         $data_fim = date_create(substr($row['LFT_DT_VALIDADE'], 1, 2) . '-' . substr($row['LFT_DT_VALIDADE'], 3, 2) . '-' . substr($row['LFT_DT_VALIDADE'], 5, 2)); //date_create('21-08-25');
         $interval = date_diff($data_inicio, $data_fim);
         $ItensArray[$GIT_CODIGO]['GIT_DIAS_VENC'] = $interval->format('%R%a');

         $AgendaTMP = substr($row['LFT_DT_AGENDA'], 5, 2) . '/' . substr($row['LFT_DT_AGENDA'], 3, 2) . '/' . substr($row['LFT_DT_AGENDA'], 1, 2);
         $VaidadeTMP = substr($row['LFT_DT_VALIDADE'], 5, 2) . '/' . substr($row['LFT_DT_VALIDADE'], 3, 2) . '/' . substr($row['LFT_DT_VALIDADE'], 1, 2);

         if ($RowConfig['Emb_LOTE'] == '1') {
            $QTDTMP = $row['LFT_QUANTIDADE'] * $row3['GIT_EMB_FOR'];
         } else {
            $QTDTMP = $row['LFT_QUANTIDADE'];
         }
         if ($ItensArray[$GIT_CODIGO]['GIT_DIAS_VENC'] > '0' && $ItensArray[$GIT_CODIGO]['GIT_DIAS_VENC'] <= $Venc_Dias) {
            $ItensProximo[$GIT_CODIGO]['PESO'] = '2';
            $ItensProximo[$GIT_CODIGO]['SECAO'] = str_pad($row3['GIT_SECAO'], 3, '0', STR_PAD_LEFT);
            $ItensProximo[$GIT_CODIGO]['GIT_CODIGO'] = $GIT_CODIGO;
            $ItensProximo[$GIT_CODIGO]['GIT_CODIGO_EAN13'] = $row3['GIT_CODIGO_EAN13'];
            $ItensProximo[$GIT_CODIGO]['GIT_ESTQ_ATUAL'] = $row3['GIT_ESTQ_ATUAL'];
            $ItensProximo[$GIT_CODIGO]['GIT_DESCRICAO'] = $row3['GIT_DESCRICAO'];

            if (empty($ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'])) {
               $ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'] = $QTDTMP;
               $ItensProximo[$GIT_CODIGO]['LFT_LOTE'][$row['LFT_LOTE']] = array('AGENDA' => $AgendaTMP, "DATA" => $VaidadeTMP, "QTD" => $QTDTMP, 'STATUS_COR' => 'bg-warning', 'COD_ESTATUS' => 'OPT02', 'DESC_ESTATUS' => 'Próximo do Vencimento');
            } else {
               if ($ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'] < $row3['GIT_ESTQ_ATUAL']) {
                  $ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'] = $QTDTMP + $ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'];
                  $ItensProximo[$GIT_CODIGO]['LFT_LOTE'][$row['LFT_LOTE']] = array('AGENDA' => $AgendaTMP, "DATA" => $VaidadeTMP, "QTD" => $QTDTMP, 'STATUS_COR' => 'bg-warning', 'COD_ESTATUS' => 'OPT02', 'DESC_ESTATUS' => 'Próximo do Vencimento');
               }
            }
         } else if ($ItensArray[$GIT_CODIGO]['GIT_DIAS_VENC'] <= 0) {
            $ItensProximo[$GIT_CODIGO]['PESO'] = '1';
            $ItensProximo[$GIT_CODIGO]['SECAO'] = str_pad($row3['GIT_SECAO'], 3, '0', STR_PAD_LEFT);
            $ItensProximo[$GIT_CODIGO]['GIT_CODIGO'] = $GIT_CODIGO;
            $ItensProximo[$GIT_CODIGO]['GIT_CODIGO_EAN13'] = $row3['GIT_CODIGO_EAN13'];
            $ItensProximo[$GIT_CODIGO]['GIT_ESTQ_ATUAL'] = $row3['GIT_ESTQ_ATUAL'];
            $ItensProximo[$GIT_CODIGO]['GIT_DESCRICAO'] = $row3['GIT_DESCRICAO'];
            if (empty($ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'])) {
               $ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'] = $QTDTMP;
               $ItensProximo[$GIT_CODIGO]['LFT_LOTE'][$row['LFT_LOTE']] = array('AGENDA' => $AgendaTMP, "DATA" => $VaidadeTMP, "QTD" => $QTDTMP, 'STATUS_COR' => 'bg-danger', 'COD_ESTATUS' => 'OPT01', 'DESC_ESTATUS' => 'Vencido');
            } else {
               if ($ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'] < $row3['GIT_ESTQ_ATUAL']) {
                  $ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'] = $QTDTMP + $ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'];
                  $ItensProximo[$GIT_CODIGO]['LFT_LOTE'][$row['LFT_LOTE']] = array('AGENDA' => $AgendaTMP, "DATA" => $VaidadeTMP, "QTD" => $QTDTMP, 'STATUS_COR' => 'bg-danger', 'COD_ESTATUS' => 'OPT01', 'DESC_ESTATUS' => 'Vencido');
               }
            }
         } else if ($ItensArray[$GIT_CODIGO]['GIT_DIAS_VENC'] > $Venc_Dias) {
            $ItensProximo[$GIT_CODIGO]['PESO'] = '3';
            $ItensProximo[$GIT_CODIGO]['SECAO'] = str_pad($row3['GIT_SECAO'], 3, '0', STR_PAD_LEFT);
            $ItensProximo[$GIT_CODIGO]['GIT_CODIGO'] = $GIT_CODIGO;
            $ItensProximo[$GIT_CODIGO]['GIT_CODIGO_EAN13'] = $row3['GIT_CODIGO_EAN13'];
            $ItensProximo[$GIT_CODIGO]['GIT_ESTQ_ATUAL'] = $row3['GIT_ESTQ_ATUAL'];
            $ItensProximo[$GIT_CODIGO]['GIT_DESCRICAO'] = $row3['GIT_DESCRICAO'];


            if (empty($ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'])) {
               $ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'] = $QTDTMP;
               $ItensProximo[$GIT_CODIGO]['LFT_LOTE'][$row['LFT_LOTE']] = array('AGENDA' => $AgendaTMP, "DATA" => $VaidadeTMP, "QTD" => $QTDTMP, 'STATUS_COR' => 'bg-success', 'COD_ESTATUS' => 'OPT03', 'DESC_ESTATUS' => 'Dentro da Validade');
            } else {
               if ($ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'] <  $row3['GIT_ESTQ_ATUAL']) {
                  $ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'] = $QTDTMP + $ItensProximo[$GIT_CODIGO]['TOTAL_LOTE'];
                  $ItensProximo[$GIT_CODIGO]['LFT_LOTE'][$row['LFT_LOTE']] = array('AGENDA' => $AgendaTMP, "DATA" => $VaidadeTMP, "QTD" => $QTDTMP, 'STATUS_COR' => 'bg-success', 'COD_ESTATUS' => 'OPT03', 'DESC_ESTATUS' => 'Dentro da Validade');
               }
            }
         }
      }
   }
}
$ItensArray = array_merge($ItensProximo);
echo json_encode($ItensArray);
