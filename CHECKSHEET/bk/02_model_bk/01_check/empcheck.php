<?php
include "../../../Include/class/connect_sql.php";
$mDBConn = new CSQL;
$server = '172.22.64.11';
$database = 'PRODOC';
$mDBConn->connect($server , $database);
date_default_timezone_set("Asia/Bangkok");
$empid = $_POST['empid'];
$select = "SELECT * FROM [USERS_TBL] WHERE [USERS_EMPID] = '".$empid."'";
$mDBConn->Query($select);
$select2 = $mDBConn->FetchData();
if(!empty($select2)) {
    $array_data = array('std' => true , 'result' => $select2);
} else {
    $array_data = array('std' => false , 'result' => null);
}
echo json_encode($array_data);
?>