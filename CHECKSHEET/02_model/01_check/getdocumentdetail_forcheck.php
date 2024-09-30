<?php
include "../../../Include/class/connect_sql.php";
$mDBConn = new CSQL;
$server = '172.22.64.11';
$database = 'PRODOC';
$mDBConn->connect($server , $database);
date_default_timezone_set("Asia/Bangkok");
$DOCD_DID = $_POST['DOCD_DID'];
$EMPID = $_POST['EMPID'];
$LINE = $_POST['LINE'];
$MC = $_POST['MC'];
$SHIFT = $_POST['SHIFT'];



$select = "SELECT * FROM [DOCD_TBL] WHERE [DOCD_DID] = '".$DOCD_DID."' ORDER BY [DOCD_LNNO] ASC";
$mDBConn->Query($select);
$select2 = $mDBConn->FetchData();
if(!empty($select2)) {
    //$array_data = array('std' => true , 'result' => $select2);

    //* SQL หาว่ามีข้อมูลอยู่ที่ TB:TEMP บ้างไหม
    $findIntemp = "SELECT * FROM [DOCTEMP_TBL] WHERE [DOC_DID] = '".$DOCD_DID."'
                    AND [DOC_EMPID] = '".$EMPID."'
                    AND [DOC_LINE] = '".$LINE."'
                    AND [DOC_MC] = '".$MC."'
                    AND [DOC_SHIFT] = '".$SHIFT."'
                    ORDER BY [DOC_LNNO] ASC";
    $mDBConn->Query($findIntemp);
    $findIntemp2 = $mDBConn->FetchData();
    
    if(!empty($findIntemp2)) {
        $array_data = array(
            'std' => true , 
            'result' => $select2 , 
            'stdtemp' => true , 
            'resulttemp' => $findIntemp2
        );
    }else{
        $array_data = array(
            'std' => true , 
            'result' => $select2 , 
            'stdtemp' => false , 
            'resulttemp' => null
        );
    }

} else {
    $array_data = array('std' => false , 'result' => null);
}
echo json_encode($array_data);
?>