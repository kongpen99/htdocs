<?php
include "../../../Include/class/connect_sql.php";
$mDBConn = new CSQL;
$server = '172.22.64.11';
$database = 'PRODOC';
$mDBConn->connect($server , $database);
date_default_timezone_set("Asia/Bangkok");
$DOCD_DID = $_POST['DOCD_DID'];

$select = "SELECT * FROM [DOCD_TBL] WHERE [DOCD_DID] = '".$DOCD_DID."' ORDER BY [DOCD_LNNO] ASC";
$mDBConn->Query($select);
$select2 = $mDBConn->FetchData();
if(!empty($select2)) {
    $array_data = array('std' => true , 'result' => $select2);
} else {
    $array_data = array('std' => false , 'result' => null);
}
echo json_encode($array_data);
?>