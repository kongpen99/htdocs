<?php
include "../../../Include/class/connect_sql.php";
include "../../../00_function/function_php.php";
$mDBConn = new CSQL;
$server = '172.22.64.11';
$database = 'PRODOC';
$mDBConn->connect($server , $database);
date_default_timezone_set("Asia/Bangkok");
$year_month = date("Ym");
$year_month_date = date("Y-m-d");
// $array_data = array();
$HID = $_POST['HID'];
$DID = $_POST['DID'];
$shift = $_POST['shift'];
$line = $_POST['line'];
$mc = $_POST['mc'];
$revision = $_POST['revision'];
$empcode = $_POST['empcode'];
$empname = $_POST['empname'];
$empdept = $_POST['empdept'];
// $result = array();

$getchoice_detail = "SELECT
DH.[DOCH_HID] , 
DH.[DOCH_HID] , 
DH.[DOCH_REV] , 
DH.[DOCH_NAME] ,
DC.[DOCD_LNNO] ,
DC.[DOCD_QDESC]
FROM [DOCH_TBL] AS DH 
INNER JOIN [DOCD_TBL] AS DC
ON (DH.DOCH_DID = DC.DOCD_DID)
WHERE DH.[DOCH_HID] = '".$HID."'
AND DC.[DOCD_DID] = '".$DID."'";
$mDBConn->Query($getchoice_detail);
$getchoice_detail2 = $mDBConn->FetchData();


$get_temp = "SELECT 
DT.[DOC_HID],
DT.[DOC_DID],
DT.[DOC_REV],
DT.[DOC_LNNO],
DT.[DOC_LINE],
DT.[DOC_MC],
DT.[DOC_ANSWER],
DT.[DOC_DATETIME]
FROM [PRODOC].[dbo].[DOCTEMP_TBL] AS DT
WHERE DT.[DOC_HID] = '".$HID."'
AND DT.[DOC_DID] = '".$DID."'
AND DT.[DOC_REV] = '".$revision."'
AND DT.[DOC_EMPID] = '".$empcode."'
AND DT.[DOC_MC] = '".$mc."'
AND DT.[DOC_LINE] = '".$line."'
AND CONVERT(VARCHAR(25), DT.[DOC_DATETIME], 126) LIKE '".$year_month_date."%'";
$mDBConn->Query($get_temp);
$get_temp2 = $mDBConn->FetchData();

$result = array('choice_detail'=> $getchoice_detail2 , 'get_temp'=> $get_temp2);
// $result = array('choice_detail'=> $getchoice_detail2);
echo json_encode($result);
?>