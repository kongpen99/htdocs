<?php
include "../../../Include/class/connect_sql.php";
include "../../../00_function/function_php.php";
$mDBConn = new CSQL;
$server = '172.22.64.11';
$database = 'PRODOC';
$mDBConn->connect($server , $database);
date_default_timezone_set("Asia/Bangkok");
$year_month = date("Ym");
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
$sqldetail = array();

$PRODOC_GETRUNNO = "EXEC [dbo].[PRODOC_GETRUNNO]";
$PRODOC_GETRUNNO .= "'DCS-R'";
$mDBConn->Query($PRODOC_GETRUNNO);
$reslut = $mDBConn->FetchData();

//* FN_SET_RUNNO from:function_php.php
$RID = FN_SET_RUNNO($reslut[0]['RUNNO'] , $year_month , $reslut[0]['CD'] , 6);

/**
 * * 1.SQL หาว่ามีข้อมูลอยู่ที่ TB:TEMP บ้างไหม
 */
$findIntemp = "SELECT * FROM [DOCTEMP_TBL] WHERE [DOC_DID] = '".$DID."'
                AND [DOC_EMPID] = '".$empcode."'
                AND [DOC_LINE] = '".$line."'
                AND [DOC_MC] = '".$mc."'
                AND [DOC_SHIFT] = '".$shift."'
                ORDER BY [DOC_LNNO] ASC";
$mDBConn->Query($findIntemp);
$findIntemp2 = $mDBConn->FetchData();
if(!empty($findIntemp2)) {
    /**
     * * 2.procedure สำหรับบันทึกในตาราง main : [DOCRH_TBL]
     */
    $PRODOC_NEWDOCRH  = "EXEC [dbo].[PRODOC_NEWDOCRH]";
    $PRODOC_NEWDOCRH .= "'{$RID}' , '{$HID}' , {$revision} , '{$DID}' , '{$empcode}' , '{$empname}','{$empdept}','{$shift}','{$line}','{$mc}',0,0,''";
    $mDBConn->Query($PRODOC_NEWDOCRH);

    /**
     * * 3.for สำหรับนำข้อมูลจาก Fetch DOCTEMP_TBL ไป insert [DOCRD_TBL]
     */
    for($i=0;$i<sizeof($findIntemp2);$i++) {
        $PRODOC_NEWDOCRD  = "EXEC [dbo].[PRODOC_NEWDOCRD]";
        $PRODOC_NEWDOCRD .= "'{$DID}','{$RID}','{$findIntemp2[$i]['DOC_LNNO']}','{$findIntemp2[$i]['DOC_ANSWER']}','{$findIntemp2[$i]['DOC_RESULT']}','{$findIntemp2[$i]['DOC_REMARK']}'";
        $PRODOC_NEWDOCRD .= ",'{$findIntemp2[$i]['DOC_PIC1']}','{$findIntemp2[$i]['DOC_PIC2']}','{$findIntemp2[$i]['DOC_PIC3']}','{$findIntemp2[$i]['DOC_PIC4']}','{$findIntemp2[$i]['DOC_PIC5']}'";
        $PRODOC_NEWDOCRD .= ",'',''";
        $mDBConn->Query($PRODOC_NEWDOCRD);
        //array_push($sqldetail , $PRODOC_NEWDOCRD);
    }

    /**
     * * 4.ตรวจหาว่า RID มีใน DOCRH_TBL ไหม if = มี
     */
    $check_DOCRH = "SELECT * FROM [DOCRH_TBL] WHERE [DOCRH_RID] = '".$RID."'";
    $mDBConn->Query($check_DOCRH);
    $check_DOCRH2 = $mDBConn->FetchData();
    if(!empty($check_DOCRH2)) {

        /**
         * * 5.ตรวจหาว่า RID มีใน DOCRD_TBL (คือตร. Detail)
         * * 6.ถ้าเข้า if = มีแสดงว่า insert is successfully 
         * * 7.ก็จะลบการใช้งานคำสั่ง Delete Data ที่เก็บอยู่ใน TB:DOCTEMP_TBL
         */
        $check_DOCRD = "SELECT * FROM [DOCRD_TBL] WHERE [DOCRD_RID] = '".$RID."'";
        $mDBConn->Query($check_DOCRD);
        $check_DOCRD2 = $mDBConn->FetchData();
        if(!empty($check_DOCRD2)) {
            //* ลบ
            $delete = "DELETE FROM [DOCTEMP_TBL] WHERE
            [DOC_DID] = '".$DID."' AND
            [DOC_EMPID] = '".$empcode."' AND
            [DOC_LINE] = '".$line."' AND
            [DOC_SHIFT] = '".$shift."' AND
            [DOC_MC] = '".$mc."'";
            $mDBConn->Query($delete);

            //* ตรวจสอบว่าลบได้จริงใช่ไหม
            $checkdelete = "SELECT * FROM [DOCTEMP_TBL] WHERE
            [DOC_DID] = '".$DID."' AND
            [DOC_EMPID] = '".$empcode."' AND
            [DOC_LINE] = '".$line."' AND
            [DOC_SHIFT] = '".$shift."' AND
            [DOC_MC] = '".$mc."'";
            $mDBConn->Query($checkdelete);
            $checkdelete2 = $mDBConn->FetchData();

            if(empty($checkdelete2)){
                $std = true;
                $number = 1;

                //* +1 ให้กับ ID : DCS-R
                $PRODOC_ADDRUNNO = "EXEC [dbo].[PRODOC_ADDRUNNO]";
                $PRODOC_ADDRUNNO .= "'DCS-R'";
                $mDBConn->Query($PRODOC_ADDRUNNO);

            } else {
                $std = false;
                $number = 2;
            }

        } else {
            $std = false;
            $number = 4;            
        }

    } else {
        $std = false;
        $number = 3;
    }
}

/**
 * TODO : อธิบาย $number
 * * 1 = completed
 * * 2 = delete false
 * * 3 = insert header false (DOCRH_TBL)
 * * 4 = insert detail false (DOCRD_TBL)
 */
// $array_data = array(
//     'HID'=>$HID,
//     'DID'=>$DID,
//     'RID'=>$RID,
//     'empcode'=>$empcode,
//     'shift'=>$shift,
//     'line'=>$line,
//     'machine'=>$mc,
//     'empname'=>$empname,
//     'empdept'=>$empdept,
//     'revision'=>$revision,
//     //'sqldetail'=>$sqldetail,
//     'sizeof'=> sizeof($findIntemp2)
// );

$array_data = array('status' => $std , 'number' => $number);
echo json_encode($array_data);
?>