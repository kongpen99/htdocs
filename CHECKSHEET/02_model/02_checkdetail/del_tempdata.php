<?php
//* rev data : 01_view > 02_checkdetail > del_tempdata.js
include "../../../Include/class/connect_sql.php";
include "../../../00_function/function_php.php";
$mDBConn = new CSQL;
$server = '172.22.64.11';
$database = 'PRODOC';
$mDBConn->connect($server , $database);
date_default_timezone_set("Asia/Bangkok");
$year_month = date("Ym");
$ymd = date("Ymd");
$docdid = $_POST['DOCD_DID'];
$empcode = $_POST['EMPID'];
$shift = $_POST['SHIFT'];
$line = $_POST['LINE'];
$mc = $_POST['MC'];
$std = '';
$picArr = ['DOC_PIC1','DOC_PIC2','DOC_PIC3','DOC_PIC4','DOC_PIC5'];


/**
 * * หาจำนวนข้อที่ต้องลบก่อน
 */
$findLNNO = "SELECT [DOC_LNNO] FROM [DOCTEMP_TBL] 
WHERE [DOC_DID] = '".$docdid."' 
AND [DOC_EMPID] = '".$empcode."'
AND [DOC_LINE] = '".$line."'
AND [DOC_SHIFT] = '".$shift."' 
AND [DOC_MC] = '".$mc."'";
$mDBConn->Query($findLNNO);
$findLNNO2 = $mDBConn->FetchData();
for($j=0; $j<sizeof($findLNNO2); $j++) {
    /**
    * * คือตรวจหาก่อนว่า DOC_PIC1 - 5 ของข้อมูลที่ผ่านมา มีการบันทึกภาพเข้ามาไหม
    * * if(!empty($find_old_data_picture2)) คือมีการบันทึกภาพเข้ามาจึงจะทำการลบออก
    */
    for($i=0; $i<sizeof($picArr); $i++) {
        $find_old_data_picture = "SELECT ".$picArr[$i]." FROM DOCTEMP_TBL 
        WHERE [DOC_DID] = '".$docdid."'
        AND [DOC_EMPID] = '".$empcode."'
        AND [DOC_LINE] = '".$line."'
        AND [DOC_MC] = '".$mc."'
        AND [DOC_SHIFT] = '".$shift."'
        AND [DOC_LNNO] = '".$findLNNO2[$j]['DOC_LNNO']."'
        AND [DOC_RESULT] = 'Incorrect'";
        $mDBConn->Query($find_old_data_picture);
        $find_old_data_picture2 = $mDBConn->FetchData();
        if(!empty($find_old_data_picture2)) {
            $target_del = $find_old_data_picture2[0][$picArr[$i]];
            if (unlink('../../PictureAttached/'.$target_del)) {
                // echo 'The file ' . $filename . ' was deleted successfully!';
                //array_push($pic_old,$target_del);
            } else {
                // echo 'There was a error deleting the file ' . $filename;
                //array_push($pic_old,null);
            }
        }
    }
}

//* ลบ
$delete = "DELETE FROM [DOCTEMP_TBL] WHERE
[DOC_DID] = '".$docdid."' AND
[DOC_EMPID] = '".$empcode."' AND
[DOC_LINE] = '".$line."' AND
[DOC_SHIFT] = '".$shift."' AND
[DOC_MC] = '".$mc."'";
$mDBConn->Query($delete);

//* ตรวจสอบว่าลบได้จริงใช่ไหม
$checkdelete = "SELECT * FROM [DOCTEMP_TBL] WHERE
[DOC_DID] = '".$docdid."' AND
[DOC_EMPID] = '".$empcode."' AND
[DOC_LINE] = '".$line."' AND
[DOC_SHIFT] = '".$shift."' AND
[DOC_MC] = '".$mc."'";
$mDBConn->Query($checkdelete);
$checkdelete2 = $mDBConn->FetchData();

if(empty($checkdelete2)){
    $std = true;
} else {
    $std = false;
}

$array_data = array('std' => $std);
echo json_encode($array_data);
?>